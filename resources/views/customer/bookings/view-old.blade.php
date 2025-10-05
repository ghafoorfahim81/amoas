@extends('layouts.customer', ['title' => __('backend.view_booking')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.booking') }} # {{ $booking->id }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('customerBookings') }}">{{ __('backend.bookings') }}</a></li>
                <li class="active">{{ __('backend.view_booking') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">

            <div class="col-md-12">
                @if(Session::has('cancel_request_received'))
                    <div class="alert alert-success">{{session('cancel_request_received')}}</div>
                @endif
            </div>

            @if($booking->user_id == Auth::user()->id)

                <div class="col-md-6">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div id="account_details_view">
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.serial_no') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->serial_no }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.department') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->department->name_en }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.category') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->package->category->title }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.package') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->package->title }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.registrar_id') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->user->email }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.Type') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->booking_type }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div id="account_details_view">
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.date') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->booking_date }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.time') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->booking_time }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.status') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->status }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 hidden-xs hidden-sm">
                    @if($booking->status != __('backend.cancelled'))
                        @if(config('settings.allow_to_cancel'))
                            <button class="btn btn-lg btn-danger {{ !$allow_to_cancel ? 'disabled' : '' }}" data-toggle="modal" data-target="#request_cancellation"><i class="fa fa-times-circle fa-lg"></i> &nbsp; {{ __('backend.request_to_cancel') }}</button>
                        @endif

                        @if(config('settings.allow_to_update'))
                            <a class="btn btn-lg btn-primary {{ !$allow_to_update ? 'disabled' : ''  }}" href="{{ route('updateBooking', $booking->id) }}"><i class="fa fa-calendar fa-lg"></i> &nbsp; {{ __('backend.change_booking_time') }}</a>
                            <br><br>
                        @endif
                    @endif
                </div>

                <div class="col-md-12 hidden-md hidden-lg">
                    @if($booking->status != __('backend.cancelled'))
                        @if(config('settings.allow_to_cancel'))
                            <button class="btn btn-lg btn-danger btn-block {{ !$allow_to_cancel ? 'disabled' : '' }}" data-toggle="modal" data-target="#request_cancellation"><i class="fa fa-times-circle fa-lg"></i> &nbsp; {{ __('backend.request_to_cancel') }}</button>
                        @endif

                        @if(config('settings.allow_to_update'))
                            <a class="btn btn-lg btn-primary btn-block {{ !$allow_to_update ? 'disabled' : ''  }}" href="{{ route('updateBooking', $booking->id) }}"><i class="fa fa-calendar fa-lg"></i> &nbsp; {{ __('backend.change_booking_time') }}</a>
                            <br><br>
                        @endif
                    @endif
                </div>

            @else

                <div class="col-md-12">
                    <div class="alert alert-danger">
                        {{ __('backend.not_authorized') }}
                    </div>
                </div>

            @endif
        </div>
    </div>


    {{--CANCEL REQUEST MODAL--}}

    <div id="request_cancellation" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form method="post" action="{{ route('cancelRequest') }}">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>{{ __('backend.reason_for_cancellation') }}</strong></label>
                            <textarea class="form-control" name="reason" required></textarea>
                        </div>
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">{{ __('backend.request_to_cancel') }}</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection