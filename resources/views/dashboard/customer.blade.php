@extends('layouts.customer', ['title' => __('backend.dashboard')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.dashboard') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.dashboard') }}</li>
            </ol>
        </div>
    </div>
    <div id="main-wrapper">
        {{-- check if the verified  session is true it means that the user just verified --}}
        @if (session('verified'))
            <div class="alert alert-success">{{ __('app.email_verified') }}</div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $bookings }}</p>
                            <span class="info-box-title">{{ __('backend.bookings') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $bookings_cancelled }}</p>
                            <span class="info-box-title">{{ __('backend.bookings_cancelled') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-calendar" style="color:red;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('alerts.bookings')
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.recent_bookings') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if ($bookings)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('backend.category') }}</th>
                                            <th>{{ __('backend.package') }}</th>
                                            <th>{{ __('backend.date') }}</th>
                                            <th>{{ __('backend.time') }}</th>
                                            <th>{{ __('backend.status') }}</th>
                                            <th>{{ __('backend.created') }}</th>
                                            <th>{{ __('backend.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('backend.category') }}</th>
                                            <th>{{ __('backend.package') }}</th>
                                            <th>{{ __('backend.date') }}</th>
                                            <th>{{ __('backend.time') }}</th>
                                            <th>{{ __('backend.status') }}</th>
                                            <th>{{ __('backend.created') }}</th>
                                            <th>{{ __('backend.actions') }}</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($recent_bookings as $booking)
                                            <tr>
                                                <td>{{ $booking->id }}</td>
                                                <td>{{ $booking->package->category->title }}</td>
                                                <td>{{ $booking->package->title }}</td>
                                                <td>{{ $booking->booking_date }}</td>
                                                <td>{{ $booking->booking_time }}</td>
                                                <td><span
                                                        class="label {{ $booking->status == __('backend.cancelled') ? 'label-danger' : 'label-success' }}">{{ $booking->status }}</span>
                                                </td>
                                                <td>{{ $booking->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <a href="{{ route('showBooking', $booking->id) }}"
                                                        class="btn btn-primary btn-sm">{{ __('backend.details') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">{{ __('backend.no_data_found') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
