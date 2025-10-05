@extends('layouts.app', ['title' => __('app.welcome_title')])

@section('pure-style')
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/select2-bootstrap.min.css') }}">
@endsection
@section('styles')

<style>
    .visa-nav-link.active {
        color: #fff !important;
        background-color: #007bff;
    }

    .visa-nav-link {
        color: #000000 !important;
    }

    .form-control {
        padding: 0.3em 0.5em;
        font-size: 15px;
    }

    i.fa-asterisk {
        font-size: 0.7em !important;
    }
</style>

@endsection

@section('content')

<div class="jumbotron promo">
    <div class="container">
        <h1 class="text-center promo-heading">{{ __('app.welcome_title') }}</h1>
        @if(session()->has('department'))
            @php
                $department = session('department');
            @endphp
            <h3 class="text-center promo-heading">{{ $department->name_en }}</h3>
        @endif
        <p class="promo-desc text-center">{{ __('app.welcome_subtitle') }}</p>
    </div>
</div>

<form method="post" id="save-form" action="{{ route('visa-form.fill.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">{{ __('app.afgOnlineVisaForm') }}</h3>
                    <hr>
                    @if (count($errors) > 0)
                    <h4>{{ __('app.validation_t_message') }}</h4>
                    <div class="error">
                        <ol>
                            @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ol>
                    </div>
                    @endif
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <!-- Tab panes -->
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link visa-nav-link active" id="v-pills-persoanl-information-tab" data-toggle="pill"
                            href="#v-pills-persoanl-information" role="tab" aria-controls="v-pills-persoanl-information"
                            aria-selected="true"> {{ __('app.visa-persoanlInfo') }}</a>
                        <a class="nav-link visa-nav-link disabled" id="v-pills-services-tab" data-toggle="pill"
                            href="#v-pills-services" role="tab" aria-controls="v-pills-services"
                            aria-selected="false"> {{ __('app.visa-contactDetails') }}</a>
                        <a class="nav-link visa-nav-link disabled" id="v-pills-address-tab" data-toggle="pill" href="#v-pills-address"
                        role="tab" aria-controls="v-pills-address" aria-selected="false"> {{ __('app.visa-employmentDetail') }}</a>
                        <a class="nav-link visa-nav-link disabled" id="v-pills-delegate-tab" data-toggle="pill"
                            href="#v-pills-delegate" role="tab" aria-controls="v-pills-delegate"
                            aria-selected="false"> {{ __('app.visa-passportDetail') }}</a>
                        <a class="nav-link visa-nav-link disabled" id="v-pills-detailed-information-tab" data-toggle="pill"
                            href="#v-pills-detailed-information" role="tab" aria-controls="v-pills-detailed-information"
                            aria-selected="false"> {{ __('app.visa-detail') }}</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- Nav tabs -->
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-persoanl-information" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">
                            <legend>{{ __('app.visa-persoanlInfo') }}</legend>
                            <div class="row">
                                <br>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-persoanlInfoTile') }}</label>
                                    <select name="title" required
                                        class="form-control personal-information {{ $errors->has('title') ? 'is-invalid' : '' }}">
                                        <option></option>
                                        <option value="mr." {{ 'mr.' == old('title') ? 'selected' : null }}>Mr.</option>
                                        <option value="mrs." {{ 'mrs.' == old('title') ? 'selected' : null }}>Mrs.</option>
                                        <option value="ms." {{ 'ms.' == old('title') ? 'selected' : null }}>Ms.</option>
                                        <option value="eng." {{ 'eng.' == old('title') ? 'selected' : null }}>Eng.</option>
                                        <option value="dr." {{ 'dr.' == old('title') ? 'selected' : null }}>Dr.</option>
                                        <option value="pro." {{ 'pro.' == old('title') ? 'selected' : null }}>Pro.</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-persoanlInfoFamilyName') }} <small>{{ __('app.visa-showAsPassport') }}</small></label>
                                    <input name="family_name" required value="{{ old('family_name') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('family_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-persoanlInfoGivenName') }} <small>{{ __('app.visa-showAsPassport') }}</small></label>
                                    <input name="given_name" required value="{{ old('given_name') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('given_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-persoanlInfoFatherName') }} </label>
                                    <input name="father_name" required value="{{ old('father_name') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('father_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-persoanlInfoMaritalStatus') }} </label>
                                    <select name="marital_status" required
                                        class="form-control personal-information {{ $errors->has('marital_status') ? 'is-invalid' : '' }}">
                                        <option></option>
                                        <option value="single" {{ 'single' == old('marital_status') ? 'selected' : null }}>{{ __('app.Single') }}</option>
                                        <option value="engaged" {{ 'engaged' == old('marital_status') ? 'selected' : null }}>{{ __('app.Engaged') }}</option>
                                        <option value="married" {{ 'married' == old('marital_status') ? 'selected' : null }}>{{ __('app.Married') }}</option>
                                        <option value="separated" {{ 'separated' == old('marital_status') ? 'selected' : null }}>{{ __('app.Separated') }}</option>
                                        <option value="divorced" {{ 'divorced' == old('marital_status') ? 'selected' : null }}>{{ __('app.Divorced') }}</option>
                                        <option value="widow/widower" {{ 'widow/widower' == old('marital_status') ? 'selected' : null }}>{{ __('app.Widow/Widower') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-persoanlInfoDoB') }}</label>
                                    <input name="dob" value="{{ old('dob') }}" type="date" required
                                        class="form-control personal-information {{ $errors->has('dob') ? 'is-invalid' : '' }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-persoanlInfoCurrentCountry') }}</label>
                                    <select required
                                        class="form-control simple-select2 {{ $errors->has('residence_country') ? 'is-invalid' : '' }}"
                                        name="residence_country">
                                        <option></option>
                                        @foreach (\DB::table('countries')->get() as $country)
                                        <option value="{{$country->id}}"
                                            {{ $country->id == old('residence_country') ? 'selected' : null }}>
                                            {{ ucfirst($country->name_en) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group row col-6">
                                    <label class="col-12"><i class="fa fa-asterisk text-danger "></i> {{ __('app.visa-persoanlInfoGender') }}</label>
                                    <div class="col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="gender" value="male" checked
                                                class="custom-control-input" id="customControlAutosizingMale">
                                            <label class="custom-control-label"
                                                for="customControlAutosizingMale">{{ __('app.Male') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="gender" value="female"
                                                class="custom-control-input" id="customControlAutosizingFemale">
                                            <label class="custom-control-label"
                                                for="customControlAutosizingFemale">{{ __('app.Female') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-persoanlInfoNationality') }}</label>
                                    <input name="nationality" required value="{{ old('nationality') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('nationality') ? 'is-invalid' : '' }}">
                                </div>

                                <div class="form-group row col-6">
                                    <label class="col-12"><i class="fa fa-asterisk text-danger "></i> @lang('app.visa-persoanlInfoUnder18')</label>
                                    <div class="col-sm-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="under_18" value="1" class="custom-control-input"
                                                id="customControlAutosizingYes">
                                            <label class="custom-control-label"
                                                for="customControlAutosizingYes">{{ __('app.visa-persoanlInfoYes') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="under_18" value="0" checked
                                                class="custom-control-input" id="customControlAutosizingNo">
                                            <label class="custom-control-label"
                                                for="customControlAutosizingNo">{{ __('app.visa-persoanlInfoNo') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-persoanlInfoCountryBirth') }}</label>
                                    <select required
                                        class="form-control simple-select2 {{ $errors->has('birth_country') ? 'is-invalid' : '' }}"
                                        name="birth_country">
                                        <option></option>
                                        @foreach (\DB::table('countries')->get() as $country)
                                        <option value="{{$country->id}}"
                                            {{ $country->id == old('birth_country') ? 'selected' : null }}>
                                            {{ ucfirst($country->name_en) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">{{ __('app.visa-persoanlInfoOtherNationality') }}</label>
                                    <input name="other_nationality" value="{{ old('other_nationality') }}"
                                        type="text"
                                        class="form-control personal-information {{ $errors->has('other_nationality') ? 'is-invalid' : '' }}">
                                </div>

                                <div class="form-group offset-md-10 col-md-2">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-persoanl-information', 'v-pills-services-tab', event)">
                                        <i class="fa fa-arrow-right"></i> {{ __('app.visa-next') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-services" role="tabpanel"
                            aria-labelledby="v-pills-services-tab">
                            <legend>{{ __('app.visa-contactDetails') }}</legend>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-contactDetailsCurrentAddress') }}</label>
                                    <input name="address" required value="{{ old('address') }}" type="text"
                                        class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">@lang('app.visa-contactDetailsEmail')</label>
                                    <input name="email" required value="{{ old('email') }}" type="email"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">@lang('app.visa-contactDetailsMobile')</label>
                                    <input name="mobile" required value="{{ old('mobile') }}" type="text"
                                        class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}">
                                </div>

                                <div class="form-group offset-md-10 col-md-2">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-services', 'v-pills-address-tab', event)">
                                        <i class="fa fa-arrow-right"></i> {{ __('app.visa-next') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-address" role="tabpanel"
                            aria-labelledby="v-pills-messages-tab">
                            <legend>{{ __('app.visa-contactDetails') }}</legend>
                            <br>
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-contactDetailsCurrentOccupation') }}</label>
                                    <input name="occupation" required value="{{ old('occupation') }}" type="text" class="form-control personal-information
                                {{ $errors->has('occupation') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('app.visa-contactDetailsEmployer') }}</label>
                                    <input name="employer_name" value="{{ old('employer_name') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('employer_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('app.visa-contactDetailsEmployerAddr') }}</label>
                                    <input name="employer_address" value="{{ old('employer_address') }}"
                                        type="text"
                                        class="form-control personal-information {{ $errors->has('employer_address') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('app.visa-contactDetailsPreEmployer') }}</label>
                                    <input name="pre_employer_name" value="{{ old('pre_employer_name') }}"
                                        type="text"
                                        class="form-control personal-information {{ $errors->has('pre_employer_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('app.visa-contactDetailsPreEmployerAddr') }}</label>
                                    <input name="pre_employer_address" value="{{ old('pre_employer_address') }}"
                                        type="text"
                                        class="form-control personal-information {{ $errors->has('pre_employer_address') ? 'is-invalid' : '' }}">
                                </div>

                                <div class="form-group offset-md-10 col-md-2">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-address', 'v-pills-delegate-tab', event)">
                                        <i class="fa fa-arrow-right"></i> {{ __('app.visa-next') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="v-pills-delegate" role="tabpanel"
                            aria-labelledby="v-pills-delegate-tab">
                            <legend>{{ __('app.visa-passportDetail') }}</legend>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-passportDetailPassportType') }}</label>
                                    <input name="passport_type" required value="{{ old('passport_type') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('passport_type') ? 'is-invalid' : '' }}">
                                    
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-passportDetailPassportNumber') }}</label>
                                    <input name="passport_no" required value="{{ old('passport_no') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('passport_no') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-passportDetailPoIssue') }}</label>
                                    <input name="issue_place" required value="{{ old('issue_place') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('issue_place') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-passportDetailDoIssue') }}</label>
                                    <input name="issue_date" required value="{{ old('issue_date') }}" type="date"
                                        class="form-control personal-information {{ $errors->has('issue_date') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-passportDetailDoExpire') }}</label>
                                    <input name="expire_date" required value="{{ old('expire_date') }}" type="date"
                                        class="form-control personal-information {{ $errors->has('expire_date') ? 'is-invalid' : '' }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">@lang('app.visa-passportDetailPhoto')</label>
                                    <input type="file" required name="photo" accept="image/*" class="form-control form-control-file {{ $errors->has('photo') ? 'is-invalid' : '' }}">
                                </div>

                                <div class="form-group offset-md-10 col-md-2">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-delegate', 'v-pills-detailed-information-tab', event)">
                                        <i class="fa fa-arrow-right"></i> {{ __('app.visa-next') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-detailed-information" role="tabpanel"
                            aria-labelledby="v-pills-settings-tab">
                            <legend>{{ __('app.visa-detail') }}</legend>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">@lang('app.visa-detailSelectMission')</label>
                                    <select
                                        class="form-control simple-select2 {{ $errors->has('department_id') ? 'is-invalid' : '' }}"
                                        name="department_id">
                                        {{-- @foreach (\App\Department::whereIn('type', ['embassy', 'consulate'])->get() as $department)
                                        <option value="{{$department->id}}"
                                            {{ $department->id == old('department_id') ? 'selected' : null }}>
                                            {{ ucfirst($department->name_en) }}
                                        </option>
                                        @endforeach --}}

                                        @if(session()->has('department'))
                                            @php
                                                $department = session('department');
                                            @endphp
                                            <option value="{{$department->id}}" selected>
                                                {{ Lang::has('app.' . $department->name_en, app()->getLocale()) ? __('app.' . $department->name_en) : ucfirst($department->name_en) }}
                                            </option>
                                        @else
                                            @foreach (\App\Department::whereIn('type', ['embassy', 'consulate'])->where('status', 1)->get() as $department)
                                                <option value="{{$department->id}}"
                                                    {{ $department->id == old('department_id') ? 'selected' : null }}>
                                                    {{ Lang::has('app.' . $department->name_en, app()->getLocale()) ? __('app.' . $department->name_en) : ucfirst($department->name_en) }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-detailVisaType') }}</label>
                                    <select
                                        class="form-control simple-select2 {{ $errors->has('visa_type') ? 'is-invalid' : '' }}"
                                        name="visa_type">
                                        @foreach (\DB::table('visa_types')->get() as $country)
                                        <option value="{{$country->id}}"
                                            {{ $country->id == old('visa_type') ? 'selected' : null }}>
                                            {{ Lang::has('app.' . $country->name, app()->getLocale()) ? __('app.' . $country->name) : ucfirst($country->name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">@lang('app.visa-detailPurpose')</label>
                                    <input name="purpose" required value="{{ old('purpose') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('purpose') ? 'is-invalid' : '' }}">
                                    {{-- <select multiple required class="form-control {{ $errors->has('purpose[]') ? 'is-invalid' : '' }}"
                                        id="village" name="purpose[]">
                                    </select> --}}
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-detailDoEntry') }}</label>
                                    <input name="entry_date" required value="{{ old('entry_date') }}" type="date"
                                        class="form-control personal-information {{ $errors->has('entry_date') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">@lang('app.visa-detailDuration')</label>
                                    <input name="intend_duration" required value="{{ old('intend_duration') }}"
                                        type="number"
                                        class="form-control personal-information {{ $errors->has('intend_duration') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-detailPoEntry') }}</label>
                                    <input name="entry_point" required value="{{ old('entry_point') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('entry_point') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('app.visa-detailNoChildren') }}</label>
                                    <input name="children_no" value="{{ old('children_no') }}" type="number"
                                        class="form-control personal-information {{ $errors->has('children_no') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-detailPlacesToVisit') }}</label>
                                    <input name="visit_places" required value="{{ old('visit_places') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('visit_places') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">{{ __('app.visa-detailAfgAddr') }}</label>
                                    <input name="af_address" required value="{{ old('af_address') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('af_address') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">@lang('app.visa-detailVisitedBefore')</label>
                                    <input name="visited_before" value="{{ old('visited_before') }}"
                                        type="text"
                                        class="form-control personal-information {{ $errors->has('visited_before') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">@lang('app.visa-detailAppliedVisa')</label>
                                    <input name="applied_visa" value="{{ old('applied_visa') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('applied_visa') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">@lang('app.visa-detailCrime')</label>
                                    <input name="applied_visa" value="{{ old('applied_visa') }}" type="text"
                                        class="form-control personal-information {{ $errors->has('applied_visa') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" required class="custom-control-input" id="customControlAutosizing">
                                        <label class="custom-control-label" for="customControlAutosizing">
                                            @lang('app.visa-detailSign')
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group offset-md-9 col-md-3">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-detailed-information', '', event)">
                                        <i class="fa fa-arrow-right"></i> {{ __('app.visa-detailSubmit') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <br>

            <div id="slots_holder"></div>

            <div class="row col-md-12">
                <div class="alert alert-danger col-md-12 d-none" id="slot_error" style="margin-bottom: 50px;">
                    {{ __('app.time_slot_error') }}
                </div>
            </div>

        </div>
    </div>

    <footer class="footer d-none d-sm-none d-md-block d-lg-block d-xl-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <span class="text-copyrights">
                        {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }}
                        {{ config('settings.business_name', 'Bookify') }}.
                    </span>
                </div>
            </div>
        </div>
    </footer>

    {{--FOOTER FOR PHONES--}}

</form>

<!-- Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{asset('images/loader.gif')}}" alt="" srcset="">
                <h2>{{ __('app.loadingPlzWait') }}</h2>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>

<script>
    $(function () {
        $('.simple-select2').select2({
            'theme': 'bootstrap'
        });


        // $('#village').select2({
        //     'theme': 'bootstrap',
        //     minimumInputLength: 2,
        //     tags: true,
        //     multiple: true,
        //     ajax: {
        //         url: "{!! route('ajaxRequest', ['t'=>'village','f'=>['id','label_dr', 'label_en'],'s'=>['name', 'label_dr', 'label_en']]) !!}",
        //         dataType: 'json',
        //         type: "get",
        //         quietMillis: 5,
        //         data: function (term) {
        //             return term;
        //         },
        //         processResults: function (data) {
        //             return {
        //                 results: $.map(data, function (item) {
        //                     return {
        //                         text: item.label_en + ' (' + item.label_dr + ')',
        //                         slug: item.name,
        //                         id: item.id
        //                     }
        //                 })
        //             };
        //         }
        //     }
        // });

    //     $('#district').select2({
    //         placeholder: 'district here...',
    //         'theme': 'bootstrap',
    //         minimumInputLength: 2,
    //         tags: true,
    //         ajax: {
    //             url: "{!! route('ajaxRequest', ['t'=>'districts','f'=>['id','label_dr', 'label_en'],'s'=>['name', 'label_dr', 'label_en']]) !!}",
    //             dataType: 'json',
    //             type: "get",
    //             quietMillis: 5,
    //             data: function (term) {
    //                 return term;
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             text: item.label_en + ' (' + item.label_dr + ')',
    //                             slug: item.name,
    //                             id: item.id
    //                         }
    //                     })
    //                 };
    //             }
    //         }
    //     });

    });

    function validate(param, nextTab, e) {
        e.preventDefault();

        if(!validateSection(param)) return false;
        if (nextTab === undefined || nextTab == null || nextTab.length <= 0){
            $('#save-form').submit();
            $('#loadingModal').modal('show')
        } 
        
        $('#' + param + '-tab').removeClass("active show");
        var next = $('#' + nextTab);
        next.addClass("active show");
        next.removeClass("disabled");

        var activedTab = $('.tab-content > .active');
        activedTab.removeClass("active show");
        activedTab.next().addClass("active show");
    }

    function validateSection(param) {
        // console.log(param);
        // var sectionForms = $('#' + param + ' input, select');
        var sectionForms = $('#' + param).find("select, textarea, input");
        // console.log(sectionForms);
        var results = []
        for (var i = 0; i < sectionForms.length; i++) {
            // console.log(i + ' -> ' + doValidation($(sectionForms[i])));
            results.push(doValidation($(sectionForms[i])));
        }

        return !results.includes(false);
    }

    function doValidation(el){

        var type = el.attr('type');
        if(type == 'text')
            return validateRequired(el);
        // if(type == 'radio')
        //     return el;
        if(type == 'checkbox')
            return validateCheckbox(el);
        if(type == 'file')
            return validateFile(el);
        if(type == 'date')
            return validateRequired(el);
        if(type == 'number')
            return validateRequired(el);
        if(type == 'email')
            return validateRequired(el);
        
        if(el.is('select'))
            return validateRequiredSelect(el);

        return true;
        
    }

    function validateRequired(el){
        var required = el.attr("required");
        if (required != null) {
            
            if($.trim(el.val()) <= 0){
                el.addClass('is-invalid');
                el.removeClass('is-valid');
                return false;
            }
            el.removeClass('is-invalid');
            el.addClass('is-valid');
            return true;
        }
        return true;
    }

    function validateCheckbox(el){
        var required = el.attr("required");
        if (required != null) {
            
            if(!el.is(':checked')){
                el.addClass('is-invalid');
                el.removeClass('is-valid');
                return false;
            }
            el.removeClass('is-invalid');
            el.addClass('is-valid');
            return true;
        }
        return true;
    }

    function validateFile(el){
        var required = el.attr("required");
        if (required != null) {
            
            if(el.get(0).files.length === 0){
                el.addClass('is-invalid');
                el.removeClass('is-valid');
                return false;
            }
            el.removeClass('is-invalid');
            el.addClass('is-valid');
            return true;
        }
        return true;
    }

    function validateRequiredSelect(el){
        var required = el.attr("required");
        if (required != null) {
            var span = el.parent().find('.select2-selection');
            
            if($.trim(el.val()) <= 0){
                console.log(el.parent());
                // console.log(el);
                span.css('border-color','red');
                span.removeClass('is-valid');
                el.removeClass('is-valid');
                el.addClass('is-invalid');
                return false;
            }
            span.css('border-color','green');
            el.removeClass('is-invalid');
            el.addClass('is-valid');
            return true;
        }
        return true;
    }

</script>
@endsection