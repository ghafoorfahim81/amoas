@extends('layouts.customer', ['title' => __('backend.view_booking')])

@section('content')

<div class="page-title">
    <h3>{{ __('backend.booking') }} # {{ $booking->id }}</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
            <li><a href="{{ route('bookings.index') }}">{{ __('backend.bookings') }}</a></li>
            <li class="active">{{ __('backend.view_booking') }}</li>
        </ol>
    </div>
</div>

<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            @include('alerts.bookings')
            @if($booking->booking_date >= date('Y-m-d'))
                @if($booking->status != 'cancelled')
                <a class="btn btn-info btn-lg" href="{{ route('updateBooking', $booking->id) }}"><i
                        class="fa fa-clock-o fa-lg"></i> &nbsp; {{ __('backend.change_booking_time') }}</a>
                @endif
                <a href="{{route('printNow', [$booking->id])}}" onclick="open(this.href).print(); return false" class="btn btn-lg btn-default">
                        <i class="fa fa-print fa-lg"></i> {{ __('app.print_now') }}
                </a>
                <a href="{{route('printPdf', [$booking->id])}}" class="btn btn-lg btn-default">
                    <i class="fa fa-print fa-lg"></i> {{ __('app.print_pdf') }}
                </a>
                @if($booking->status != 'cancelled')
                <a class="btn btn-danger btn-lg" data-toggle="modal" data-target="#cancel"><i
                        class="fa fa-times-circle fa-lg"></i> &nbsp; {{ __('backend.cancel_booking') }}</a>
                @endif
            @endif
            <br>
            <br>
        </div>
        <div class="col-md-6">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('backend.booking_details') }}</h4>
                </div>
                <div class="panel-body">
                    <div id="account_details_view">
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('backend.serial_no') }}:</strong></div>
                            <div class="col-md-6">{{ $booking->serial_no }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('backend.department') }}:</strong></div>
                            <div class="col-md-6">{{$booking->department->name_en}}</div>
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
                            <div class="col-md-6 bold-font"><strong>{{ __('backend.instructions') }}:</strong></div>
                            <div class="col-md-6">
                                {{ $booking->booking_instructions ? $booking->booking_instructions : __('backend.not_provided') }}
                            </div>
                        </div>
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
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('backend.created') }}:</strong></div>
                            <div class="col-md-6">{{ $booking->created_at }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('backend.booking_applicant_details') }}</h4>
                </div>
                <div class="panel-body">
                    <div id="account_details_view">
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('app.full_name') }}:</strong></div>
                            <div class="col-md-6">{{ $booking->info->full_name }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('app.email') }}:</strong></div>
                            <div class="col-md-6">{{ $booking->info->email }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('app.phone') }}:</strong></div>
                            <div class="col-md-6">{{ $booking->info->phone }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('app.id_card') }}:</strong></div>
                            <div class="col-md-6">{{ $booking->info->id_card }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('app.postal') }}:</strong></div>
                            <div class="col-md-6">
                                {{ $booking->info->postal }}
                            </div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('app.address') }}:</strong></div>
                            <div class="col-md-6">{{ $booking->info->address }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('app.participant') }}:</strong></div>
                            <div class="col-md-6">
                                @foreach ($booking->info->participants as $part)
                                {{ $part->full_name }} | {{ $part->id_card }} | {{ $part->relation }} <br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('backend.r_user_details') }}</h4>
                </div>
                <div class="panel-body">
                    <div class="row table-row">
                        <div class="col-md-6 bold-font"><strong>{{ __('backend.full_name') }}:</strong></div>
                        <div class="col-md-6">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</div>
                    </div>
                    <div class="row table-row">
                        <div class="col-md-6 bold-font"><strong>{{ __('backend.phone_number') }}:</strong></div>
                        <div class="col-md-6"><a
                                    href="tel:{{ $booking->user->phone_number }}">{{ $booking->user->phone_number }}</a>
                        </div>
                    </div>
                    <div class="row table-row">
                        <div class="col-md-6 bold-font"><strong>{{ __('backend.email') }}:</strong></div>
                        <div class="col-md-6"><a href="mailto:{{ $booking->user->email }}">{{ $booking->user->email }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="modal fade" id="status" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false">
            <div class="modal-dialog">
                <form method="post" action="{{ route('bookings.update', $booking->id) }}">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('backend.change_booking_status') }}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ __('backend.status') }}</label>
                                <select class="form-control" name="status" required>
                                    <option></option>
                                    <option>{{ __('backend.processing') }}</option>
                                    <option>{{ __('backend.in_progress') }}</option>
                                    <option>{{ __('backend.completed') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">{{ __('backend.update') }}</button>
                            <button type="button" class="btn btn-danger"
                                data-dismiss="modal">{{ __('backend.close') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="confirm" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('backend.delete_booking_message') }}</p>
                    </div>
                    <form method="post" action="{{ route('bookings.destroy', $booking->id) }}">
                        <div class="modal-footer">
                            {{csrf_field()}}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                            <button type="button" class="btn btn-primary"
                                data-dismiss="modal">{{ __('backend.no') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="cancel" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
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
                            <p>{{ __('backend.cancel_booking_message') }}</p>
                            <div class="form-group">
                                <label>{{ __('backend.cancellation_reason') }}</label>
                                <textarea name="reason" class="form-control"></textarea>
                            </div>
                            <input type="hidden" name="booking_id" value="{{$booking->id}}">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">{{ __('backend.cancel_booking') }}</button>
                            <button type="button" class="btn btn-primary"
                                data-dismiss="modal">{{ __('backend.no') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection