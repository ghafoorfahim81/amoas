<?php

namespace App\Http\Controllers\Tracing;

use App\Http\Controllers\Controller;
use App\Models\Tracing\MiscellaneousType;
use Illuminate\Http\Request;

class MiscTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:MiscType show'])->only(['index', 'show']);
        $this->middleware(['permission:MiscType create'])->only(['create', 'store']);
        $this->middleware(['permission:MiscType edit'])->only(['edit', 'update']);
        $this->middleware(['permission:MiscType delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = MiscellaneousType::all();

        return view('tracing.type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);

        \DB::beginTransaction();

        MiscellaneousType::create(['type' => $request->name]);

        \DB::commit();

        return redirect(route('misc-types.index'))->with(['alert' => 'Misc type Created']);
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
    public function edit(MiscellaneousType $misc_type)
    {
        return view('tracing.type.edit', compact('misc_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MiscellaneousType $misc_type)
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);

        \DB::beginTransaction();

        $misc_type->update(['type' => $request->name]);

        \DB::commit();

        return redirect(route('misc-types.index'))->with(['alert' => 'Misc type updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MiscellaneousType $misc_type)
    {
        $misc_type->delete();

        return back()->with(['alert' => 'Type has been deleted.']);
    }
}
