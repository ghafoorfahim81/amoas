<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Booking;
use App\BookingTime;
use App\Category;
use App\Holidays;
use App\Jobs\FinalizeNewBooking;
use App\Models\PostalCode;
use App\Package;
use App\Services\PDFService;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\GoogleCalendar\Event;

class UserBookingController extends Controller
{
    /**
     * get user bookings and load user bookings view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()->latest()->get();

        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Initialize a booking
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadBooking()
    {
        $categories = Category::with(['packages', 'packages.photo'])->get();
        return view('welcome', compact('categories'));
    }

    public function ajaxPackageInfo(Request $request)
    {
        echo Package::find($request->id)->description;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPackages()
    {
        $category_id = \request('parent');
        $packages = Category::find($category_id)->packages()->get();

        return view('blocks.packages', compact('packages'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTimingSlots()
    {
        return $this->getNewTimingSlots();
        //get selected event date
        $event_date = \request('event_date');

        //get selected package_id
        $selected_package_id = Session::get('package_id');

        //get selected category_id
        $selected_category_id = Package::find($selected_package_id)->category->id;

        //get day name to select slot timings
        $timestamp_for_event = strtotime($event_date);
        $today_number = date('N', $timestamp_for_event);
        $booking_time = BookingTime::findOrFail($today_number);

        //decide starting and ending hours for selected date
        $hour_start = $booking_time->opening_time;
        $hour_end = $booking_time->closing_time;

        //decide what will be the duration of each slot
        if (config('settings.slots_with_package_duration')) {
            //use package duration as slot duration
            $package = Package::find($selected_package_id);
            $slot_duration = $package->duration * 60;
        } else {
            //use regular slot duration
            $slot_duration = config('settings.slot_duration') * 60;
        }

        //decide how many slots will be generated
        if (strtotime($hour_start) > strtotime($hour_end)) {
            $hours = round((strtotime($hour_start) - strtotime($hour_end)) / $slot_duration, 1);
        } elseif (strtotime($hour_end) > strtotime($hour_start)) {
            $hours = round((strtotime($hour_end) - strtotime($hour_start)) / $slot_duration, 1);
        } elseif (strtotime($hour_start) == strtotime($hour_end)) {
            $hours = 24;
        }

        //get all bookings to block some already booked slots
        $bookings = Booking::all()->where('status', '!=', __('backend.cancelled'));

        //reset the counter to disable slots
        $count_next_disabled = 0;

        //start loop for slot generation
        for ($i = 0; $i < $hours; $i++) {
            // minutes to add in lap of each slot
            $minutes_to_add = $slot_duration * $i;

            // increment each slot by minutes_to_add
            $timeslot = date('H:i:s', strtotime($hour_start) + $minutes_to_add);

            //clock format choice
            if (config('settings.clock_format') == 12) {
                $list_slot[$i]['slot'] = date('h:i A', strtotime($timeslot));
            } else {
                $list_slot[$i]['slot'] = date('H:i', strtotime($timeslot));
            }

            //if counter for disabling slots is not zero, block the slot as already booked
            if ($count_next_disabled != 0) {
                $list_slot[$i]['is_available'] = false;
                $count_next_disabled--;
            } else {
                $list_slot[$i]['is_available'] = true;
            }

            //checking slot availability
            foreach ($bookings as $booking) {
                if (strtotime($booking->booking_date) == strtotime($event_date) && strtotime($booking->booking_time) == strtotime($timeslot)) {
                    //put multiple booking logic

                    //one booking at one slot

                    if (config('settings.slots_method') == 1) {
                        //prevent multiple bookings at same time
                        $list_slot[$i]['is_available'] = false;
                        $package_booking = Package::find($booking->package_id);
                        $package = Package::find($selected_package_id);
                        if (config('settings.slots_with_package_duration')) {
                            $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                        } else {
                            $count_next_disabled = ($package_booking->duration / config('settings.slot_duration')) - 1;
                        }
                    }

                    //multiple with different package

                    if (config('settings.slots_method') == 3) {
                        if ($selected_package_id == $booking->package->id) {
                            //prevent multiple bookings at same time
                            $list_slot[$i]['is_available'] = false;
                            $package_booking = Package::find($booking->package_id);
                            $package = Package::find($selected_package_id);
                            if (config('settings.slots_with_package_duration')) {
                                $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                            } else {
                                $count_next_disabled = ($package_booking->duration / config('settings.slot_duration')) - 1;
                            }
                        }
                    }

                    //multiple with different category

                    if (config('settings.slots_method') == 4) {
                        if ($selected_category_id == $booking->package->category->id) {
                            //prevent multiple bookings at same time
                            $list_slot[$i]['is_available'] = false;
                            $package_booking = Package::find($booking->package_id);
                            $package = Package::find($selected_package_id);
                            if (config('settings.slots_with_package_duration')) {
                                $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                            } else {
                                $count_next_disabled = ($package_booking->duration / config('settings.slot_duration')) - 1;
                            }
                            break;
                        }
                    }
                }
            }
        }
        dd($hours);

        return view('blocks.slots', compact('list_slot', 'hours'));
    }

    public function getNewTimingSlots()
    {
        //get selected event date
        $event_date = request('event_date');

        //get selected package_id
        $package = Package::find(Session::get('package_id', request('package_id')));

        //get day name to select slot timings
        $timestamp_for_event = strtotime($event_date);
        $today_number = date('N', $timestamp_for_event);
        // return $today_number;
        $booking_time = BookingTime::findOrFail($today_number);

        //decide starting and ending hours for selected date
        $hour_start = $booking_time->opening_time;
        $hour_end = $booking_time->closing_time;
        $startSeconds = strtotime($hour_start);
        $endSeconds = strtotime($hour_end);

        $hours = [];
        while ($startSeconds < $endSeconds) {

            $time = date('g:i A', $startSeconds);

            $hours[] = $time;

            $startSeconds += 60 * 60;
        }

        $eachSlotAvailablity = round($package->daily_acceptance / count($hours), 0, PHP_ROUND_HALF_DOWN);

        //get the booking count

        $bookedByHours = Booking::select('booking_time', \DB::raw('COUNT(DISTINCT bookings.id) AS total'))
            ->leftJoin('booking_info', 'bookings.id', '=', 'booking_info.booking_id')
            ->leftJoin('participants', 'booking_info.id', '=', 'participants.info_id')
            ->where('package_id', $package->id)
            ->where('booking_type', '!=', 'emergency')
            ->where('status', '!=', 'Cancelled')
            ->whereDate('booking_date', $event_date)
            ->groupBy('booking_time')
            ->selectRaw('count(participants.id) as participant_count')
            ->get()
            ->map(function ($item) {
                $item->total += $item->participant_count;

                return $item;
            })
            ->pluck('total', 'booking_time')
            ->toArray();

        $urgentBookingCount = 0;
        if (auth()->check() && auth()->user()->role && (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())) {
            $urgentBookingCount = Booking::where('package_id', $package->id)
                ->where('booking_type', '=', 'emergency')
                ->where('status', '!=', 'Cancelled')
                ->whereDate('booking_date', $event_date)
                ->count();
        }

        $isAlreadyBooked = false;

        // set the total slots to 0 if in the package config mentioned
        if ($package->config && ($package->config['show_already_booked'] ?? false)) {
            $alreadyBookedTill = $package->config['already_booked_till'] ?? null;
            if ($alreadyBookedTill) {
                // compare the $alreadyBookedTill with $event_date
                // if $event_date is less than or equal to $alreadyBookedTill then set the $bookedByHours to 0
                if (strtotime($event_date) <= strtotime($alreadyBookedTill)) {
                    // set the $bookedByHours to $eachSlotAvailablity
                    $isAlreadyBooked = true;
                }
            }
        }

        return view('blocks.new-slots', compact('bookedByHours', 'hours', 'eachSlotAvailablity', 'urgentBookingCount', 'package', 'isAlreadyBooked'));
    }

    public function availableHours($event_date)
    {

        //change to timestamp
        $timestamp_for_event = strtotime($event_date);
        $today_number = date('N', $timestamp_for_event);

        // return $today_number;
        $booking_time = BookingTime::findOrFail($today_number);

        //decide starting and ending hours for selected date
        $hour_start = $booking_time->opening_time;
        $hour_end = $booking_time->closing_time;
        $startSeconds = strtotime($hour_start);
        $endSeconds = strtotime($hour_end);

        $hours = [];
        while ($startSeconds < $endSeconds) {

            $time = date('g:i A', $startSeconds);

            $hours[] = $time;

            $startSeconds += 60 * 60;
        }

        return $hours;
    }

    public function getUpdateSlots()
    {
        $event_date = \request('event_date');
        $booking_id = \request('booking');
        $booking = Booking::find($booking_id);
        $selected_package_id = $booking->package_id;
        $selected_category_id = Package::find($selected_package_id)->category->id;

        $timestamp_for_event = strtotime($event_date);
        $today_number = date('N', $timestamp_for_event);

        //get related booking time for day number
        $booking_time = BookingTime::findOrFail($today_number);

        $hour_start = $booking_time->opening_time;
        $hour_end = $booking_time->closing_time;

        //decide what will be the duration of each slot
        if (config('settings.slots_with_package_duration')) {
            //use package duration as slot duration
            $package = Package::find($selected_package_id);
            $slot_duration = $package->duration * 60;
        } else {
            //use regular slot duration
            $slot_duration = config('settings.slot_duration') * 60;
        }

        if (strtotime($hour_start) > strtotime($hour_end)) {
            $hours = round((strtotime($hour_start) - strtotime($hour_end)) / $slot_duration, 1);
        } elseif (strtotime($hour_end) > strtotime($hour_start)) {
            $hours = round((strtotime($hour_end) - strtotime($hour_start)) / $slot_duration, 1);
        } elseif (strtotime($hour_start) == strtotime($hour_end)) {
            $hours = 24;
        }

        $bookings = Booking::all()->where('status', '!=', __('backend.cancelled'));

        $count_next_disabled = 0;

        for ($i = 0; $i < $hours; $i++) {
            // increment by 1 hour
            $minutes_to_add = $slot_duration * $i;

            // add 1 hour to each next slot
            $timeslot = date('H:i:s', strtotime($hour_start) + $minutes_to_add);

            //clock format choice
            if (config('settings.clock_format') == 12) {
                $list_slot[$i]['slot'] = date('h:i A', strtotime($timeslot));
            } else {
                $list_slot[$i]['slot'] = date('H:i', strtotime($timeslot));
            }

            if ($count_next_disabled != 0) {
                $list_slot[$i]['is_available'] = false;
                $count_next_disabled--;
            } else {
                $list_slot[$i]['is_available'] = true;
            }

            //checking slot availability
            //checking slot availability
            foreach ($bookings as $booking) {
                if (strtotime($booking->booking_date) == strtotime($event_date) && strtotime($booking->booking_time) == strtotime($timeslot)) {
                    //put multiple booking logic

                    //one booking at one slot

                    if (config('settings.slots_method') == 1) {
                        //prevent multiple bookings at same time
                        $list_slot[$i]['is_available'] = false;
                        $package_booking = Package::find($booking->package_id);
                        $package = Package::find($selected_package_id);
                        if (config('settings.slots_with_package_duration')) {
                            $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                        } else {
                            $count_next_disabled = ($package_booking->duration / config('settings.slot_duration')) - 1;
                        }
                    }

                    //multiple with different package

                    if (config('settings.slots_method') == 3) {
                        if ($selected_package_id == $booking->package->id) {
                            //prevent multiple bookings at same time
                            $list_slot[$i]['is_available'] = false;
                            $package_booking = Package::find($booking->package_id);
                            $package = Package::find($selected_package_id);
                            if (config('settings.slots_with_package_duration')) {
                                $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                            } else {
                                $count_next_disabled = ($package_booking->duration / config('settings.slot_duration')) - 1;
                            }
                        }
                    }

                    //multiple with different category

                    if (config('settings.slots_method') == 4) {
                        if ($selected_category_id == $booking->package->category->id) {
                            //prevent multiple bookings at same time
                            $list_slot[$i]['is_available'] = false;
                            $package_booking = Package::find($booking->package_id);
                            $package = Package::find($selected_package_id);
                            if (config('settings.slots_with_package_duration')) {
                                $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                            } else {
                                $count_next_disabled = ($package_booking->duration / config('settings.slot_duration')) - 1;
                            }
                            break;
                        }
                    }
                }
            }
        }

        return view('blocks.backendSlots', compact('list_slot', 'hours'));
    }

    public function update_booking(Request $request, $id)
    {
        $booking = Booking::find($id);
        if ($booking->user->id != Auth::user()->id) {
            abort(403);
        }

        $oldBooking = $booking; // for sending email
        $booking->update([
            'booking_date' => $request->event_date_bk,
            'booking_time' => $request->booking_slot,
        ]);
        $user = auth()->user()->email;

        // send mail to user.
        \App\Jobs\BookingDateChangedEmail::dispatch($booking, $oldBooking, $user);

        return redirect()->route('customerBookings');
    }

    /**
     * @param  BookingStep1  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postStep1(Request $request)
    {
        $request->session()->put('package_id', $request->package_id);
        $package = Package::findOrFail(Session::get('package_id'));

        return redirect()->route('loadStep2');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadStep2()
    {
        if (! session()->has('package_id')) {
            return redirect('/');
        }

        //load step 2
        return view('select-booking-time');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postStep2(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'email|required',
            'postal' => 'required',
            'phone' => 'required',
            'full_name' => 'required',
            'place' => 'required',
            'booking_for' => 'required',
            'street' => 'required',
            'place' => 'required',
        ]);

        $place = $request->place;
        $postalCode = $request->postal;

        // get the selected package from session
        $package = Package::findOrfail(session('package_id'));

        $isLockedForAnyMission = $package->config['is_locked_for_any_mission'] ?? false;
        $missionAreLocked = $package->config['lock_for_missions'] ?? [];

        $address = PostalCode::with(['mission:id,name_en,name_dr'])->where('zip', $postalCode)->where('place', $place)->first();

        if ($address->mission_id !== 108 && $isLockedForAnyMission && in_array($address->mission_id, $missionAreLocked)) {

            $validator->after(function ($validator) use ($address) {
                $validator->errors()->add(
                    'postal',
                    __('app.postal_code_not_in_range', [
                        'zip' => $address->zip,
                        'place' => $address->place,
                        'mission' => $address->mission->name_en ?? 'nearest mission',
                    ])
                );
            });

            // log the using spatie laravel activity log
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['postal' => $postalCode, 'place' => $place, 'state' => $address->state])
                ->log("Postal code belongs to {$address->mission->name_en}");
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $input = $request->all();

        //store form input into session and load next step
        $request->session()->put('email', $input['email']);
        $request->session()->put('street', $input['street']);
        $request->session()->put('postal', $input['postal']);
        $request->session()->put('place', $input['place']);
        $request->session()->put('state', $address->state);
        $request->session()->put('phone', $input['phone']);
        $request->session()->put('full_name', $input['full_name']);
        $request->session()->put('participant', $input['participant']);

        // construct new booking
        $newBooking = new Booking;
        $newBooking->user_id = auth()->id();
        $newBooking->package_id = session('package_id');
        $newBooking->department_id = session('department_id', 108);
        $newBooking->serial_no = Booking::genSerialNo(session('department_id', 108), session('package_id'));
        $newBooking->email = session('email');

        // set the $newBooking to session
        $request->session()->put('newBooking', $newBooking);

        // set the $address to session
        $request->session()->put('address', $address);

        return redirect('/select-extra-services');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postStep3(Request $request)
    {
        $dateNumber = $weekday = date('N', strtotime($request->event_date));

        $offDaysNum = DB::table('booking_times')
            ->where('is_off_day', '=', '0')
            ->get()
            ->pluck('id', 'day')
            ->toArray();

        $holidays = session()->has('holidays') ? implode(',', session('holidays')) : null;

        $validator = \Validator::make($request->all(), [
            'event_date' => 'date|required|not_in:' . $holidays,
            'booking_slot' => 'required',
            'participant.*.name' => 'required',
            'participant.*.id_card' => 'required',
            'participant.*.relation' => 'required',
        ], [
            'event_date.not_in' => __('app.holidays_blocked', ['date' => $request->event_date]),
        ]);

        $validator->after(function ($validator) use ($dateNumber, $offDaysNum) {
            if (! in_array($dateNumber, $offDaysNum)) {
                $validator->errors()->add('event_date', __('app.weekend_blocked', ['days' => implode(', ', array_map(function ($item) {
                    return __('app.' . $item);
                }, array_keys($offDaysNum)))]));
            }
        });

        $validator->after(function ($validator) use ($request) {
            if ($request->booking_type != 'emergency') {

                $bookedCountInRequestedHour = Booking::whereDate('booking_date', '=', $request->event_date)
                    ->where('package_id', session('package_id'))
                    ->where('booking_time', $request->booking_slot)
                    ->where('booking_type', '!=', 'Emergency')
                    ->where('status', '!=', 'cancelled')
                    ->count();

                $availableSlots = $this->availableHours($request->event_date);

                if (! in_array($request->booking_slot, $availableSlots)) {
                    $validator->errors()->add('event_date', __('app.notInAvailableHours', ['time' => $request->booking_slot]));
                }

                $dailyAcceptance = Package::find(session('package_id'))->daily_acceptance;

                $availableInEachSlot = round($dailyAcceptance / count($availableSlots), 0, PHP_ROUND_HALF_DOWN);

                if ($bookedCountInRequestedHour + (session('participant') + 1) > $availableInEachSlot) {
                    $validator->errors()->add('event_date', __('app.slotBlocked', ['time' => $request->booking_slot, 'date' => $request->event_date]));
                }
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $request->session()->put('event_date', $request->event_date);
        $request->session()->put('booking_slot', $request->booking_slot);
        $request->session()->put('participantInfo', $request->participant);


        \DB::beginTransaction();
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'package_id' => session('package_id'),
            'department_id' => session('department_id', 108),
            'serial_no' => Booking::genSerialNo(session('department_id', 108), session('package_id')),
            'booking_date' => $request->event_date,
            'booking_type' => ucfirst($request->booking_type) ?? 'Ordinary',
            'booking_time' => $request->booking_slot,
            'email' => session('email'),
            'status' => 'Waiting',
        ]);

        $info = $booking->info()->create([
            'full_name' => session('full_name'),
            'email' => session('email'),
            'phone' => session('phone'),
            'id_card' => 'N/A',
            'postal' => session('postal'),
            'address' => session('street'),
            'city' => session('place'),
            'state' => session('state'),
        ]);

        if ($request->has('participant')) {
            foreach ($request->participant as $key => $participant) {
                $info->participants()->create([
                    'full_name' => $participant['name'],
                    'id_card' => $participant['id_card'],
                    'relation' => $participant['relation'],
                ]);

                // ${"var{$key}"} = Booking::create([
                //     'user_id' => $booking->user_id,
                //     'package_id' => $booking->package_id,
                //     'department_id' => $booking->department_id,
                //     'serial_no' => '#'.($key + 1).'-'.$booking->serial_no,
                //     'booking_date' => $booking->booking_date,
                //     'booking_type' => $booking->booking_type,
                //     'booking_time' => $booking->booking_time,
                //     'email' => $booking->email,
                //     'status' => $booking->status,
                // ]);

                // ${"var{$key}"}->info()->create([
                //     'full_name' => $info->full_name."| {$participant['relation']}",
                //     'email' => $info->email,
                //     'phone' => $info->phone,
                //     'id_card' => $participant['id_card'],
                //     'postal' => $info->postal,
                //     'address' => $info->address,
                // ]);
            }
        }

        \DB::commit();

        $booking->load(['user', 'info', 'package', 'department']);
        FinalizeNewBooking::dispatch($booking);

        $request->session()->put('bookingId', $booking->id);
        $request->session()->put('booking', $booking);

        return redirect('/finalize-booking');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadStep3()
    {
        if (! session()->has('package_id')) {
            return redirect('/');
        }

        $package = Package::find(Session::get('package_id'));
        $category_id = $package->category_id;

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

        $now = Carbon::now();

        $holydays = Holidays::where(function ($query) use ($now) {
            $query->where('repeated', 1)
                ->orWhere(function ($query) use ($now) {
                    $query->where('year', '>', $now->year)
                        ->orWhere(function ($query) use ($now) {
                            $query->where('year', '=', $now->year)
                                ->where('month', '>', $now->month);
                        })
                        ->orWhere(function ($query) use ($now) {
                            $query->where('year', '=', $now->year)
                                ->where('month', '=', $now->month)
                                ->where('day', '>=', $now->day);
                        });
                });
        })->get();

        $holydays = array_merge(
            $holydays->where('repeated_date', '>=', $now->format('Y-m-d'))->pluck('repeated_date')->toArray(),
            $holydays->where('date', '>=', $now->format('Y-m-d'))->pluck('date')->toArray(),
            $holydays->where('next_year_repeated_date', '<=', $now->addMonths(7)->format('Y-m-d'))->pluck('next_year_repeated_date')->toArray(),
        );

        $holydays = array_unique($holydays);

        request()->session()->put('holidays', $holydays);

        $participants = --$package->daily_acceptance;
        if (session()->has('participant')) {
            $participants -= session('participant');
        }
        // should work on it
        $bookedDates = Booking::select('booking_date', \DB::raw('count(*) as total'))
            ->where('package_id', $package->id)
            ->where('status', '!=', 'Cancelled')
            ->groupBy('booking_date')
            ->having('total', '>=', $participants)
            ->having('booking_date', '>=', date('Y-m-d'))
            ->get()
            ->pluck('booking_date')
            ->toArray();

        $disabledDates = json_encode(array_merge($holydays, $bookedDates));

        $daynum = [];

        return view('select-extra-services', compact('disable_days_string', 'package', 'disabledDates'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadFinalStep()
    {
        if (! session()->has('package_id') || ! session()->has('bookingId')) {
            return redirect('/');
        }
        $category = Package::find(Session::get('package_id'))->category->title;
        $package = Package::find(Session::get('package_id'));
        $booking = Booking::with('department', 'package', 'info', 'info.participants')->find(session('bookingId'));
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
            $total_with_gst = round($total_with_gst, 2);
        }

        $userId = auth()->id();
        $department = session()->get('department');

        request()->session()->flush();

        auth()->loginUsingId($userId);

        if ($department) {
            request()->session()->put('department', $department);
        }

        return view('finalize-booking', compact(
            'category',
            'package',
            'session_addons',
            'total',
            'booking'
        ));
    }

    /**
     * Thank you - payment completed
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function thankYou()
    {
        return view('thank-you');
    }

    /**
     * Payment failed
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymentFailed()
    {
        return view('payment-failed');
    }

    /**
     * Show booking to customer
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $booking = Booking::find($id);

        //checking booking date to allow update or cancel
        $days_limit_to_update = config('settings.days_limit_to_update') * 86400;
        $days_limit_to_cancel = config('settings.days_limit_to_cancel') * 86400;
        $today = date('Y-m-d');

        if (strtotime($booking->booking_date) - strtotime($today) >= $days_limit_to_update) {
            $allow_to_update = true;
        } else {
            $allow_to_update = false;
        }

        if (strtotime($booking->booking_date) - strtotime($today) >= $days_limit_to_cancel) {
            $allow_to_cancel = true;
        } else {
            $allow_to_cancel = false;
        }

        // load other details
        $booking->load('info', 'info.participants');

        return view('customer.bookings.view', compact('booking', 'allow_to_update', 'allow_to_cancel'));
    }

    /**
     * Remove addon from list of booking services
     */
    public function removeFromList()
    {
        $addon_id = \request('addon_id');
        $session_email = \request('session_email');

        DB::table('session_addons')->where('addon_id', '=', $addon_id)->where('session_email', '=', $session_email)->delete();
    }

