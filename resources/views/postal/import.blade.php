@extends('layouts.admin', ['title' => 'Postal Packages'])

@section('content')

    <div class="page-title">
        <h3>Postal Packages</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('postal.index') }}">Postal Packages</a></li>
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
                            <h4 class="panel-title">Add new Postal Packages</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('postal.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

                            <input type="hidden" name="booking_id" value="{{$booking->id}}">

                            <div class="col-md-3 form-group {{$errors->has('name') ? ' has-error' : ''}}">
                                <label class="control-label" for="name"><span class="text-danger">*</span> Applicant full name</label>
                                <input type="text" class="form-control" name="name" value="{{optional($booking->info)->full_name}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('post') ? ' has-error' : ''}}">
                                <label class="control-label" for="post">Postal Code</label>
                                <input type="text" class="form-control" name="post" value="{{optional($booking->info)->postal}}">
                                @if ($errors->has('post'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('post') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('place') ? ' has-error' : ''}}">
                                <label class="control-label" for="place">City</label>
                                <input type="text" class="form-control" name="place" value="{{optional($booking->info)->address}}">
                                @if ($errors->has('place'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('place') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('address') ? ' has-error' : ''}}">
                                <label class="control-label" for="address"><span class="text-danger">*</span>Track Number</label>
                                <input type="text" class="form-control" name="address" value="{{old('address')}}">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('street') ? ' has-error' : ''}}">
                                <label class="control-label" for="street">Street</label>
                                <input type="text" class="form-control" name="street" value="{{old('street')}}">
                                @if ($errors->has('street'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('street') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('house_no') ? ' has-error' : ''}}">
                                <label class="control-label" for="house_no">House Number</label>
                                <input type="text" class="form-control" name="house_no" value="{{old('house_no')}}">
                                @if ($errors->has('house_no'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('house_no') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('doc_price') ? ' has-error' : ''}}">
                                <label class="control-label" for="doc_price">Document Price (€)</label>
                                <input type="number" step="any" class="form-control" name="doc_price" value="{{old('doc_price')}}">
                                @if ($errors->has('doc_price'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('doc_price') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('post_price') ? ' has-error' : ''}}">
                                <label class="control-label" for="post_price">Post Price (€)</label>
                                <input type="number" step="any" class="form-control" name="post_price" value="{{old('post_price')}}">
                                @if ($errors->has('post_price'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('post_price') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('phone_no') ? ' has-error' : ''}}">
                                <label class="control-label" for="phone_no">Phone Number</label>
                                <input type="text" class="form-control" name="phone_no" value="{{optional($booking->info)->phone}}">
                                @if ($errors->has('phone_no'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3 form-group {{$errors->has('email') ? ' has-error' : ''}}">
                                <label class="control-label" for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="{{$booking->email}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('date') ? ' has-error' : ''}}">
                                <label class="control-label" for="date">Date</label>
                                <input type="date" value="{{date('Y-m-d')}}" class="form-control" name="date" value="{{old('date')}}">
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('status') ? ' has-error' : ''}}">
                                <label class="control-label" for="status">Status
                                    (<input type="checkbox" checked name="send_status_email"> Send Email to Applicant)
                                </label>
                                {{-- <input type="text" class="form-control" name="status" value="{{old('status')}}"> --}}
                                <select class="form-control" name="status">
                                    
                                    <option value="Label Created">Label Created</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Delivered">Delivered</option>
                                    <option value="Returned">Returned</option>
                                    <option value="Data Entry">Data Entry</option>
                                    <option value="Waiting">Waiting</option>
                                </select>
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <div class="row">
                                    @foreach (\App\Models\Post\PostCheckList::active()->get() as $cl)
                                        <div class="col-md-3">
                                            <input type="checkbox" name="checklist[{{$cl->id}}]"> {{$cl->name}}
                                        </div>
                                    @endforeach
                                    <div class="col-md-3">
                                        <input type="text" name="others" value="{{old('others')}}" style="width: 100%" placeholder="Others... if more, saparete with (-)dash.">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <hr>
                                <h3>List of Deliverable Documents</h3>
                            </div>

                            <div class="col-md-4">
                                @foreach (range(1,8) as $counter)
                                    
                                    {{-- <div class="col-md-4 form-group {{$errors->has('doc_type'. $counter) ? ' has-error' : ''}}">
                                        <label class="control-label" for="doc_type">Document type {{$counter}} </label>
                                        <input type="text" class="form-control" name="doc_type{{$counter}}" value="{{old('doc_type'. $counter)}}">
                                        @if ($errors->has('doc_type'. $counter))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('doc_type'. $counter) }}</strong>
                                            </span>
                                        @endif
                                    </div> --}}
    
                                    <div class="form-group {{$errors->has('name'. $counter) ? ' has-error' : ''}}">
                                        <label class="control-label" for="name">Name {{$counter}}</label>
                                        <input type="text" class="form-control" name="name{{$counter}}" value="{{old('name'. $counter)}}">
                                        @if ($errors->has('name'. $counter))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name'. $counter) }}</strong>
                                            </span>
                                        @endif
                                    </div>
    
                                    {{-- <div class="col-md-4 form-group {{$errors->has('uid'. $counter) ? ' has-error' : ''}}">
                                        <label class="control-label" for="uid">Unique ID (uid) {{$counter}}</label>
                                        <input type="text" class="form-control" name="uid{{$counter}}" value="{{old('uid'. $counter)}}">
                                        @if ($errors->has('uid'. $counter))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('uid'. $counter) }}</strong>
                                            </span>
                                        @endif
                                    </div> --}}
                                @endforeach
                                
                            </div>

                            <div class="col-md-8 form-group {{$errors->has('description') ? ' has-error' : ''}}">
                                <label class="control-label" for="description">Remarks</label>
                                <textarea class="form-control" name="description" rows="10">{{old('description')}}</textarea>
                                @if ($errors->has('descriptions'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
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