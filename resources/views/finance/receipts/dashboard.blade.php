@extends('layouts.admin', ['title' => 'Receipts'])

@section('content')

    <div class="page-title">
        <h3>{{ 'Receipts' }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('Dashboard') }}</li>
            </ol>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href="{{ route('receipts.create') }}"><i
                    class="fa fa-plus"></i>&nbsp;&nbsp;Create Cash Receipt</a>

                <a class="btn btn-primary" href="{{ route('receipts.online') }}"><i
                    class="fa fa-plus"></i>&nbsp;&nbsp;Create Online Receipt</a>

                <a class="btn btn-default" href="{{ route('receipts.index') }}"><i
                    class="fa fa-list-ol"></i>&nbsp;&nbsp;List of Receipt</a>
            </div>
        </div>

        <div class="row" style="margin-top: 20px">
            @foreach ($statistics as $item)
                <div class="col-md-4 mt-5">
                    <div class="panel info-box panel-white">
                        <div class="panel-body">
                            <div class="info-box-stats">
                                <p class="counter">{{ $item->amount }}</p>
                                <span class="info-box-title">{{$item->date }} by {{$item->user}}</span>
                            </div>
                            <div class="info-box-icon">
                                <i class="icon-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('scripts')
@endsection