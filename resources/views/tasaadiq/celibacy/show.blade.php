@extends('layouts.admin', ['title' => 'Celibacy Certificates'])

@section('content')

    <div class="page-title">
        <h3>Celibacy Certificates</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('celibacy.index') }}">Celibacy Certificates</a></li>
                <li class="active">View {{ $celibacy->serial_no }}</li>
            </ol>
        </div>
    </div>

<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            @include('alerts.bookings')

            <a class="btn btn-primary btn-lg" href="{{ route('celibacy.create') }}"><i
                    class="fa fa-plus"></i>&nbsp;&nbsp;Create</a>
            <a class="btn btn-default btn-lg" href="{{ route('celibacy.edit', $celibacy->id) }}"><i
                        class="fa fa-pencil fa-lg"></i> &nbsp; {{ __('Edit') }}</a>
            <a class="btn btn-default btn-lg" href="{{ route('celibacy.print', $celibacy->id) }}"><i
                        class="fa fa-print fa-lg"></i> &nbsp; {{ __('Print') }}</a>

            <a class="btn btn-danger btn-lg " data-toggle="modal" data-target="#confirm"><i
                    class="fa fa-trash-o fa-lg"></i> &nbsp; {{ __('backend.delete_booking') }}</a>
            <br>
            <br>

        </div>
        <div class="col-md-8">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('Certificate Details') }}</h4>
                </div>
                <div class="panel-body">
                    <div id="account_details_view">
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('backend.serial_no') }}:</strong></div>
                            <div class="col-md-6">{{  $celibacy->serial_no }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Issue Date') }}:</strong></div>
                            <div class="col-md-6">{{  $celibacy->issue_date }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Name/ Family Name') }}:</strong></div>
                            <div class="col-md-6">{{  $celibacy->family_name }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Vorname/Given Name') }}:</strong></div>
                            <div class="col-md-6">{{ $celibacy->given_name }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Geschlecht /Sex') }}:</strong></div>
                            <div class="col-md-6">{{ $celibacy->sex }}</div>
                        </div>
                        
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Geburtsdatum /Date of Birth') }}:</strong></div>
                            <div class="col-md-6">{{ $celibacy->dob }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Geburtsort/Place of birth') }}:</strong></div>
                            <div class="col-md-6">{{ $celibacy->pob }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Passnummer/Tazkira No/Passport No') }}:</strong></div>
                            <div class="col-md-6">{{ $celibacy->passport_no }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('Registrar') }}:</strong></div>
                            <div class="col-md-6">{{ optional($celibacy->registrar)->first_name . ' ' . optional($celibacy->registrar)->last_name }}</div>
                        </div>
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
                <p>{{ __('Are you sure you want to delete this data? This action is not reversible?') }}</p>
            </div>
            <form method="post" action="{{ route('celibacy.destroy', $celibacy->id) }}">
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

<script>

    var isPrint = "{{session('print')}}"

    if(isPrint){

        // Your application has indicated there's an error
        window.setTimeout(function(){

            // Move to a new location or you can do something else
            window.open(
                '{{route("celibacy.print", $celibacy->id)}}',
                '_blank' // <- This is what makes it open in a new window.
            );

        }, 1000);

    }

</script>

@endsection