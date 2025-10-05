@extends('layouts.admin', ['title' => 'Birth Certificates'])

@section('content')

    <div class="page-title">
        <h3>Birth Certificates</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('birth.index') }}">Birth Certificates</a></li>
                <li><a href="{{ route('birth.show', $birth->id) }}">View {{ $birth->serial_no }}</a></li>
                <li class="active">Edit</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">Edit Birth Certificates</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('birth.update', $birth->id)}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            @method('PUT')

                            <div class="col-md-6 form-group {{$errors->has('family_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="family_name"><span class="text-danger">*</span> Name/ Family Name</label>
                                <input type="text" class="form-control" name="family_name" value="{{ $birth->family_name }}">
                                @if ($errors->has('family_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('family_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group {{$errors->has('given_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="given_name"><span class="text-danger">*</span> Vorname/Given Name</label>
                                <input type="text" class="form-control" name="given_name" value="{{ $birth->given_name }}">
                                @if ($errors->has('given_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('given_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group {{$errors->has('previous_name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="previous_name">Name vor der Eheschließung /Name before the marriage</label>
                                    <input type="text" class="form-control" name="previous_name" value="{{ $birth->previous_name }}">
                                    @if ($errors->has('previous_name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('previous_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            <div class="col-md-6 form-group {{$errors->has('sex') ? ' has-error' : ''}}">
                                <label class="control-label" for="name"><span class="text-danger">*</span> Geschlecht /Sex</label>
                                <select class="form-control" name="sex">
                                    <option value="">{{ __('backend.select_one') }}</option>
                                    <option value="M" {{ 'M' == $birth->sex ? 'selected' : null }}>Male</option>
                                    <option value="F" {{ 'F' == $birth->sex ? 'selected' : null }}>Female</option>
                                </select>
                                @if ($errors->has('sex'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('sex') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group {{$errors->has('dob') ? ' has-error' : ''}}">
                                <label class="control-label" for="dob"><span class="text-danger">*</span> Geburtsdatum /Date of Birth</label>
                                <input type="date" class="form-control" name="dob" value="{{ $birth->dob }}">
                                @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group {{$errors->has('pob') ? ' has-error' : ''}}">
                                <label class="control-label" for="pob"><span class="text-danger">*</span> Geburtsort/Place of birth</label>
                                <select class="form-control simple-select2" name="pob">
                                    <option value="">{{ __('backend.select_one') }}</option>
                                    @foreach (\DB::table('provinces')->get() as $province)
                                    <option value="{{$province->label_en}}" {{ $province->label_en ==  $birth->pob  ? 'selected' : null }}> 
                                        {{ $province->label_en }} ({{$province->label_dr}})
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('pob'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('pob') }}</strong>
                                    </span>
                                @endif
                                <input type="text" placeholder="Or born outside of country..." class="form-control" name="pob_outside" value="{{ strpos($birth->pob, '/') ? $birth->pob : null }}">
                                @if ($errors->has('pob_outside'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('pob_outside') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group {{$errors->has('passport_no') ? ' has-error' : ''}}">
                                <label class="control-label" for="passport_no"><span class="text-danger">*</span> Passnummer/Tazkira No/Passport No</label>
                                <input type="text" class="form-control" name="passport_no" value="{{ $birth->passport_no }}">
                                @if ($errors->has('passport_no'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('passport_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group {{$errors->has('father_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="father_name"><span class="text-danger">*</span> Name des Vaters/Fathers Name</label>
                                <input type="text" class="form-control" name="father_name" value="{{ $birth->father_name }}">
                                @if ($errors->has('father_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('father_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group {{$errors->has('mother_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="mother_name"><span class="text-danger">*</span> Name der Mutter/Mothers Name</label>
                                <input type="text" class="form-control" name="mother_name" value="{{ $birth->mother_name }}">
                                @if ($errors->has('mother_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('mother_name') }}</strong>
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