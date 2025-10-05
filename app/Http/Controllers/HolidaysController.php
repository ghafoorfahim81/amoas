<?php

namespace App\Http\Controllers;

use App\Holidays;
use Illuminate\Http\Request;

class HolidaysController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:holidays show'])->only(['index', 'show']);
        $this->middleware(['permission:holidays create'])->only(['create', 'store']);
        $this->middleware(['permission:holidays edit'])->only(['edit', 'update']);
        $this->middleware(['permission:holidays delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidays = Holidays::withCount('departments')->paginate(50);

        return view('holidays.index', compact('holidays'));
    }

    public function store()
    {
        $this->validate(request(), [
            'day' => 'numeric|required|digits_between:1,31',
            'month' => 'numeric|required|digits_between:1,12',
            'year' => 'numeric|required|digits:4',
            'repeated' => 'required',
        ]);

        Holidays::create(request()->except(['_token']));

        return redirect(route('holidays.index'))->with(['alert' => 'Holiday created']);
        // $holidays = Holidays::withCount('departments')->paginate(50);
        // return view('holidays.index', compact('holidays'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Holidays $holiday)
    {
        $departments = $holiday->departments()->pluck('id')->toJson();

        // dd($departments);
        return view('holidays.edit', compact('holiday', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Holidays $holiday)
    {
        // dd(request()->all());
        $holiday->update(request()->except(['_token', 'all_department', 'departments', '_method']));
        //update data into categories table
        if (request()->has('all_department') && request()->all_department == 'on') {
            $ids = \App\Department::whereIn('type', ['embassy', 'consulate'])->where('status', 1)->get()->pluck('id');
            $holiday->departments()->sync($ids);
        } else {
            $holiday->departments()->sync(request()->departments);
        }

        return redirect(route('holidays.index'))->with(['alert' => 'Holiday updated successfully', 'class' => 'alert-success']);
    }
}
