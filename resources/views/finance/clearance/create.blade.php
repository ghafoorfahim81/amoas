@extends('layouts.admin', ['title' => 'Clearance'])

@section('content')

    <div class="page-title">
        <h3>Clearance</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('clearance.dashboard') }}">Clearance</a></li>
                <li class="active">Create</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">Add new Clearance</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" id="form" action="{{route('clearance.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

                            <div class="form-group {{$errors->has('date') ? ' has-error' : ''}}">
                                <label class="control-label" for="date"><span class="text-danger">*</span> Deliver Date (required)</label>
                                <input type="date" class="form-control" required name="date" value="{{old('date')}}">
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('receiver_account') ? ' has-error' : ''}}">
                                <label class="control-label" for="name"><span class="text-danger">*</span> Receiver User Account (required)</label>
                                <select class="form-control" required name="receiver_account">
                                    <option value=""></option>
                                    @foreach (\App\User::with('role')->whereIn('role_id', [1,3])->get(); as $s)
                                        <option value="{{$s->id}}">{{$s->fullName}}</option>                                        
                                    @endforeach
                                </select>
                                @if ($errors->has('receiver_account'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('receiver_account') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('deliver_account') ? ' has-error' : ''}}">
                                <label class="control-label" for="name"><span class="text-danger">*</span> Deliver User Account (required)</label>
                                <select class="form-control" required name="deliver_account">
                                    <option value=""></option>
                                    @foreach (\App\User::with('role')->whereIn('role_id', [1,3])->get(); as $s)
                                        <option value="{{$s->id}}">{{$s->fullName}}</option>                                        
                                    @endforeach
                                </select>
                                @if ($errors->has('deliver_account'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('deliver_account') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('clear_from') ? ' has-error' : ''}}">
                                <label class="control-label" for="clear_from"><span class="text-danger">*</span> Clear From Date (required)</label>
                                <input type="date" class="form-control" required name="clear_from" value="{{old('clear_from')}}">
                                @if ($errors->has('clear_from'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('clear_from') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('clear_to') ? ' has-error' : ''}}">
                                <label class="control-label" for="clear_to"><span class="text-danger">*</span> Clear To Date (required)</label>
                                <input type="date" class="form-control" required name="clear_to" value="{{old('clear_to')}}">
                                @if ($errors->has('clear_to'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('clear_to') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('file') ? ' has-error' : ''}}">
                                <label class="control-label" for="file"><span class="text-danger">*</span> Clear To Date (required)</label>
                                <input type="file" name="file" class="form-control">
                                @if ($errors->has('file'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('remarks') ? ' has-error' : ''}}">
                                <label class="control-label" for="remarks">Remarks (optional)</label>
                                <textarea name="remarks" class="form-control">{{old('remarks')}}</textarea>
                                @if ($errors->has('remarks'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('remarks') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">Save and Print</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="panel panel-white">
                    <!-- 4:3 aspect ratio -->
                    <div class="embed-responsive embed-responsive-4by3">
                        <iframe class="embed-responsive-item" src="{{asset('images/loader.gif')}}" allowfullscreen></iframe>
                    </div>
                </div>
            </div> --}}
        </div>
        
    </div>

@endsection