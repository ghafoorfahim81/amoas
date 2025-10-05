<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Clearance;
use App\Models\Finance\Receipt;
use Illuminate\Http\File;
use Illuminate\Http\Request;

class ClearanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:clearance show'])->only(['index', 'show', 'dataTable']);
        $this->middleware(['permission:clearance create'])->only(['create', 'store']);
        $this->middleware(['permission:clearance edit'])->only(['edit', 'update']);
        $this->middleware(['permission:clearance delete'])->only(['destroy']);
        $this->middleware(['permission:clearance print'])->only(['print']);
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
            ->groupBy('r.accountant_id')
            ->whereNotNull('r.clearance_id')
            ->select([
                'r.accountant_id',
                \DB::raw('concat(u.first_name, " " , u.last_name) as user'),
                // '',
                \DB::raw('SUM(t.amount) as amount'),
            ])
            ->get();

        return view('finance.clearance.dashboard', compact('statistics'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('finance.clearance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('finance.clearance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userIds = implode(', ', \App\User::with('role')->whereIn('role_id', [1, 3])->get()->pluck('id')->toArray());
        $this->validate($request, [
            'date' => 'required|date',
            'receiver_account' => 'required|numeric|in:'.$userIds,
            'deliver_account' => 'required|numeric|different:receiver_account|in:'.$userIds,
            'clear_from' => 'required|date',
            'clear_to' => 'required|date|after_or_equal:clear_from',
            'file' => 'required|file|mimes:pdf',
        ]);

        \DB::beginTransaction();

        try {

            // find the specified date transactions
            $receiptsCount = Receipt::where('accountant_id', $request->deliver_account)
                ->whereBetween('date', [$request->clear_from, $request->clear_to])
                ->count();

            if ($receiptsCount <= 0) {
                throw new \Exception('No transaction made by the selected user account between '.$request->clear_from.' to '.$request->clear_to);
            }

            $newClearance = Clearance::create([
                'date' => $request->date,
                'receiver_account' => $request->receiver_account,
                'deliver_account' => $request->deliver_account,
                'clear_from' => $request->clear_from,
                'clear_to' => $request->clear_to,
                'remarks' => $request->remarks,
                'registrar_id' => auth()->id(),
            ]);

            if ($request->hasFile('file')) {

                $extension = $request->file->getClientOriginalExtension();

                $fullPath = \Storage::disk('finance')->putFile(time().'000'.$newClearance->id, new File($request->file));

                $newClearance->attachments()->create([
                    'label' => $request->file->getClientOriginalName(),
                    'path' => $fullPath,
                    'mime_type' => $extension,
                ]);
            }

            //update all at once
            Receipt::where('accountant_id', $request->deliver_account)
                ->whereBetween('date', [$request->clear_from, $request->clear_to])
                ->update([
                    'clearance_id' => $newClearance->id,
                    'accountant_id' => $request->receiver_account,
                ]);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();

            return abort(500, $e->getMessage());
        }

        return redirect(route('clearance.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Clearance $clearance)
    {
        $clearance->load(['receipts.transaction', 'receipts.service', 'receipts.registrar']);

        return view('finance.clearance.show', compact('clearance'));
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
    public function print(Clearance $clearance)
    {
        $attachment = $clearance->attachments;
        $filePath = \Storage::disk('finance')->path($attachment->path);

        return response()->file($filePath);
    }

    public function dataTable()
    {
        $clearances = Clearance::with([
            'registrar:id,first_name,last_name',
            'receiver:id,first_name,last_name',
            'deliver:id,first_name,last_name',
        ])->leftJoin('receipts as r', 'clearance.id', '=', 'r.clearance_id')
            ->leftJoin('transactions as t', function ($join) {
                $join->on('r.id', '=', 't.accountable_id')
                    ->where('t.accountable_type', '=', Receipt::class);
            })
            ->select([
                'clearance.*',
                \DB::raw('sum(t.amount) as amount'),
            ])
            ->groupBy('id');

        if (! request()->order) {
            $clearances->latest();
        }

        return datatables()::of($clearances)
            ->addColumn('action', function ($r) {
                $action = '<a href="'.route('clearance.show', $r->id).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>&nbsp;';

                // $action .= '<a href="' . route('bookings.edit', $booking->id) .'" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>';
                return $action;
            })
            // ->editColumn('transaction.amount', function($r){
            //     return optional($r->transaction)->amount . ' ' . optional($r->transaction)->currency;
            // })
            ->addIndexColumn()
            ->make(true);
    }
}
