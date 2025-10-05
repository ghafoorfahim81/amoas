<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Booking;
use App\Invoice;
use App\Mail\AdminBookingNotice;
use App\Mail\BookingInvoice;
use App\Mail\BookingReceived;
use App\Package;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Spatie\GoogleCalendar\Event;

class OfflinePaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Offline Payment Controller
    |--------------------------------------------------------------------------
    |
    | This controller accepts the form post of offline payment form
    | to make booking. It calculates
    | booking charges, save booking and send emails.
    |
    */

    public function index()
    {
        $invoices = Invoice::all();

        return view('invoices.unpaid', compact('invoices'));
    }

    /**
     * Accept form post and process payment and booking
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payOffline()
    {
        //calculate total amount to be charged

        $package = Package::find(Session::get('package_id'));
        $session_addons = DB::table('session_addons')->where('session_email', '=', Auth::user()->email)->get();

        //calculate total

        $total = $package->price;

        //add addons price if any

        foreach ($session_addons as $session_addon) {
            $total = $total + Addon::find($session_addon->addon_id)->price;
        }

        //check if GST is enabled and add it to total invoice

        if (config('settings.enable_gst')) {
            $gst_amount = (config('settings.gst_percentage') / 100) * $total;
            $gst_amount = round($gst_amount, 2);
            $total_with_gst = $total + $gst_amount;
        }

        //decide if to charge with GST or without GST

        if (config('settings.enable_gst')) {
            $amount_to_charge = $total_with_gst;
        } else {
            $amount_to_charge = $total;
        }

        $package_id = Session::get('package_id');
        $package = Package::find($package_id);

        if (config('settings.sync_events_to_calendar') && config('settings.google_calendar_id')) {
            //create timestamp
            $time_string = Session::get('event_date').' '.Session::get('booking_slot');
            $start_instance = Carbon::createFromTimestamp(strtotime($time_string), env('LOCAL_TIMEZONE'));
            $end_instance = Carbon::createFromTimestamp(strtotime($time_string), env('LOCAL_TIMEZONE'))->addMinutes($package->duration);

            try {

                //create google calendar event
                $event = new Event;
                $event->name = $package->category->title.' - '.$package->title.' '.__('app.booking').' - '.__('backend.processing');
                $event->startDateTime = $start_instance;
                $event->endDateTime = $end_instance;
                $calendarEvent = $event->save();

                //save booking with calendar event id
                $booking = Booking::create([
                    'user_id' => Auth::user()->id,
                    'package_id' => $package_id,
                    'booking_address' => Session::get('address'),
                    'booking_instructions' => Session::get('instructions'),
                    'booking_date' => Session::get('event_date'),
                    'booking_time' => Session::get('booking_slot'),
                    'google_calendar_event_id' => $calendarEvent->id,
                    'status' => __('backend.processing'),
                ]);

            } catch (\Exception $ex) {

                //save booking without calendar event id
                $booking = Booking::create([
                    'user_id' => Auth::user()->id,
                    'package_id' => $package_id,
                    'booking_address' => Session::get('address'),
                    'booking_instructions' => Session::get('instructions'),
                    'booking_date' => Session::get('event_date'),
                    'booking_time' => Session::get('booking_slot'),
                    'status' => __('backend.processing'),
                ]);

            }
        } else {
            //save booking without calendar event id
            $booking = Booking::create([
                'user_id' => Auth::user()->id,
                'package_id' => $package_id,
                'booking_address' => Session::get('address'),
                'booking_instructions' => Session::get('instructions'),
                'booking_date' => Session::get('event_date'),
                'booking_time' => Session::get('booking_slot'),
                'status' => __('backend.processing'),
            ]);
        }

        //save invoice
        Invoice::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::user()->id,
            'transaction_id' => time(),
            'amount' => $amount_to_charge,
            'payment_method' => __('app.offline_payment'),
            'is_paid' => 0,
        ]);

        //attach all selected addons to addon_booking
        $session_addons = DB::table('session_addons')->where('session_email', '=', Auth::user()->email)->get();
        foreach ($session_addons as $session_addon) {
            Addon::find($session_addon->addon_id)->bookings()->attach($booking);
        }

        //delete all session addons
        DB::table('session_addons')->where('session_email', '=', Auth::user()->email)->delete();

        //send booking received email
        $user = User::find(Auth::user()->id);
        $admin = Role::find(1)->users()->get();

        try {

            Mail::to($user)->send(new BookingReceived($booking, $user));
            Mail::to($user)->send(new BookingInvoice($booking));

            foreach ($admin as $recipient) {
                Mail::to($recipient)->send(new AdminBookingNotice($booking, $recipient));
            }

            return redirect()->route('thankYou');

        } catch (\Exception $ex) {

            return redirect()->route('thankYou');

        }

    }
}
