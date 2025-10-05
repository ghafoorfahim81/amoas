@extends('layouts.app', ['title' => __('app.step_two_page_title')])

@section('pure-style')
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/select2-bootstrap.min.css') }}">
@endsection
@section('styles')

<style>
    .nav-link.active {
        color: #fff !important;
        background-color: #007bff;
    }

    .nav-link {
        color: #000000 !important;
    }

    .form-control {
        padding: 0.2em 0.5em;
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
        <h1 class="text-center promo-heading">{{ __('app.step_two_page_title') }}</h1>
        <p class="promo-desc text-center">{{ __('app.step_two_subtitle') }}</p>
    </div>
</div>

<form method="post" id="save-form" action="{{ route('verfiy.tazkira.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Identity Verification Form</h3>
                    <hr>
                    @if (count($errors) > 0)
                    <h4>Invalid information. please fill the following form correctly.</h4>
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
                        <a class="nav-link active" id="v-pills-persoanl-information-tab" data-toggle="pill"
                            href="#v-pills-persoanl-information" role="tab" aria-controls="v-pills-persoanl-information"
                            aria-selected="true">Personal Information</a>
                        <a class="nav-link disabled" id="v-pills-services-tab" data-toggle="pill"
                            href="#v-pills-services" role="tab" aria-controls="v-pills-services"
                            aria-selected="false">Select Service</a>
                        <a class="nav-link disabled" id="v-pills-address-tab" data-toggle="pill" href="#v-pills-address"
                            role="tab" aria-controls="v-pills-address" aria-selected="false">Addresses</a>
                        <a class="nav-link disabled" id="v-pills-detailed-information-tab" data-toggle="pill"
                            href="#v-pills-detailed-information" role="tab" aria-controls="v-pills-detailed-information"
                            aria-selected="false">Detailed Information</a>
                        <a class="nav-link disabled" id="v-pills-delegate-tab" data-toggle="pill"
                            href="#v-pills-delegate" role="tab" aria-controls="v-pills-delegate"
                            aria-selected="false">Delegate Information</a>
                        <a class="nav-link disabled" id="v-pills-sibling-information-tab" data-toggle="pill"
                            href="#v-pills-sibling-information" role="tab" aria-controls="v-pills-sibling-information"
                            aria-selected="false">Sibling Information</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- Nav tabs -->
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-persoanl-information" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">
                            <legend>Personal Information</legend>
                            {{-- <h6 class="text-danger">All field should fill in persian.</h6> --}}
                            <div class="row">
                                <br>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Name</label>
                                    <input name="name" value="{{ old('name') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Last Name</label>
                                    <input name="last_name" required value="{{ old('last_name') }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('last_name') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Father Name</label>
                                    <input name="father_name" required value="{{ old('father_name') }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('father_name') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Grand Father Name</label>
                                    <input name="grand_father_name" required
                                        value="{{ old('grand_father_name') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('grand_father_name') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Occupation</label>
                                    <input name="occupation" required value="{{ old('occupation') }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('occupation') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Birth Place</label>
                                    <input name="birth_place" required value="{{ old('birth_place') }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('birth_place') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Marital Status</label>
                                    {{-- <input name="marital_status" reuqired value="{{ old('marital_status') }}"
                                        type="text" class="form-control personal-information form-control-lg"> --}}
                                    <select name="marital_status" class="form-control personal-information {{ $errors->has('marital_status') ? 'is-invalid' : '' }}">
                                        <option value="single">Single</option>
                                        <option value="married" selected>Married</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Living Duration in abroad</label>
                                    <div class="input-group">
                                        <input name="living_duration" required value="{{ old('living_duration') }}"
                                            type="text" class="form-control personal-information form-control-lg {{ $errors->has('living_duration') ? 'is-invalid' : '' }}">
                                        <div class="input-group-append">
                                            <select name="living_duration_unit" class="form-control personal-information">
                                                <option value="months">Months</option>
                                                <option value="years" selected>Years</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <input name="living_duration" value="{{ old('living_duration') }}" type="text"
                                    class="form-control form-control-lg"> --}}
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Last return date to Afghanistan <small> like 2012</small></label>
                                    <input name="last_trip" value="{{ old('last_trip') }}" type="text" required
                                        class="form-control personal-information form-control-lg {{ $errors->has('last_trip') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Contact No. in abroad</label>
                                    <input name="contact_no" value="{{ old('contact_no') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('contact_no') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Email Address</label>
                                    <input name="email" value="{{ old('email') }}" required type="email"
                                    class="form-control personal-information form-control-lg {{ $errors->has('email') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Applicant photo <small>3x4 cm</small></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input personal-information {{ $errors->has('photo') ? 'is-invalid' : '' }}" name="photo" required>
                                        <label class="custom-file-label" for="validatedCustomFile">Choose image...</label>
                                      </div>
                                </div>
                                
                                <div class="form-group offset-md-10 col-md-2">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-persoanl-information', 'v-pills-services-tab', event)">
                                        <i class="fa fa-arrow-right"></i> NEXT
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-services" role="tabpanel"
                            aria-labelledby="v-pills-services-tab">
                            <div class="row">
                                <legend>Which service you want?</legend>
                                <br>
                                <div class="form-group col-md-12">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Available Services</label>
                                    <select class="form-control simple-select2 {{ $errors->has('service_id') ? 'is-invalid' : '' }}" name="service_id">
                                        @foreach (\App\Models\Verification\Service::all() as $service)
                                        <option value="{{$service->id}}" {{ $service->id == old('service_id') ? 'selected' : null }}> 
                                            {{$service->label_en}} ({{$service->name}})
                                        </option>
                                        @endforeach
                                    </select>
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">In case of new absence Tazkira, please select one below option.</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="new_absence_tazkira_case" value="oldness">
                                        <label class="form-check-label" for="exampleRadios1">
                                          Effete, attrited or oldness
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="new_absence_tazkira_case" value="burned">
                                        <label class="form-check-label" for="exampleRadios2">
                                          Has been burned
                                        </label>
                                      </div>
                                </div>
                                <div class="form-group offset-md-10 col-md-2">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-services', 'v-pills-address-tab', event)">
                                        <i class="fa fa-arrow-right"></i> NEXT
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-address" role="tabpanel"
                            aria-labelledby="v-pills-messages-tab">
                            <div class="row">
                                <legend>Addresses of applicant.</legend>
                                <br>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Original Village</label>
                                    <select class="form-control {{ $errors->has('original_village') ? 'is-invalid' : '' }}" id="village" name="original_village">
                                    </select>
                                    {{-- <input name="original_village" value="{{ old('original_village') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('original_village') ? 'is-invalid' : '' }}"> --}}
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Original District</label>
                                    <select class="form-control {{ $errors->has('original_district') ? 'is-invalid' : '' }}" id="district" name="original_district">
                                    </select>
                                    {{-- <input name="original_district" value="{{ old('original_district') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('original_district') ? 'is-invalid' : '' }}"> --}}
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Original Province</label>
                                    <select class="form-control simple-select2 {{ $errors->has('original_province') ? 'is-invalid' : '' }}" name="original_province">
                                        @foreach (\DB::table('provinces')->get() as $province)
                                        <option value="{{$province->id}}" {{ $province->id == old('original_province') ? 'selected' : null }}> 
                                            {{ ucfirst($province->label_en) }} ({{$province->label_dr}})
                                        </option>
                                        @endforeach
                                    </select>
                                    {{-- <input name="original_province" value="{{ old('original_province') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('original_province') ? 'is-invalid' : '' }}"> --}}
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Current City</label>
                                    <input name="current_city" value="{{ old('current_city') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('current_city') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Zip Code</label>
                                    <input name="zip_code" value="{{ old('zip_code') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('zip_code') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Current Country</label>
                                    <select class="form-control simple-select2 {{ $errors->has('current_country') ? 'is-invalid' : '' }}" name="current_country">
                                        @foreach (\DB::table('countries')->get() as $country)
                                        <option value="{{$country->id}}" {{ $country->id == old('current_country') ? 'selected' : null }}> 
                                            {{ ucfirst($country->name_en) }} ({{$country->name_dr}})
                                        </option>
                                        @endforeach
                                    </select>
                                    {{-- <input name="current_country" value="{{ old('current_country') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('current_country') ? 'is-invalid' : '' }}"> --}}
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group offset-md-10 col-md-2">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-address', 'v-pills-detailed-information-tab', event)">
                                        <i class="fa fa-arrow-right"></i> NEXT
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-detailed-information" role="tabpanel"
                            aria-labelledby="v-pills-settings-tab">
                            <div class="row">
                                <legend>More details of applicant.</legend>
                                <br>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Height <small>in centimeter (cm)</small></label>
                                    <input name="height" value="{{ old('height') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('height') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Eyes Color</label>
                                    <input name="eyes" value="{{ old('eyes') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('eyes') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Skin Color</label>
                                    <input name="skin" value="{{ old('skin') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('skin') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Hair Color</label>
                                    <input name="hair" value="{{ old('hair') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('hair') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <label for="">Other Information</label>
                                    <input name="other" value="{{ old('other') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('other') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group offset-md-10 col-md-2">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-detailed-information', 'v-pills-delegate-tab', event)">
                                        <i class="fa fa-arrow-right"></i> NEXT
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-delegate" role="tabpanel"
                            aria-labelledby="v-pills-delegate-tab">
                            <div class="row">
                                <legend>Applicant delegate in Afghanistan.</legend>
                                <br>
                                <div class="form-group col-md-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Delegate Name</label>
                                    <input name="d_name" value="{{ old('d_name') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('d_name') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Delegate Last Name</label>
                                    <input name="d_last_name" required value="{{ old('d_last_name') }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('d_last_name') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Delegate Father Name</label>
                                    <input name="d_father_name" required value="{{ old('d_father_name') }}"
                                        type="text" class="form-control personal-information form-control-lg">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Delegate Contact No. 1</label>
                                    <input name="d_contact" required value="{{ old('d_contact') }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('d_contact') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group offset-md-10 col-md-2">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-delegate', 'v-pills-sibling-information-tab', event)">
                                        <i class="fa fa-arrow-right"></i> NEXT
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-sibling-information" role="tabpanel"
                            aria-labelledby="v-pills-settings-tab">
                            <div class="row">
                                <legend>Applicant siblings information.</legend>
                                <br>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Siblings Name</label>
                                    <input name="sibling_name" value="{{ old('sibling_name') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('sibling_name') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Siblings Last Name</label>
                                    <input name="sibling_last_name" required value="{{ old('sibling_last_name') }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('sibling_last_name') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Siblings Father Name</label>
                                    <input name="sibling_father_name" required value="{{ old('sibling_father_name') }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('sibling_father_name') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Siblings Grand Father Name</label>
                                    <input name="sibling_grand_father_name" required
                                        value="{{ old('sibling_grand_father_name') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('sibling_grand_father_name') ? 'is-invalid' : '' }}">
                                    <p class="form-text text-danger d-none" id="address_error_holder">
                                        {{ __('app.address_error') }}
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Sibling relation with applicant</label>
                                    <select class="form-control simple-select2 {{ $errors->has('sibling_id') ? 'is-invalid' : '' }}" name="sibling_id">
                                        @foreach (\App\Models\Verification\Sibling::all() as $sibling)
                                        <option value="{{$sibling->id}}" {{ $sibling->id == old('sibling_id') ? 'selected' : null }}> 
                                            {{$sibling->code}} ({{$sibling->label_en}})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group row col-12">
                                    <label class="col-sm-12 col-md-12"><i class="fa fa-asterisk text-danger"></i> Siblings Tazkira Details </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('page_no') ? 'is-invalid' : '' }}" name="page_no"
                                        value="{{ old('page_no') }}"
                                            placeholder="Page No.">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('version_no') ? 'is-invalid' : '' }}" name="version_no"
                                        value="{{ old('version_no') }}"
                                            placeholder="Version No.">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('note_no') ? 'is-invalid' : '' }}" name="note_no"
                                        value="{{ old('note_no') }}"
                                            placeholder="Note No.">
                                    </div>
                                </div>
                                <div class="form-group row col-12">
                                    <label class="col-sm-12 col-md-12"><i class="fa fa-asterisk text-danger"></i> Siblings Tazkira Issue Date</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year"
                                        value="{{ old('year') }}" placeholder="Year">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('month') ? 'is-invalid' : '' }}" name="month"
                                        value="{{ old('month') }}" placeholder="Month">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('day') ? 'is-invalid' : '' }}" name="day"
                                        value="{{ old('day') }}" placeholder="Day">
                                    </div>
                                </div>
                                <div class="form-group offset-md-10 col-md-2">
                                    <button class="btn btn-primary btn-block"
                                        onclick="validate('v-pills-sibling-information', '', event)">
                                        <i class="fa fa-arrow-right"></i> NEXT
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

