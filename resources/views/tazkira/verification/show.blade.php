@extends('layouts.customer', ['title' => __('backend.bookings')])

@section('content')

<div class="page-title">
    <h3>{{ __('backend.tazkira') }}</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
            <li class="active">{{ __('backend.tazkira') }}</li>
            <li><a href="{{ route('verification.index') }}">{{ __('backend.verification') }}</a></li>
        </ol>
    </div>
</div>

<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            @include('alerts.bookings')

            <a class="btn btn-primary btn-lg btn-add" href="{{ route('verification.create') }}"><i class="fa fa-plus"></i> {{__('tazkira.add')}} </a>
            <a class="btn btn-default btn-lg btn-add" href="{{ route('verification.edit', $verification->id) }}"><i class="fa fa-edit"></i> {{__('tazkira.edit')}} </a>
            <!-- <a class="btn btn-default btn-lg btn-add" href="{{-- route('verification.print', $verification->id) --}}"><i class="fa fa-print"></i> {{__('tazkira.print')}} </a> -->
            <span class="dropdown">
                <a class="btn btn-default btn-lg btn-add dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-print"></i> {{__('tazkira.print')}}
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-item" href="#">
                        <a class="btn btn-default btn-lg" href="{{ route('verification.print.excel', $verification->id) }}"><i class="fa fa-file-excel-o"></i> {{__('tazkira.print')}} {{__('tazkira.excel')}} </a>
                    </li>
                    <li class="dropdown-item" href="#">
                        <a class="btn btn-default btn-lg" href="{{ route('verification.print.word', $verification->id) }}"><i class="fa fa-file-word-o"></i> {{__('tazkira.print')}} {{__('tazkira.word')}} </a>
                    </li>
                    {{-- <li class="dropdown-item" href="#">
                        <a class="btn btn-default btn-lg" href="{{ route('verification.print.pdf', $verification->id) }}"><i class="fa fa-file-pdf-o"></i> {{__('tazkira.print')}} {{__('tazkira.pdf')}} </a>
                    </li> --}}
                </ul>
            </span>

            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <div class="col-md-12">
                        <h4 class="panel-title"> {{ __('backend.verification') }}</h4>
                    </div>
                </div>
                @php
                if(app()->isLocale('dr') || app()->isLocale('ps')){
                setlocale(LC_TIME, 'fa_IR');
                Carbon\Carbon::setLocale('fa');
                }
                @endphp
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{$verification->image ? asset('img/verification/' . $verification->image->path) :
                                    asset('images/profile-placeholder.png') }}" class="img-fluid img-thumbnail">
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.name')}}</label>
                            <p><strong>{{$verification->name}} {{$verification->last_name}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.father_name')}}</label>
                            <p><strong>{{$verification->father_name}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.grand_father_name')}}</label>
                            <p><strong>{{$verification->grand_father_name}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.birth_place')}}</label>
                            <p><strong>{{$verification->birth_place}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.marital_status')}}</label>
                            <p><strong>{{ __('tazkira.' . $verification->marital_status)}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.occupation')}}</label>
                            <p><strong>{{$verification->occupation}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.contact_no')}}</label>
                            <p><strong>{{$verification->contact_no}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.email')}}</label>
                            <p><strong>{{$verification->email}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.living_duration')}}</label>
                            <p><strong>{{$verification->living_duration}} {{ __('tazkira.' . $verification->living_duration_unit)}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.last_trip')}}</label>
                            <p><strong>{{$verification->last_trip}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.service_type')}}</label>
                            <p><strong>{{app()->isLocale('dr') || app()->isLocale('ps') ? $verification->service->label_dr : $verification->service->label_en}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.original_village')}}</label>
                            <p><strong>{{app()->isLocale('dr') || app()->isLocale('ps') ? $verification->village->label_dr : $verification->village->label_en}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.original_district')}}</label>
                            <p><strong>{{app()->isLocale('dr') || app()->isLocale('ps') ? $verification->district->label_dr : $verification->district->label_en}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.original_province')}}</label>
                            <p><strong>{{app()->isLocale('dr') || app()->isLocale('ps') ? $verification->province->label_dr : $verification->province->label_en}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.current_city')}}</label>
                            <p><strong>{{$verification->current_city}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.zip_code')}}</label>
                            <p><strong>{{$verification->zip_code}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.current_country')}}</label>
                            <p><strong>{{app()->isLocale('dr') || app()->isLocale('ps') ? $verification->country->name_dr : $verification->country->name_en}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.height')}}</label>
                            <p><strong>{{$verification->height}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.eyes')}}</label>
                            <p><strong>{{$verification->eyes}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.skin')}}</label>
                            <p><strong>{{$verification->skin}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.hair')}}</label>
                            <p><strong>{{$verification->hair}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.other')}}</label>
                            <p><strong>{{$verification->other}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.d_name')}}</label>
                            <p><strong>{{$verification->d_name}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.d_last_name')}}</label>
                            <p><strong>{{$verification->d_last_name}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.d_father_name')}}</label>
                            <p><strong>{{$verification->d_father_name}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.d_contact')}}</label>
                            <p><strong>{{$verification->d_contact}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.sibling_name')}}</label>
                            <p><strong>{{$verification->sibling_name}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.sibling_last_name')}}</label>
                            <p><strong>{{$verification->sibling_last_name}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.sibling_father_name')}}</label>
                            <p><strong>{{$verification->sibling_father_name}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.sibling_grand_father_name')}}</label>
                            <p><strong>{{$verification->sibling_grand_father_name}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.sibling_type')}}</label>
                            <p><strong>{{app()->isLocale('dr') || app()->isLocale('ps') ? $verification->sibling->label_dr : $verification->sibling->label_en}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.page_no')}}</label>
                            <p><strong>{{$verification->page_no}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.version_no')}}</label>
                            <p><strong>{{$verification->version_no}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.note_no')}}</label>
                            <p><strong>{{$verification->note_no}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.year')}}</label>
                            <p><strong>{{$verification->year}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.month')}}</label>
                            <p><strong>{{$verification->month}}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{ __('tazkira.day')}}</label>
                            <p><strong>{{$verification->day}}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection