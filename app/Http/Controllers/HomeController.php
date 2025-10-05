<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Role;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing dashboard views to
    | admin and customer.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if Auth user role is admin
        if (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin()) {
            //find all customers
            $role = Role::find(2);

            $customers = $role->users->count();
            $todayCustomerCount = $role->users()->whereDate('created_at', date('Y-m-d'))->count();

            // dd($todayCustomerCount);
            //find all bookings
            $bookings = Booking::count();
            $todayBookings = Booking::whereDate('booking_date', date('Y-m-d'))->get();

            // get start of the month
            $now = now()->startOfMonth();

            //get data for bookings graph
            $stats_booking = Booking::select('booking_date as date', \DB::raw('count(*) as value'))
                ->where('booking_date', '>=', $now->format('Y-m-d'))
                ->where('booking_date', '<=', $now->endOfMonth()->format('Y-m-d'))
                ->where('status', '!=', 'Cancelled')
                ->groupBy('booking_date')
                ->get();

            //get data for cancelled bookings
            $bookings_cancelled = Booking::where('status', '=', 'cancelled')->count();
            $todayCancelledBookings = $todayBookings->whereIn('status', ['Cancelled', 'cancelled'])
                ->count();

            return view('dashboard.admin', compact(
                'customers',
                'todayCustomerCount',
                'bookings',
                'stats_booking',
                'bookings_cancelled',
                'todayCancelledBookings',
                'todayBookings',
            ));
        }

        //if Auth user role is customer
        elseif (Auth::user()->isCustomer()) {
            $user = Auth::user();
            $bookings = $user->bookings()->where('status', '!=', __('backend.cancelled'))->count('id');
            $recent_bookings = $user->bookings()->orderBy('created_at', 'ASC')->limit('5')->get();

            //find successful invoices and calculate total
            $successful_invoices = $user->invoices()->where('is_refunded', '=', 0)->get();
            $total_paid = 0;
            foreach ($successful_invoices as $successful_invoice) {
                $total_paid = $total_paid + $successful_invoice->amount;
            }

            //find refunded invoices and calculate total
            $refunded_invoices = $user->invoices()->where('is_refunded', '=', 1)->get();
            $total_refunded = 0;
            foreach ($refunded_invoices as $refunded_invoice) {
                $total_refunded = $total_refunded + $refunded_invoice->amount;
            }

            $bookings_cancelled = $user->bookings()->where('status', '=', __('backend.cancelled'))->count('id');

            return view('dashboard.customer', compact('bookings', 'total_paid',
                'bookings_cancelled', 'recent_bookings', 'total_refunded'));
        }
    }
}
