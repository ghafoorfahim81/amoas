@extends('layouts.admin', ['title' => 'Traceable Documents'])

@section('content')

    <div class="page-title">
        <h3>Traceable Documents</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('misc.index') }}">Miscellaneous</a></li>
                <li><a href="{{ route('misc.show', $misc->id) }}">View</a></li>
                <li class="active">Change status</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">Change status of doc</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('misc.changeStatus', $misc->id)}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            <div class="col-md-12 form-group {{$errors->has('status') ? ' has-error' : ''}}">
                                <label class="control-label" for="status"><span class="text-danger">*</span> Status <small>this field will directly send to applicant's email</small></label>
                                <input type="text" class="form-control" name="status" value="{{optional($misc->trace)->status }}">
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group {{$errors->has('noti_lang') ? ' has-error' : ''}}">
                                <label class="control-label" for="noti_lang"> Selected Email Language</label>
                                <select class="form-control" name="noti_lang">
                                    <option>{{ __('backend.select_one') }}</option>
                                    @foreach(array_values(preg_grep('/^([^.])/', scandir(resource_path('lang')))) as $key => $lang)
                                        
                                        <option value="{{$lang}}" {{ $lang==$misc->noti_lang ? 'selected' : null}}>{{$lang}}</option>
                                        
                                    @endforeach
                                </select>
                                @if ($errors->has('noti_lang'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('noti_lang') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group {{$errors->has('send') ? ' has-error' : ''}}">
                                <label class="control-label" for="send"><span class="text-danger">*</span> Send the changes to Applicant's email?</label>
                                <select class="form-control" name="send">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @if ($errors->has('is_public'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('is_public') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group {{$errors->has('note') ? ' has-error' : ''}}">
                                <label class="control-label" for="note">Mission's Note <small>this field will directly send to applicant</small></label>
                                <textarea class="form-control" name="note" rows="5">{{ optional($misc->trace)->note }}</textarea>
                                @if ($errors->has('note'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('note') }}</strong>
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