    /**
     * check if addon is added in list of booking services
     */
    public function checkIfAdded($addon_id, $session_email)
    {
        $row = DB::table('session_addons')->where('addon_id', '=', $addon_id)->where('session_email', '=', $session_email)->get();
        if (count($row) == 0) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * load booking update view for user
     */
    public function update($id)
    {
        $booking = Booking::find($id);

        $cancel_request = $booking->cancel_request()->first();

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

        $package = $booking->package;

        $dep_id = $booking->department->id;
        $holydays = \App\Holidays::whereHas('departments', function ($query) use ($dep_id) {
            $query->where('id', $dep_id);
        })->get()->pluck('date');

        $holydays = array_merge(...$holydays);
        //should work on it
        $bookedDates = Booking::select('booking_date', \DB::raw('count(*) as total'))
            ->where('package_id', $booking->package->id)
            ->where('status', '!=', 'Cancelled')
            ->groupBy('booking_date')
            ->having('total', '>=', --$package->daily_acceptance)
            ->having('booking_date', '>=', date('Y-m-d'))
            ->get()
            ->pluck('booking_date')
            ->toArray();

        $disabledDates = json_encode(array_merge($holydays, $bookedDates));

        if (
            $booking->user->id == Auth::user()->id
            && $booking->status != 'cancelled'
        ) {
            return view('customer.bookings.update', compact('booking', 'disable_days_string', 'disabledDates'));
        } else {
            return view('errors.404');
        }
    }

    public function print($id)
    {

        $booking = Booking::with('department', 'package')->find($id);

        // $afgLogo = (string) \Image::make('images/afg-logo.png')->encode('data-url');
        // $qrCode = (string) $this->writeQrCode($booking->serial_no);
        // return view('print-booking-success-new', compact('booking', 'afgLogo', 'qrCode'));
        return view('print-booking-success-new', compact('booking'));
    }

    public function writeQrCode($text)
    {
        $qrCode = new QrCode($text);
        $qrCode->setWriterByName('png');
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');
        $qrCode->setSize(200);
        // Save it to a file
        $qrCode->writeFile('temp/qrcode.png');

        return \Image::make('temp/qrcode.png')->encode('data-url');
    }

    public function printPdf($id)
    {
        $booking = Booking::with('department', 'package')->find($id);

        $pdfContent = (new PDFService)->generateBookingConfirmationPdf($booking);

        $pdfName = "booking-confirmation-{$booking->serial_no}.pdf";

        // return to download the pdf
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $pdfName . '"');
    }
}
