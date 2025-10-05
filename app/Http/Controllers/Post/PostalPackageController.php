<?php

namespace App\Http\Controllers\Post;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Models\Post\PostalPackage;
use App\Models\Tracing\Passport;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;

class PostalPackageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:postal show'])->only(['index', 'show']);
        $this->middleware(['permission:postal create'])->only(['create', 'store']);
        $this->middleware(['permission:postal edit'])->only(['edit', 'update']);
        $this->middleware(['permission:postal delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('postal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('postal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];

        $this->validate($request, array_merge([
            'name' => 'required|min:3',
            'phone_no' => 'required',
            'doc_price' => 'nullable|numeric',
            'post_price' => 'nullable|numeric',
        ], $rules));

        \DB::beginTransaction();

        // Disable log for manually logging
        activity()->disableLogging();

        $counts = PostalPackage::whereDate('created_at', '=', date('Y-m-d'))->count();
        $uid = date('ynj').++$counts;

        try {
            $misc = PostalPackage::create([
                'uid' => $uid,
                'department_id' => auth()->id(),
                'name' => $request->name,
                'status' => $request->status,
                'post' => $request->post,
                'date' => $request->date,
                'place' => $request->place,
                'address' => $request->address,
                'email' => $request->email,

                'street' => $request->street,
                'house_no' => $request->house_no,
                'doc_price' => $request->doc_price,
                'post_price' => $request->post_price,

                'phone' => $request->phone_no,
                'booking_id' => $request->booking_id ?? null,
                'description' => $request->description,
                'registrar_id' => auth()->id(),
            ]);

            foreach (range(1, 8) as $c) {
                if (request()->filled('name'.$c)) {
                    $misc->deliverables()->create([
                        'doc_type' => $request->input('doc_type'.$c),
                        'name' => $request->input('name'.$c),
                        'uid' => $request->input('uid'.$c),
                    ]);
                }
            }

            // associate checklist
            if ($request->filled('checklist')) {
                $misc->checklists()->attach(array_keys($request->checklist));
            }

            // new checklist in others' field
            if ($request->filled('others')) {
                $others = explode('-', $request->others);
                foreach ($others as $other) {
                    $misc->checklists()->create(['name' => $other]);
                }
            }

            // Disable log for manually logging
            activity()->enableLogging();

            // Log manually
            activity()
                ->causedBy(auth()->user())
                ->performedOn($misc)
                ->tap(function (Activity $activity) use (&$misc) {
                    $activity->properties = $activity
                        ->properties
                        ->put('attributes', $misc->only([
                            'name',
                            'address',
                            'email',
                            'phone',
                            'status',
                            'post',
                            'place',
                            'date',
                            'description',
                            'street',
                            'house_no',
                            'post_price',
                            'doc_price',
                        ]));
                    $activity->properties = $activity
                        ->properties
                        ->put('checklists', $misc->checklists()->pluck('name')->toArray());
                    $activity->properties = $activity
                        ->properties
                        ->put('deliverables', $misc->deliverables()->pluck('name')->toArray());
                })
                ->log('created');

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }

        // send notifaction to user email address
        if ($request->has('send_status_email')) {
            \App\Jobs\PostalPackageStatusChanged::dispatch($misc);
        }

        return redirect(route('postal.index'))
            ->with(['alert' => 'Action performed successfully']);
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
    public function edit(PostalPackage $postal)
    {
        $logs = Activity::with(['causer'])
            ->where('subject_type', 'App\Models\Post\PostalPackage')
            ->where('subject_id', $postal->id)
            ->latest()
            ->get();

        return view('postal.edit', compact('postal', 'logs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostalPackage $postal)
    {
        $rules = [];
        foreach (range(1, 8) as $c1) {
            // $rules['name' .$c1] = 'required';
            // $rules['doc_type' .$c1] = 'required_with:name'.$c1.',uid'.$c1;
            // $rules['name' .$c1] = 'required_with:doc_type'.$c1.',uid'.$c1;
            // $rules['uid' .$c1] = 'required_with:doc_type'.$c1.',name'.$c1;
        }

        $this->validate($request, array_merge([
            'name' => 'required|min:3',
            'phone_no' => 'required',
            'doc_price' => 'nullable|numeric',
            'post_price' => 'nullable|numeric',

        ], $rules));

        \DB::beginTransaction();

        // Disable log for manually logging
        activity()->disableLogging();
        try {
            $oldPostal = clone $postal;
            $postal->fill([
                'name' => $request->name,
                'status' => $request->status,
                'post' => $request->post,
                'date' => $request->date,
                'place' => $request->place,
                'address' => $request->address,
                'phone' => $request->phone_no,
                'description' => $request->description,
                'street' => $request->street,
                'house_no' => $request->house_no,
                'doc_price' => $request->doc_price,
                'post_price' => $request->post_price,
                'email' => $request->email,
            ]);
            $postal->save();

            foreach (range(1, 8) as $c) {
                if (request()->filled('id'.$c)) {
                    $postal->deliverables()->find($request->input('id'.$c))->update([
                        'doc_type' => $request->input('doc_type'.$c),
                        'name' => $request->input('name'.$c),
                        'uid' => $request->input('uid'.$c),
                    ]);
                } elseif (request()->filled('name'.$c)) {
                    $postal->deliverables()->create([
                        'doc_type' => $request->input('doc_type'.$c),
                        'name' => $request->input('name'.$c),
                        'uid' => $request->input('uid'.$c),
                    ]);
                }
            }

            // associate checklist
            if ($request->filled('checklist')) {
                $postal->checklists()->sync(array_keys($request->checklist));
            }

            // new checklist in others' field
            if ($request->filled('others')) {
                $others = explode('-', $request->others);
                foreach ($others as $other) {
                    $postal->checklists()->create(['name' => $other]);
                }
            }

            // Disable log for manually logging
            activity()->enableLogging();

            // Log manually
            activity()
                ->causedBy(auth()->user())
                ->performedOn($postal)
                ->tap(function (Activity $activity) use (&$postal, &$oldPostal) {
                    $activity->properties = $activity
                        ->properties
                        ->put('attributes', $postal->getChanges());

                    $activity->properties = $activity
                        ->properties
                        ->put('old', $oldPostal->only(array_keys($postal->getChanges())));

                    $activity->properties = $activity
                        ->properties
                        ->put('checklists', $postal->checklists()->pluck('name')->toArray());

                    $activity->properties = $activity
                        ->properties
                        ->put('deliverables', $postal->deliverables()->pluck('name')->toArray());
                })
                ->log('updated');

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }

        // send notifaction to user email addres
        if ($oldPostal->status != $postal->status && $request->has('send_status_email')) {
            \App\Jobs\PostalPackageStatusChanged::dispatch($postal);
        }

        return redirect(route('postal.index'))
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

    public function dataTable()
    {
        $postal = PostalPackage::with(['deliverables', 'registrar:id,first_name,last_name', 'booking:id,serial_no'])->select('postal_packages.*');

        if (! request()->order) {
            $postal->latest();
        }

        return Datatables::of($postal)
            ->addColumn('action', function ($postal) {
                $action = '<a href="'.route('postal.edit', $postal->id).'" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></a>&nbsp;';

                // $action .= '<a href="' . route('users.reset', $postal->id) .'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure want to reset user password?\')"><i class="fa fa-recycle"></i></a>&nbsp;';
                // $action .= '<a href="' . route('users.edit', $postal->id) .'" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>';
                return $action;
            })
            ->addColumn('documents', function (PostalPackage $postal) {
                $deliverables = optional($postal->deliverables)->all();

                $deliverables = array_map(function ($value) {
                    return str_replace(' ', '-', $value->name)."\n";
                    // return $value->doc_type . "|" . str_replace(' ', '.', $value->name) . "|" . $value->uid . "\n";
                }, $deliverables);

                return nl2br(implode('', $deliverables));
            })
            ->addColumn('by', function (PostalPackage $postal) {
                return optional($postal->registrar)->first_name.' '.optional($postal->registrar)->last_name;
            })
            ->editColumn('booking.serial_no', function ($postal) {
                if ($postal->booking) {
                    $action = '<a href="'.route('bookings.show', optional($postal->booking)->id).'" >'.optional($postal->booking)->serial_no.'</a>';
                }

                return $action ?? null;
            })
            ->rawColumns(['documents', 'action', 'booking.serial_no'])
            ->addIndexColumn()
            ->make(true);
    }

    public function new($type, $modelId)
    {
        $details = null;

        if ($type == 'passport') {
            $passport = Passport::findOrFail($modelId);
            $doc = $passport->trace;

            $details = [
                'name' => $doc->applicant,

            ];
        } elseif ($type == 'misc') {

        } else {

        }
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

        return view('postal.import', compact('booking'));
    }

    /**
     * reject the postal package
     *
     * @param  Booking  $booking  Description
     * @return type
     **/
    public function reject(PostalPackage $postal)
    {
        $desc = $postal->description;

        $desc .= "\n___________________________________\n";
        $desc .= 'Rejected by: '.auth()->user()->email."\n";
        $desc .= request()->reason;

        $postal->description = $desc;
        $postal->status = 'Rejected';
        $postal->save();

        \App\Jobs\PostalPackageRejected::dispatch($postal, request()->reason);

        return redirect(route('postal.edit', $postal->id))
            ->with(['alert' => 'Action performed successfully']);
    }
}
