<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\PaymentService;
use App\Models\Finance\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:receipts show'])->only(['index', 'show', 'dataTable']);
        $this->middleware(['permission:receipts create'])->only(['create', 'store']);
        $this->middleware(['permission:receipts edit'])->only(['edit', 'update']);
        $this->middleware(['permission:receipts delete'])->only(['destroy']);
        $this->middleware(['permission:receipts print'])->only(['print']);
    }

    /**
     * Display the statistics of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $statistics = \DB::table('receipts as r')
            ->leftJoin('transactions as t', function ($join) {
                $join->on('r.id', '=', 't.accountable_id')
                    ->where('t.accountable_type', '=', Receipt::class);
            })
            ->leftJoin('users as u', 'r.accountant_id', '=', 'u.id')
            ->groupBy('r.date', 'r.accountant_id')
            ->whereNull('r.clearance_id')
            ->whereNull('r.deleted_at')
            ->select([
                'r.date',
                'r.accountant_id',
                \DB::raw('concat(u.first_name, " " , u.last_name) as user'),
                // '',
                \DB::raw('SUM(t.amount) as amount'),
            ])
            ->get();

        return view('finance.receipts.dashboard', compact('statistics'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('finance.receipts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('finance.receipts.create');
    }

    /**
     * Show the form for creating a new online payment method resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function online()
    {
        $latestReceipt = Receipt::whereNotNull('bill_no')
            ->where('payment_method', 'card')
            ->latest()
            ->first();

        return view('finance.receipts.online', compact('latestReceipt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validations
        $servicesIdInString = implode(', ', PaymentService::active()->get()->pluck('id')->toArray()); // like '1,2,3,...'

        if ($request->ajax()) {
            $this->validate($request, [
                'client_name' => 'required|min:2|max:191',
                'id_card' => 'nullable|max:191',
                'service_id' => 'required|numeric|in:'.$servicesIdInString,
            ]);

        } else {
            $this->validate($request, [
                'client_name' => 'required|min:2|max:191',
                'id_card' => 'nullable|max:191',
                'service_id' => 'required|numeric|in:'.$servicesIdInString,
                'quantity' => 'required|min:1',
                'amount' => 'nullable|min:0.1',
            ]);

        }

        \DB::beginTransaction();

        try {

            $service = PaymentService::findOrFail($request->service_id);

            $receiptNo = Receipt::generateSerialNo();

            $newReceipt = Receipt::create([
                'receipt_no' => $receiptNo,
                'date' => date('Y-m-d'),
                'client_name' => $request->client_name,
                'id_card' => $request->id_card,
                'service_id' => $request->service_id,
                'received_by' => auth()->id(),
                'accountant_id' => auth()->id(),
                'registrar_id' => auth()->id(),
                'quantity' => $request->quantity,
                'remarks' => $request->remarks,
                'bill_no' => $request->bill_no,
                'payment_method' => $request->ajax() ? 'cash' : 'card',
            ]);

            if ($request->ajax()) {
                $amount = $service->amount;
            } else {
                $amount = $request->filled('amount')
                    ? $request->amount
                    : $service->amount * $request->quantity;
            }

            $newReceipt->transaction()->create([
                'type' => 'income',
                'amount' => $amount,
                'currency' => $service->currency,
                'registrar_id' => auth()->id(),
            ]);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();

            return abort(500, $e->getMessage());
        }

        if ($request->ajax()) {
            return response()->json(['receiptNo' => $newReceipt->id], 200);
        }

        return back()->with(['alert' => 'Receipt registered sucessfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * print on pdf page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print(Receipt $receipt)
    {
        $tempName = 'templates/receipt-fixed.pdf';
        $receipt->load(['transaction', 'service']);

        try {

            $writableData = [
                'receipt_no' => $receipt->receipt_no,
                'date' => $receipt->date->format('d M Y'),
                'transaction_no' => $receipt->transaction_no,
                'client_name' => $receipt->client_name.($receipt->id_card ? " ({$receipt->id_card})" : ''),
                'service_name' => optional($receipt->service)->name,
                'amount' => optional($receipt->transaction)->amount.' '.optional($receipt->transaction)->currency,
                'received_by' => optional($receipt->registrar)->fullName.' by '.$receipt->payment_method.'('.$receipt->bill_no.')',
            ];
            $pdf = new \FPDM($tempName);
            $pdf->Load($writableData, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
            // $pdf->Image(route('image.show',['employee', $photo->path]),20,100);
            $pdf->Merge();
            $pdf->Output();

        } catch (\Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    public function dataTable()
    {
        $receipts = Receipt::with([
            'registrar:id,first_name,last_name',
            'transaction',
            'service:id,name',
        ])->cleared()->select('receipts.*');

        if (! request()->order) {
            $receipts->latest();
        }

        return datatables()::of($receipts)
            ->addColumn('action', function ($r) {
                $action = '<a href="'.route('receipts.print', $r->id).'" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>&nbsp;';

                // $action .= '<a href="' . route('bookings.edit', $booking->id) .'" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>';
                return $action;
            })
            ->editColumn('transaction.amount', function ($r) {
                return optional($r->transaction)->amount.' '.optional($r->transaction)->currency;
            })
            ->addIndexColumn()
            ->make(true);
    }
}
