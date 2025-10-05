@extends('layouts.admin', ['title' => 'Passport Extensions'])

@section('content')

    <div class="page-title">
        <h3>Passport Extensions</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('extensions.index') }}">Passport Extensions</a></li>
                <li class="active">Create</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">Add new Passport Extensions</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('extensions.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

                            <div class="col-md-4 form-group {{$errors->has('pass_no') ? ' has-error' : ''}}">
                                <label class="control-label" for="pass_no"><span class="text-danger">*</span> Passport Number</label>
                                <input type="text" class="form-control" name="pass_no" value="{{old('pass_no')}}">
                                @if ($errors->has('pass_no'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('pass_no') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 form-group {{$errors->has('given_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="given_name"><span class="text-danger">*</span> Given name</label>
                                <input type="text" class="form-control" name="given_name" value="{{old('given_name')}}">
                                @if ($errors->has('given_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('given_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 form-group {{$errors->has('last_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="last_name"><span class="text-danger">*</span> Last name</label>
                                <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-md-4 form-group {{$errors->has('phone') ? ' has-error' : ''}}">
                                <label class="control-label" for="phone">Phone Number</label>
                                <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 form-group {{$errors->has('invoice_no') ? ' has-error' : ''}}">
                                <label class="control-label" for="invoice_no">Invoice Number</label>
                                <input type="text" class="form-control" name="invoice_no" value="{{old('invoice_no')}}">
                                @if ($errors->has('invoice_no'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('invoice_no') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group">
                                <hr>
                                <h3>List of Family members' passport</h3>
                            </div>

                            <div class="col-md-8">
                                @foreach (range(1,6) as $counter)
    
                                    <div class="col-md-4 form-group {{$errors->has('pass_no'. $counter) ? ' has-error' : ''}}">
                                        <label class="control-label" for="pass_no">Passport Number {{$counter}}</label>
                                        <input type="text" class="form-control" name="pass_no{{$counter}}" value="{{old('pass_no'. $counter)}}">
                                        @if ($errors->has('pass_no'. $counter))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('pass_no'. $counter) }}</strong>
                                            </span>
                                        @endif
                                    </div>
    
                                    <div class="col-md-4 form-group {{$errors->has('given_name'. $counter) ? ' has-error' : ''}}">
                                        <label class="control-label" for="given_name">Given name {{$counter}}</label>
                                        <input type="text" class="form-control" name="given_name{{$counter}}" value="{{old('given_name'. $counter)}}">
                                        @if ($errors->has('given_name'. $counter))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('given_name'. $counter) }}</strong>
                                            </span>
                                        @endif
                                    </div>
    
                                    <div class="col-md-4 form-group {{$errors->has('last_name'. $counter) ? ' has-error' : ''}}">
                                        <label class="control-label" for="last_name">Last name {{$counter}}</label>
                                        <input type="text" class="form-control" name="last_name{{$counter}}" value="{{old('last_name'. $counter)}}">
                                        @if ($errors->has('last_name'. $counter))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('last_name'. $counter) }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                                
                            </div>

                            <div class="col-md-4 form-group {{$errors->has('remarks') ? ' has-error' : ''}}">
                                <label class="control-label" for="remarks">Remarks</label>
                                <textarea class="form-control" name="remarks" rows="20">{{old('remarks')}}</textarea>
                                @if ($errors->has('remarks'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('remarks') }}</strong>
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