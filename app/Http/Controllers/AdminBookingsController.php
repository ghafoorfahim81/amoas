<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\GoogleCalendar\Event;
use Yajra\Datatables\Datatables;

class AdminBookingsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Bookings Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing bookings views to admin, to
    | show all bookings, provide ability to edit and delete specific booking
    | and to cancel booking.
    |
     */

    private $_api_context;

    public function __construct()
    {
        $settings = [

            'mode' => config('settings.paypal_sandbox_enabled') ? 'sandbox' : 'live',
            'http.ConnectionTimeOut' => 1000,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path().'/logs/paypal.log',
            'log.LogLevel' => 'FINE',

        ];

        $this->middleware(['permission:booking show'])->only(['index', 'show']);
        $this->middleware(['permission:booking change date'])->only(['edit', 'update', 'update_booking_time']);
        $this->middleware(['permission:booking cancel'])->only(['cancel']);
        $this->middleware(['permission:booking delete'])->only(['destroy']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $bookings = Booking::all();
        return view('bookings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::find($id);
        $addons = $booking->addons->all();

        return view('bookings.view', compact('booking', 'addons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //generating a string for off days

        $off_days = DB::table('booking_times')
            ->where('is_off_day', '=', '1')
            ->get();

        $daynum = [];

        foreach ($off_days as $off_day) {
            if ($off_day->id != 7) {
                $daynum[] = $off_day->id;
            } else {
                $daynum[] = $off_day->id - 7;
            }
        }

        $disable_days_string = implode(',', $daynum);

        $booking = Booking::find($id);

        return view('bookings.edit', compact('booking', 'disable_days_string'));
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
        $booking = Booking::find($id);
        $booking->update($input);

        if (config('settings.sync_events_to_calendar') && config('settings.google_calendar_id') && $booking->google_calendar_event_id != null) {
            if ($input['status'] == __('backend.processing')) {
                $new_status = __('backend.processing');
            } elseif ($input['status'] == __('backend.in_progress')) {
                $new_status = __('backend.in_progress');
            } elseif ($input['status'] == __('backend.completed')) {
                $new_status = __('backend.completed');
            } elseif ($input['status'] == __('backend.cancelled')) {
                $new_status = __('backend.cancelled');
            }

            try {
                //update google calendar event
                $event = Event::find($booking->google_calendar_event_id);
                $event->name = $booking->package->category->title.' - '.$booking->package->title.' '.__('app.booking').' - '.$new_status;
                $event->save();
            } catch (\Exception $ex) {
                //do nothing
            }
        }

        //set session message and redirect back to bookings.show
        Session::flash('booking_updated', __('backend.booking_updated'));

        return redirect()->route('bookings.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::findorFail($id);
        $booking->addons()->detach();
        Booking::destroy($booking->id);

        if (config('settings.sync_events_to_calendar') && config('settings.google_calendar_id') && $booking->google_calendar_event_id != null) {
            try {
                //remove google calendar event
                $event = Event::find($booking->google_calendar_event_id);
                $event->delete();
            } catch (\Exception $ex) {
                //do nothing
            }
        }

        //set session message and redirect back to bookings.index
        Session::flash('booking_deleted', __('backend.booking_deleted'));

        return redirect('/bookings');
    }

    /**
     * Cancel a booking
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request, $id)
    {

        $booking = Booking::find($id);
        $input_booking['status'] = 'Cancelled';
        $booking->update($input_booking);

        $user = 'admin';
        // send mail to user.
        \App\Jobs\BookingCancelledEmail::dispatch($booking, $user);

        Session::flash('booking_cancelled', __('backend.booking_cancelled_message'));

        return redirect()->route('bookings.show', $id);
    }

    public function update_booking_time(Request $request, $id)
    {
        $booking = Booking::find($id);

        $oldBooking = $booking; // for sending email
        $booking->update([
            'booking_date' => $request->event_date_bk,
            'booking_time' => $request->booking_slot,
        ]);
        $user = 'admin';

        // send mail to user.
        \App\Jobs\BookingDateChangedEmail::dispatch($booking, $oldBooking, $user);

        return redirect()->route('bookings.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataTable()
    {
        $bookings = Booking::select('bookings.*')->with([
            'package:id,title',
            'info',
            'user' => function ($query) {
                $query->withCount('bookings');
            }]);

        if (! request()->order) {
            $bookings->latest();
        }

        return Datatables::of($bookings)
            ->addColumn('action', function ($booking) {
                $action = '<a href="'.route('bookings.show', $booking->id).'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>&nbsp;';

                // $action .= '<a href="' . route('bookings.edit', $booking->id) .'" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>';
                return $action;
            })
            ->editColumn('user.email', function ($booking) {
                if ($booking->user->bookings_count > 1) {
                    return '<span class="badge badge-dark">'.optional($booking->user)->bookings_count.'</span> '.$booking->email;
                }

                return $booking->email;
            })
            ->editColumn('email', function ($booking) {
                return \Illuminate\Support\Str::limit($booking->email, 10);
            })
            ->editColumn('serial_no', function ($booking) {
                return '<a href="'.route('bookings.show', $booking->id).'">'.$booking->serial_no.'</a>';
            })
            ->addIndexColumn()
            ->setRowClass(function ($booking) {
                return $booking->status == 'Cancelled' ? 'danger' : '';
            })
            ->rawColumns([
                'serial_no',
                'action',
                'user.email',
            ])
            ->make(true);
    }
}
