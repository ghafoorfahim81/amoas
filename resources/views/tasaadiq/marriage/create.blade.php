@extends('layouts.admin', ['title' => 'Marriage Certificates'])

@section('content')

    <div class="page-title">
        <h3>Marriage Certificates</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('marriage.index') }}">Marriage Certificates</a></li>
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
                            <h4 class="panel-title">Add new Marriage Certificates</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('marriage.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h4>Husband's Info</h4>
                                </div>
                                <div class="form-group {{$errors->has('husband_family_name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="husband_family_name"><span class="text-danger">*</span> Name/ Family Name</label>
                                    <input type="text" autofocus class="form-control" name="husband_family_name" value="{{old('husband_family_name')}}">
                                    @if ($errors->has('husband_family_name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('husband_family_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('husband_given_name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="husband_given_name"><span class="text-danger">*</span> Vorname/Given Name</label>
                                    <input type="text" class="form-control" name="husband_given_name" value="{{old('husband_given_name')}}">
                                    @if ($errors->has('husband_given_name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('husband_given_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('husband_previous_name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="husband_previous_name">Name vor der Eheschließung /Name before the marriage</label>
                                    <input type="text" class="form-control" name="husband_previous_name" value="{{old('husband_previous_name')}}">
                                    @if ($errors->has('husband_previous_name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('husband_previous_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('husband_dob') ? ' has-error' : ''}}">
                                    <label class="control-label" for="husband_dob"><span class="text-danger">*</span> Geburtsdatum /Date of Birth</label>
                                    <input type="date" class="form-control" name="husband_dob" value="{{old('husband_dob')}}">
                                    @if ($errors->has('husband_dob'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('husband_dob') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('husband_pob') ? ' has-error' : ''}}">
                                    <label class="control-label" for="husband_pob"><span class="text-danger">*</span> Geburtsort/Place of birth</label>
                                    <select class="form-control simple-select2" name="husband_pob">
                                        <option value="">{{ __('backend.select_one') }}</option>
                                        @foreach (\DB::table('provinces')->get() as $province)
                                        <option value="{{$province->label_en}}" {{ $province->label_en == old('husband_pob') ? 'selected' : null }}> 
                                            {{ $province->label_en }} ({{$province->label_dr}})
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('husband_pob'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('husband_pob') }}</strong>
                                        </span>
                                    @endif
                                    <input type="text" placeholder="Or born outside of country..." class="form-control" name="husband_pob_outside" value="{{old('husband_pob_outside')}}">
                                    @if ($errors->has('husband_pob_outside'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('husband_pob_outside') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('husband_passport_no') ? ' has-error' : ''}}">
                                    <label class="control-label" for="husband_passport_no"><span class="text-danger">*</span> Passnummer/Tazkira No/Passport No</label>
                                    <input type="text" class="form-control" name="husband_passport_no" value="{{old('husband_passport_no')}}">
                                    @if ($errors->has('husband_passport_no'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('husband_passport_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h4>Wife's Info</h4>
                                </div>
                                <div class="form-group {{$errors->has('wife_family_name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="wife_family_name"><span class="text-danger">*</span> Name/ Family Name</label>
                                    <input type="text" class="form-control" name="wife_family_name" value="{{old('wife_family_name')}}">
                                    @if ($errors->has('wife_family_name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('wife_family_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('wife_given_name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="wife_given_name"><span class="text-danger">*</span> Vorname/Given Name</label>
                                    <input type="text" class="form-control" name="wife_given_name" value="{{old('wife_given_name')}}">
                                    @if ($errors->has('wife_given_name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('wife_given_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('wife_previous_name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="wife_previous_name">Name vor der Eheschließung /Name before the marriage</label>
                                    <input type="text" class="form-control" name="wife_previous_name" value="{{old('wife_previous_name')}}">
                                    @if ($errors->has('wife_previous_name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('wife_previous_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('wife_dob') ? ' has-error' : ''}}">
                                    <label class="control-label" for="wife_dob"><span class="text-danger">*</span> Geburtsdatum /Date of Birth</label>
                                    <input type="date" class="form-control" name="wife_dob" value="{{old('wife_dob')}}">
                                    @if ($errors->has('wife_dob'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('wife_dob') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('wife_pob') ? ' has-error' : ''}}">
                                    <label class="control-label" for="wife_pob"><span class="text-danger">*</span> Geburtsort/Place of birth</label>
                                    <select class="form-control simple-select2 {{ $errors->has('wife_pob') ? 'is-invalid' : '' }}" name="wife_pob">
                                        <option value="">{{ __('backend.select_one') }}</option>
                                        @foreach (\DB::table('provinces')->get() as $province)
                                        <option value="{{$province->label_en}}" {{ $province->label_en == old('wife_pob') ? 'selected' : null }}> 
                                            {{ $province->label_en }} ({{$province->label_dr}})
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('wife_pob'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('wife_pob') }}</strong>
                                        </span>
                                    @endif
                                    <input type="text" placeholder="Or born outside of country..." class="form-control" name="wife_pob_outside" value="{{old('wife_pob_outside')}}">
                                    @if ($errors->has('wife_pob_outside'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('wife_pob_outside') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('wife_passport_no') ? ' has-error' : ''}}">
                                    <label class="control-label" for="wife_passport_no"><span class="text-danger">*</span> Passnummer/Tazkira No/Passport No</label>
                                    <input type="text" class="form-control" name="wife_passport_no" value="{{old('wife_passport_no')}}">
                                    @if ($errors->has('wife_passport_no'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('wife_passport_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-8 col-md-offset-2">
                                <div class="form-group {{$errors->has('pom') ? ' has-error' : ''}}">
                                    <label class="control-label" for="pom"><span class="text-danger">*</span> Tag Eheschließung /Place of the marriage</label>
                                    <input type="text" class="form-control" name="pom" value="{{old('pom')}}">
                                    @if ($errors->has('pom'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('pom') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('dom') ? ' has-error' : ''}}">
                                    <label class="control-label" for="dom"><span class="text-danger">*</span> der Eheschließung/Date the marriage</label>
                                    <input type="date" class="form-control" name="dom" value="{{old('dom')}}">
                                    @if ($errors->has('dom'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('dom') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection