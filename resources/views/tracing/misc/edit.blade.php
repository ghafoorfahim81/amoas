@extends('layouts.admin', ['title' => 'Traceable Documents'])

@section('content')

    <div class="page-title">
        <h3>Traceable Documents</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('misc.index') }}">Miscellaneous</a></li>
                <li><a href="{{ route('misc.show', $misc->id) }}">View</a></li>
                <li class="active">Edit</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <form method="post" action="{{route('misc.update', $misc->id)}}" enctype="multipart/form-data">
                <div class="col-md-6">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">Edit Doc part</h4>
                            </div>
                        </div>
                        <div class="panel-body">

                            {{csrf_field()}}
                            @method('PUT')
                            <div class="col-md-12 form-group {{$errors->has('applicant') ? ' has-error' : ''}}">
                                <label class="control-label" for="applicant"><span class="text-danger">*</span> Applicant full name</label>
                                <input type="text" class="form-control" name="applicant" value="{{ optional($misc->trace)->applicant }}">
                                @if ($errors->has('applicant'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('applicant') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group {{$errors->has('email') ? ' has-error' : ''}}">
                                <label class="control-label" for="email"><span class="text-danger">*</span> Email Address</label>
                                <input type="text" class="form-control" name="email" value="{{ optional($misc->trace)->email }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group {{$errors->has('is_public') ? ' has-error' : ''}}">
                                <label class="control-label" for="is_public"><span class="text-danger">*</span> Is public</label>
                                <select class="form-control" name="is_public">
                                    <option>{{ __('backend.select_one') }}</option>
                                    <option value="1" {{ optional($misc->trace)->is_public ==1 ? 'selected' : null}}>Yes</option>
                                    <option value="0" {{ optional($misc->trace)->is_public ==0 ? 'selected' : null}}>No</option>
                                </select>
                                @if ($errors->has('is_public'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('is_public') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">Edit Miscellaneous part</h4>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="col-md-12 form-group {{$errors->has('alt_email') ? ' has-error' : ''}}">
                                <label class="control-label" for="alt_email">Alternative Email</label>
                                <input type="text" class="form-control" name="alt_email" value="{{ $misc->alt_email}}">
                                @if ($errors->has('alt_email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{!! $errors->has('alt_email') ? $errors->first('alt_email') : '&nbsp;&nbsp;' !!}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group {{$errors->has('doc_type') ? ' has-error' : ''}}">
                                <label class="control-label" for="doc_type"><span class="text-danger">*</span> Doc Type</label>
                                <select class="form-control" name="doc_type">
                                    <option>{{ __('backend.select_one') }}</option>
                                    @foreach(\App\Models\Tracing\MiscellaneousType::all() as $type)
                                        @if( $misc->doc_type == $type->id)
                                            <option value="{{$type->id}}" selected>{{$type->type}}</option>
                                        @else
                                            <option value="{{$type->id}}">{{$type->type}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('doc_type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('doc_type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group {{$errors->has('noti_lang') ? ' has-error' : ''}}">
                                <label class="control-label" for="noti_lang"><span class="text-danger">*</span> Notification Language</label>
                                <select class="form-control" name="noti_lang">
                                    <option>{{ __('backend.select_one') }}</option>
                                    @foreach(array_values(preg_grep('/^([^.])/', scandir(resource_path('lang')))) as $key => $lang)
                                        @if( $misc->noti_lang == $lang)
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

                            <div class="col-md-12 form-group {{$errors->has('phone_no') ? ' has-error' : ''}}">
                                <label class="control-label" for="phone_no">Phone Number</label>
                                <input type="text" class="form-control" name="phone_no" value="{{ $misc->phone_no}}">
                                @if ($errors->has('phone_no'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12 form-group {{$errors->has('descriptions') ? ' has-error' : ''}}">
                                <label class="control-label" for="descriptions">Descriptions</label>
                                <textarea class="form-control" name="descriptions" rows="5">{{ $misc->descriptions}}</textarea>
                                @if ($errors->has('descriptions'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('descriptions') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group  text-right">
                                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection