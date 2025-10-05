@extends('layouts.admin', ['title' => 'Clearance'])

@section('content')

<div class="page-title">
    <h3>Clearance</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
            <li class="active"><a href="{{ route('clearance.dashboard') }}">Clearance</a></li>
            <li class="active">Details</li>
        </ol>
    </div>
</div>

<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            @include('alerts.bookings')

            <a class="btn btn-primary btn-lg" href="{{ route('birth.create') }}"><i
                    class="fa fa-plus"></i>&nbsp;&nbsp;Create</a>
            <br>

        </div>
        <div class="col-md-6">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('Clearance Details') }}</h4>
                </div>
                <div class="panel-body">
                    <div id="account_details_view">
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Deliver Date:</strong></div>
                            <div class="col-md-6">{{  $clearance->date }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Receiver User Account:</strong></div>
                            <div class="col-md-6">{{  optional($clearance->receiver)->full_name }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Deliver User Account:</strong></div>
                            <div class="col-md-6">{{ optional($clearance->deliver)->full_name }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Clear From Date:</strong></div>
                            <div class="col-md-6">{{ $clearance->clear_from }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Clear To Date:</strong></div>
                            <div class="col-md-6">{{ $clearance->clear_from }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Remarks (optional):</strong></div>
                            <div class="col-md-6">{{ $clearance->remarks }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <embed class="embed-responsive-item" src="{{route('clearance.print', $clearance->id)}}" type="application/pdf"></embed>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('Transactions') }}</h4>
                </div>
                <div class="panel-body">
                    <div id="account_details_view">
                        <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Transaction No</th>
                                    <th>Receipt No</th>
                                    <th>Date</th>
                                    <th>Client Name</th>
                                    <th>IDCard</th>
                                    <th>Services</th>
                                    <th>Amount</th>
                                    <th>Delivered By</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clearance->receipts as $key => $r)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$r->transactionNo}}</td>
                                            <td>{{$r->receipt_no}}</td>
                                            <td>{{optional($r->date)->format('Y-m-d')}}</td>
                                            <td>{{$r->client_name}}</td>
                                            <td>{{$r->id_card}}</td>
                                            <td>{{optional($r->service)->name}}</td>
                                            <td>{{optional($r->transaction)->amount}}</td>
                                            <td>{{optional($r->registrar)->full_name}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection