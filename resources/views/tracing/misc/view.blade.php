@extends('layouts.admin', ['title' => 'Traceable Documents'])

@section('content')

<div class="page-title">
    <h3>Traceable Documents</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
            <li><a href="{{ route('misc.index') }}">Miscellaneous</a></li>
            <li class="active">View</li>
        </ol>
    </div>
</div>

<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            @include('alerts.alert')
            <a href="{{route('misc.edit', $misc->id)}}" class="btn btn-primary btn-lg"><i class="fa fa-pencil"></i> Edit</a>
            <a href="{{route('misc.status', $misc->id)}}" class="btn btn-warning btn-lg"><i class="fa fa-edit"></i> Change Status</a>
            {{-- <a class="btn btn-primary btn-lg " data-toggle="modal" data-target="#status">
                <i class="fa fa-bell fa-lg"></i> &nbsp; {{ __('backend.change_booking_status') }}
            </a> --}}

        </div>
        <div class="col-md-6">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">Document Details</h4>
                </div>
                <div class="panel-body">
                    <div id="account_details_view">
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>UID:</strong></div>
                            <div class="col-md-6">{{ optional($misc)->uid }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Applicant full name:</strong></div>
                            <div class="col-md-6">{{ optional($misc->trace)->applicant }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Email Address:</strong></div>
                            <div class="col-md-6">{{ optional($misc->trace)->email }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Department:</strong></div>
                            <div class="col-md-6">{{ optional($misc->department)->name_en }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Status:</strong></div>
                            <div class="col-md-6">{{ optional($misc->trace)->status }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Is Public:</strong></div>
                            <div class="col-md-6">
                                {!! optional($misc->trace)->is_public == 1 ? '<span class="badge badge-info">Yes</span>' : '<span class="badge badge-dark">No</span>' !!}
                            </div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Registrar:</strong></div>
                            <div class="col-md-6">{{ optional($misc->registrar)->full_name }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Created At:</strong></div>
                            <div class="col-md-6">{{ optional($misc->created_at)->format('Y-d-m') }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Missions Note:</strong></div>
                            <div class="col-md-6">{{ optional($misc->trace)->note ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">Miscellaneous Details</h4>
                </div>
                <div class="panel-body">
                    <div id="account_details_view">
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Doc Type:</strong></div>
                            <div class="col-md-6">{{ optional($misc->type)->type }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Notification Language:</strong></div>
                            <div class="col-md-6">{{ $misc->noti_lang }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Alternative Email:</strong></div>
                            <div class="col-md-6">{{ $misc->alt_email }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Phone number:</strong></div>
                            <div class="col-md-6">{{ $misc->phone_no }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Description:</strong></div>
                            <div class="col-md-6">
                                {{ $misc->descriptions }}
                            </div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Created At:</strong></div>
                            <div class="col-md-6">{{ optional($misc->created_at)->format('Y-d-m g:i A') }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>Last Changes:</strong></div>
                            <div class="col-md-6">{{ optional($misc->updated_at)->format('Y-d-m g:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection