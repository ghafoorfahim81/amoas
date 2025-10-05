<?php

namespace App\Http\Controllers\Tracing;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Models\Tracing\Miscellaneous;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class MiscellaneousController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:misc show'])->only(['index', 'show']);
        $this->middleware(['permission:misc create'])->only(['create', 'store']);
        $this->middleware(['permission:misc edit'])->only(['edit', 'update']);
        $this->middleware(['permission:misc change status'])->only(['changeStatus']);
        $this->middleware(['permission:booking delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tracing.misc.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tracing.misc.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'applicant' => 'required|min:3',
            'email' => 'required|email',
            'alt_email' => 'nullable|email',
            'doc_type' => 'required',
            'noti_lang' => 'required',
        ]);

        \DB::beginTransaction();

        $userDep = optional(auth()->user()->department);
        $uid = \App\Models\Tracing\Document::UID($request, $userDep->code);

        $misc = Miscellaneous::create([
            'uid' => $uid,
            'department_id' => $userDep->id,
            'alt_email' => $request->alt_email,
            'doc_type' => $request->doc_type,
            'noti_lang' => $request->noti_lang,
            'booking_id' => $request->booking_id ?? null,
            'phone_no' => $request->phone_no,
            'descriptions' => $request->descriptions,
            'registrar_id' => auth()->id(),
        ]);

        $misc->trace()->create([
            'uid' => $uid,
            'status' => __('app.processingState', [], $request->noti_lang ?? 'en') ?? 'Processing',
            'department_id' => $userDep->id,
            'is_public' => 1,
            'registrar_id' => auth()->id(),
            'applicant' => $request->applicant,
            'email' => $request->email,
        ]);

        \DB::commit();

        return redirect(route('misc.index'))
            ->with(['alert' => 'Action performed successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Miscellaneous $misc)
    {
        $misc->load(['type', 'trace']);

        return view('tracing.misc.view', compact('misc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Miscellaneous $misc)
    {
        $misc->load(['type', 'trace']);

        return view('tracing.misc.edit', compact('misc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Miscellaneous $misc)
    {
        $this->validate($request, [
            'applicant' => 'required|min:3',
            'email' => 'required|email',
            'alt_email' => 'nullable|email',
            'doc_type' => 'required',
            'noti_lang' => 'required',
            'is_public' => 'required',
        ]);

        \DB::beginTransaction();

        $misc->update([
            'alt_email' => $request->alt_email,
            'doc_type' => $request->doc_type,
            'noti_lang' => $request->noti_lang,
            'phone_no' => $request->phone_no,
            'descriptions' => $request->descriptions,
        ]);

        $misc->trace()->update([
            'is_public' => $request->is_public,
            'applicant' => $request->applicant,
            'email' => $request->email,
        ]);

        \DB::commit();

        return redirect(route('misc.show', $misc->id))
            ->with(['alert' => 'Action performed successfully']);
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
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataTable()
    {
        $tableName = (new Miscellaneous)->getTable();
        $misc = Miscellaneous::with(['type:id,type', 'trace', 'booking:id,serial_no'])->select("{$tableName}.*");

        if (! request()->order) {
            $misc->latest();
        }

        return Datatables::of($misc)
            ->addColumn('action', function ($m) {
                $action = '<a href="'.route('misc.show', $m->id).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';

                // $action .= '<a href="' . route('misc.edit', $m->id) .'" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></a>';
                return $action;
            })
            ->addColumn('isPublic', function ($m) {
                $action = optional($m->trace)->is_public == 1 ? '<span class="badge badge-info">Yes</span>' : '<span class="badge badge-dark">No</span>';

                // $action .= '<a href="' . route('bookings.edit', $booking->id) .'" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>';
                return $action;
            })
            ->editColumn('booking.serial_no', function ($m) {
                if ($m->booking) {
                    $action = '<a href="'.route('bookings.show', optional($m->booking)->id).'" >'.optional($m->booking)->serial_no.'</a>';
                }

                return $action ?? null;
            })
            ->rawColumns(['isPublic', 'action', 'booking.serial_no'])
            ->addIndexColumn()
            ->make(true);
    }

    public function changeStatus(Miscellaneous $misc)
    {
        return view('tracing.misc.change-status', compact('misc'));
    }

    public function status(Request $request, Miscellaneous $misc)
    {
        $this->validate($request, [
            'status' => 'required|max:255',
            'send' => 'required',
        ]);
        $misc->trace()->update([
            'status' => $request->status,
            'note' => $request->note,
        ]);

        if ($request->send == 1) {
            $misc->load(['trace', 'department']);
            \App\Jobs\TracingStatusChanged::dispatch($misc, $misc->noti_lang);
        }

        return redirect(route('misc.show', $misc->id))
            ->with(['alert' => 'Action performed successfully']);
    }

    /**
     * import from bookings data
     *
     * @param  Booking  $booking  Description
     * @return type
     **/
    public function import(Booking $booking)
    {
        $booking->load(['user', 'info']);

        return view('tracing.misc.import', compact('booking'));
    }
}
