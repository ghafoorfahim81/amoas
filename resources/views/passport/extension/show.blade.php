@extends('layouts.admin', ['title' => 'Passport Extensions'])

@section('content')

    <div class="page-title">
        <h3>Passport Extensions</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('extensions.index') }}">Passport Extensions</a></li>
                <li class="active">View {{ $extension->pass_no }}</li>
            </ol>
        </div>
    </div>

<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            @include('alerts.bookings')

            <a class="btn btn-primary btn-lg" href="{{ route('extensions.create') }}"><i
                    class="fa fa-plus"></i>&nbsp;&nbsp;Create</a>
            <a class="btn btn-default btn-lg" href="{{ route('extensions.edit', $extension->id) }}"><i
                        class="fa fa-pencil fa-lg"></i> &nbsp; {{ __('Edit') }}</a>

            <a class="btn btn-default btn-lg " data-toggle="modal" data-target="#confirm"><i
                    class="fa fa-refresh fa-lg"></i> &nbsp; {{ __('Change Status') }}</a>
            <br>
            <br>

        </div>
        <div class="col-md-7">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('Extension Details') }}</h4>
                </div>
                <div class="panel-body">
                    <div id="account_details_view">
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Passport Number') }}:</strong></div>
                            <div class="col-md-6">{{  $extension->pass_no }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Name/ Family Name') }}:</strong></div>
                            <div class="col-md-6">{{  $extension->last_name }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Vorname/Given Name') }}:</strong></div>
                            <div class="col-md-6">{{ $extension->given_name }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Status') }}:</strong></div>
                            <div class="col-md-6"><span class="badge">{{  $extension->status }}</span></div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Bill Invoice') }}:</strong></div>
                            <div class="col-md-6">{{  $extension->invoice_no }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Postal Code') }}:</strong></div>
                            <div class="col-md-6">{{  $extension->postal_code }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Place') }}:</strong></div>
                            <div class="col-md-6">{{ $extension->place }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('street') }}:</strong></div>
                            <div class="col-md-6">{{ $extension->street }}</div>
                        </div>
                        
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('House Number') }}:</strong></div>
                            <div class="col-md-6">{{ $extension->house_no }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Phone No') }}:</strong></div>
                            <div class="col-md-6">{{ $extension->phone }}</div>
                        </div>

                        @if ($extension->members->count() > 0)
                            
                            <div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('Family Members') }}:</strong></div>
                                <div class="col-md-6">{{ $extension->members->count() }}</div>
                            </div>
                        @endif
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Registrar') }}:</strong></div>
                            <div class="col-md-6">{{ optional($extension->registrar)->first_name . ' ' . optional($extension->registrar)->last_name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('Family Members') }}</h4>
                </div>
                <div class="panel-body">
                    <div id="account_details_view">
                        @foreach ($extension->members as $key => $member)
                            <div class="list-group">
                                <li class="list-group-item">
                                    <span class="badge">{{$member->status}}</span>
                                    <h4 class="list-group-item-heading">{{$key + 1}}. {{$member->given_name . ' ' . $member->last_name}}</h4>
                                    <p class="list-group-item-text">{{$member->pass_no}}</p>
                                </li>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

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
            
                <form method="post" action="{{ route('extensions.status', $extension->id) }}">
                    <div class="form-group">
                        <label class="control-label" for="pass_no"><span class="text-danger">*</span> Change process status</label>
                        <select class="form-control" name="status">
                            <option value="registered" {{$extension->status == 'registered' ? 'selected' : null }}>Registered</option>
                            <option value="extended" {{$extension->status == 'extended' ? 'selected' : null }}>Extended</option>
                            <option value="posted" {{$extension->status == 'posted' ? 'selected' : null }}>Posted</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        {{csrf_field()}}

                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ __('backend.no') }}</button>
                        <button type="submit" class="btn btn-default">{{ __('Change') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

</script>

@endsection