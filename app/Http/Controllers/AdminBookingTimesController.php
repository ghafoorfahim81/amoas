<?php

namespace App\Http\Controllers;

use App\BookingTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminBookingTimesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:BookingTimes show'])->only(['index', 'show']);
        $this->middleware(['permission:BookingTimes create'])->only(['create', 'store']);
        $this->middleware(['permission:BookingTimes edit'])->only(['edit', 'update']);
        $this->middleware(['permission:BookingTimes delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booking_times = BookingTime::all();

        return view('settings.bookingTimes', compact('booking_times'));
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
        //
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
        $input = $request->all();
        BookingTime::findOrFail($id)->update($input);

        //set session message and redirect back booking-times.index
        Session::flash('booking_time_updated', __('backend.booking_time_updated'));

        return redirect('/booking-times');
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
}
