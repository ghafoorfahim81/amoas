@extends('layouts.admin', ['title' => 'Traceable Documents'])

@section('content')

    <div class="page-title">
        <h3>Traceable Documents</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('misc.index') }}">Miscellaneous</a></li>
                <li class="active">Import</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">Import Miscellaneous docs for <u>({{optional($booking->info)->full_name}})</u></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('misc.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

                            <input type="hidden" name="booking_id" value="{{$booking->id}}">

                            <div class="col-md-4 form-group {{$errors->has('applicant') ? ' has-error' : ''}}">
                                <label class="control-label" for="applicant"><span class="text-danger">*</span> Applicant full name</label>
                                <input type="text" class="form-control" name="applicant" value="{{optional($booking->info)->full_name}}">
                                @if ($errors->has('applicant'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('applicant') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 form-group {{$errors->has('email') ? ' has-error' : ''}}">
                                <label class="control-label" for="email"><span class="text-danger">*</span> Email Address</label>
                                <input type="text" class="form-control" name="email" value="{{$booking->email}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 form-group {{$errors->has('alt_email') ? ' has-error' : ''}}">
                                <label class="control-label" for="alt_email">Alternative Email</label>
                                <input type="text" class="form-control" name="alt_email" value="{{optional($booking->user)->email == $booking->email ? null : optional($booking->user)->email}}">
                                @if ($errors->has('email') || $errors->has('applicant') || $errors->has('alt_email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{!! $errors->has('alt_email') ? $errors->first('alt_email') : '&nbsp;&nbsp;' !!}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 form-group {{$errors->has('doc_type') ? ' has-error' : ''}}">
                                <label class="control-label" for="doc_type"><span class="text-danger">*</span> Doc Type</label>
                                <select class="form-control" name="doc_type">
                                    <option>{{ __('backend.select_one') }}</option>
                                    @foreach(\App\Models\Tracing\MiscellaneousType::all() as $type)
                                        <option value="{{$type->id}}" {{$type->package_id != $booking->package_id ? null : 'selected'}}>{{$type->type}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('doc_type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('doc_type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 form-group {{$errors->has('noti_lang') ? ' has-error' : ''}}">
                                <label class="control-label" for="noti_lang"><span class="text-danger">*</span> Notification Language</label>
                                <select class="form-control" name="noti_lang">
                                    <option>{{ __('backend.select_one') }}</option>
                                    @foreach(array_values(preg_grep('/^([^.])/', scandir(resource_path('lang')))) as $key => $lang)
                                        @if(old('noti_lang') == $lang)
                                            <option value="{{$lang}}" selected>{{$lang}}</option>
                                        @else
                                            <option value="{{$lang}}" {{ $key==0 ? 'selected' : null}}>{{$lang}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('noti_lang'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('noti_lang') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 form-group {{$errors->has('phone_no') ? ' has-error' : ''}}">
                                <label class="control-label" for="phone_no">Phone Number</label>
                                <input type="text" class="form-control" name="phone_no" value="{{optional($booking->info)->phone}}">
                                @if ($errors->has('phone_no'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12 form-group {{$errors->has('descriptions') ? ' has-error' : ''}}">
                                <label class="control-label" for="descriptions">Descriptions</label>
                                <textarea class="form-control" name="descriptions" rows="5">{{old('descriptions')}}</textarea>
                                @if ($errors->has('descriptions'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('descriptions') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group  text-right">
                                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection