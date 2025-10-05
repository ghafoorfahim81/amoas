<?php

namespace App\Http\Controllers\Passport;

use App\Http\Controllers\Controller;
use App\Models\Passport\PassportExtension;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExtensionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('passport.extension.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('passport.extension.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pass_no' => 'required|min:3',
            'given_name' => 'required',
            'last_name' => 'required',
        ]);

        \DB::beginTransaction();

        try {

            $newExt = PassportExtension::create([
                'pass_no' => strtoupper($request->pass_no),
                'given_name' => ucwords($request->given_name),
                'last_name' => strtoupper($request->last_name),
                'status' => 'registered',
                'phone' => $request->phone,
                'invoice_no' => $request->invoice_no,
                'remarks' => $request->remarks,
                'registrar_id' => auth()->id(),
            ]);

            foreach (range(1, 6) as $c) {
                if (request()->filled('pass_no'.$c) || request()->filled('given_name'.$c)) {
                    $newExt->members()->create([
                        'pass_no' => strtoupper($request->get('pass_no'.$c)),
                        'given_name' => ucwords($request->get('given_name'.$c)),
                        'last_name' => strtoupper($request->get('last_name'.$c)),
                        'registrar_id' => auth()->id(),
                        'status' => 'registered',
                        'phone' => $request->phone,
                    ]);
                }
            }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }

        return redirect(route('extensions.show', $newExt->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PassportExtension $extension)
    {
        $extension->load('members');

        return view('passport.extension.show', compact('extension'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PassportExtension $extension)
    {
        $extension->load('members');

        return view('passport.extension.edit', compact('extension'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PassportExtension $extension)
    {
        $this->validate($request, [
            'pass_no' => 'required|min:3',
            'given_name' => 'required',
            'last_name' => 'required',
            'member.*.pass_no' => 'required',
            'member.*.given_name' => 'required',
            'member.*.last_name' => 'required',
        ]);

        \DB::beginTransaction();

        try {

            $extension->update([
                'pass_no' => strtoupper($request->pass_no),
                'given_name' => ucwords($request->given_name),
                'last_name' => strtoupper($request->last_name),
                'phone' => $request->phone,
                'invoice_no' => $request->invoice_no,
                'remarks' => $request->remarks,
                'postal_code' => $request->postal_code,
                'place' => $request->place,
                'street' => $request->street,
                'house_no' => $request->house_no,
            ]);

            foreach ($request->member as $key => $value) {
                $member = PassportExtension::findOrFail($key);
                $member->update([
                    'pass_no' => strtoupper($value['pass_no']),
                    'given_name' => ucwords($value['given_name']),
                    'last_name' => strtoupper($value['last_name']),
                ]);
            }

            foreach (range(1, 2) as $c) {
                if (request()->filled('pass_no'.$c) || request()->filled('given_name'.$c)) {
                    $extension->members()->create([
                        'pass_no' => strtoupper($request->get('pass_no'.$c)),
                        'given_name' => ucwords($request->get('given_name'.$c)),
                        'last_name' => strtoupper($request->get('last_name'.$c)),
                        'registrar_id' => auth()->id(),
                        'status' => 'registered',
                        'phone' => $request->phone,
                    ]);
                }
            }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }

        return redirect(route('extensions.show', $extension->id));
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
     * Change the status of model
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(PassportExtension $extension, Request $request)
    {
        if ($extension->status == $request->status) {
            return back();
        }

        \DB::beginTransaction();

        try {

            $extension->update(['status' => $request->status]);
            $extension->members()->update(['status' => $request->status]);
            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }

        return redirect(route('extensions.show', $extension->id));
    }

    public function dataTable()
    {
        $extension = PassportExtension::with(['registrar:id,first_name,last_name', 'members'])
            ->whereNull('family_id')
            ->select('passport_extensions.*');

        if (! request()->order) {
            $extension->latest();
        }

        return DataTables::of($extension)
            ->addColumn('action', function ($e) {
                $action = '<a href="'.route('extensions.show', $e->id).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';

                return $action;
            })
            ->addColumn('total_member', function ($e) {
                return optional($e->members)->count();
            })
            ->addColumn('members', function ($e) {
                $deliverables = optional($e->members)->all();

                $deliverables = array_map(function ($value) {
                    return $value->given_name.' '.$value->last_name."\n";
                    // return $value->doc_type . "|" . str_replace(' ', '.', $value->name) . "|" . $value->uid . "\n";
                }, $deliverables);

                return nl2br(implode('', $deliverables));
            })
            ->rawColumns(['members', 'action'])
            ->addIndexColumn()
            ->make(true);
    }
}
