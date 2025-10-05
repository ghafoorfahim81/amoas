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
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.verification') }}</h4>
                        </div>
                    </div>
                    @php
                        if(app()->isLocale('dr') || app()->isLocale('ps')){
                            setlocale(LC_TIME, 'fa_IR');
                            Carbon\Carbon::setLocale('fa');
                        }
                    @endphp
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('tazkira.name') }}</th>
                                    <th>{{ __('tazkira.father_name') }}</th>
                                    <th>{{ __('tazkira.service') }}</th>
                                    <th>{{ __('tazkira.address') }}</th>
                                    <th>{{ __('tazkira.sibling') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('tazkira.name') }}</th>
                                    <th>{{ __('tazkira.father_name') }}</th>
                                    <th>{{ __('tazkira.service') }}</th>
                                    <th>{{ __('tazkira.address') }}</th>
                                    <th>{{ __('tazkira.sibling') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($verifications as $key => $v)
                                    <tr>
                                        <td>{{ ($verifications->currentPage() == 0 ? 1 :$verifications->currentPage() - 1) * $verifications ->perPage() + $key + 1}}</td>
                                        <td>{{ $v->name }} {{ $v->last_name }}</td>
                                        <td>{{ $v->father_name }}</td>
                                        <td>{{ app()->isLocale('dr') || app()->isLocale('ps') ? $v->service->label_dr : $v->service->label_en }}</td>
                                        <td>({{ $v->current_city }}) {{ app()->isLocale('dr') || app()->isLocale('ps') ? $v->country->name_dr : $v->country->name_en }}</td>
                                        <td>{{ app()->isLocale('dr') || app()->isLocale('ps') ? $v->sibling->label_dr : $v->sibling->label_en }}</td>
                                        <td>{{ $v->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('verification.show', $v->id) }}" class="btn btn-primary btn-sm">{{ __('backend.details') }}</a>
                                        </td>
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