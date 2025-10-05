@extends('layouts.admin', ['title' => __('backend.dashboard')])

@section('styles')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
@endsection

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
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('database_updated'))
                    <div class="alert alert-success">{{session('database_updated')}}</div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $todayCustomerCount }} <u>of</u> {{ $customers }}</p>
                            <span class="info-box-title">{{ __('backend.total_customers') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $todayBookings->count() }} <u>of</u> {{ $bookings }}</p>
                            <span class="info-box-title">{{ __('backend.total_bookings') }}</span>
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
                            <p class="counter">{{ $todayCancelledBookings }} <u>of</u> {{ $bookings_cancelled }}</p>
                            <span class="info-box-title">{{ __('backend.bookings_cancelled') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-arrow-down"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">
                                {{ $todayBookings->where('status', 'Completed')->count() }}
                            </p>
                            <span class="info-box-title">{{ __('Today\'s completed bookings') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-graph"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">
                                {{ $todayBookings->whereIn('status', ['Processing', 'In Progress'])->count() }}

                            </p>
                            <span class="info-box-title">{{ __('Today\'s in process bookings') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-bar-chart"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">
                                {{ $todayBookings->where('status', 'Waiting')->count() }}
                            </p>
                            <span class="info-box-title">{{ __('Today\'s untouched bookings') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-energy"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.weekly_booking_stats') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if($stats_booking!="[]")
                            <div id="bookings_chart"></div>
                        @else
                            <div class="alert alert-warning">{{ __('backend.no_data_found') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    @if($stats_booking!="[]")

        <script src="{{ asset('plugins/morris/raphael.min.js') }}"></script>
        <script src="{{ asset('plugins/morris/morris.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function () {

                Morris.Bar({
                    element: 'bookings_chart',
                    data: <?php echo $stats_booking; ?>,
                    xkey: 'date',
                    ykeys: ['value'],
                    labels: ['{{ __('backend.bookings') }}'],
                    barRatio: 0.4,
                    xLabelAngle: 35,
                    hideHover: 'auto',
                    barColors: ['{{ config('settings.primary_color') ? config('settings.primary_color') : '#007bff' }}'],
                    resize: true
                });

            });
        </script>

    @endif

@endsection