@endsection

@section('scripts')

<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>

<script>

    $(function() {
        $('.simple-select2').select2({
            'theme': 'bootstrap'
        });
        
        
        $('#village').select2({
            placeholder: 'village here...',
            'theme': 'bootstrap',
            minimumInputLength: 2,
            tags: true,
            ajax: {
                url: "{!! route('ajaxRequest', ['t'=>'village','f'=>['id','label_dr', 'label_en'],'s'=>['name', 'label_dr', 'label_en']]) !!}",
                dataType: 'json',
                type: "get",
                quietMillis: 5,
                data: function (term) {
                    return term;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.label_en + ' (' + item.label_dr + ')',
                                slug: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        $('#district').select2({
            placeholder: 'district here...',
            'theme': 'bootstrap',
            minimumInputLength: 2,
            tags: true,
            ajax: {
                url: "{!! route('ajaxRequest', ['t'=>'districts','f'=>['id','label_dr', 'label_en'],'s'=>['name', 'label_dr', 'label_en']]) !!}",
                dataType: 'json',
                type: "get",
                quietMillis: 5,
                data: function (term) {
                    return term;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.label_en + ' (' + item.label_dr + ')',
                                slug: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

    });

    function validate(param, nextTab, e) {
        e.preventDefault();

        if(nextTab === undefined || nextTab == null || nextTab.length <= 0) $('#save-form').submit();
        $('#' + param + '-tab').removeClass("active show");
        // if(!validateSection(param)) return false;
        var next = $('#' + nextTab);
        next.addClass("active show");
        next.removeClass("disabled");

        var activedTab = $('.tab-content > .active');
        activedTab.removeClass("active show");
        activedTab.next().addClass("active show");
    }

    function validateSection(param)
    {
        console.log(param);
        var sectionForms = $('#' + param + ' input');
        for(i = 0; i < sectionForms.length; i++){
            
            console.log($(sectionForms[i]));
        }
        console.log(sectionForms);
        // console.log(sectionForms.valid());
        return sectionForms.valid();
    }
</script>
@endsection