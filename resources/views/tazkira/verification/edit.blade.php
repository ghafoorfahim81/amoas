@extends('layouts.customer', ['title' => __('backend.bookings')])

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/select2-bootstrap.min.css') }}">
@endsection

@section('content')

<div class="page-title">
    <h3>{{ __('backend.tazkira') }}</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
            <li class="active">{{ __('backend.tazkira') }}</li>
            <li><a href="{{ route('verification.index') }}">{{ __('backend.verification') }}</a></li>
        </ol>
    </div>
</div>

<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            @include('alerts.bookings')

        <form method="post" enctype="multipart/form-data" action="{{route('verification.update', [$verification->id])}}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    {{-- <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#business" role="tab" data-toggle="tab"><i class="icon-briefcase"></i>&nbsp;&nbsp;{{ __('backend.business') }}</a>
                    </li>
                    </ul> --}}
                    <ul class="nav nav-pills" id="v-pills-tab" role="tablist">
                        <li role="presentation" class="active"><a class="nav-link active" id="v-pills-persoanl-information-tab" data-toggle="pill"
                            href="#v-pills-persoanl-information" role="tab" aria-controls="v-pills-persoanl-information"
                            aria-selected="true">Personal Information</a></li>
                        <li role="presentation"><a class="nav-link" id="v-pills-services-tab" data-toggle="pill"
                            href="#v-pills-services" role="tab" aria-controls="v-pills-services"
                            aria-selected="false">Select Service</a></li>
                        <li role="presentation"><a class="nav-link" id="v-pills-address-tab" data-toggle="pill" href="#v-pills-address"
                            role="tab" aria-controls="v-pills-address" aria-selected="false">Addresses</a></li>
                        <li role="presentation"><a class="nav-link" id="v-pills-detailed-information-tab" data-toggle="pill"
                            href="#v-pills-detailed-information" role="tab" aria-controls="v-pills-detailed-information"
                            aria-selected="false">Detailed Information</a></li>
                        <li role="presentation"><a class="nav-link" id="v-pills-delegate-tab" data-toggle="pill"
                            href="#v-pills-delegate" role="tab" aria-controls="v-pills-delegate"
                            aria-selected="false">Delegate Information</a></li>
                        <li role="presentation"><a class="nav-link" id="v-pills-sibling-information-tab" data-toggle="pill"
                            href="#v-pills-sibling-information" role="tab" aria-controls="v-pills-sibling-information"
                            aria-selected="false">Sibling Information</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active fade in" id="v-pills-persoanl-information">
                            <div class="row clearfix">
                                    <legend>Persoanl Information of Applicant</legend>
                                {{-- <h6 class="text-danger">All field should fill in persian.</h6> --}}
                                    <br>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Name</label>
                                        <input name="name" value="{{ $verification->name }}" type="text"
                                            class="form-control personal-information form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Last Name</label>
                                        <input name="last_name" required value="{{ $verification->last_name }}" type="text"
                                            class="form-control personal-information form-control-lg {{ $errors->has('last_name') ? 'is-invalid' : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Father Name</label>
                                        <input name="father_name" required value="{{ $verification->father_name }}" type="text"
                                            class="form-control personal-information form-control-lg {{ $errors->has('father_name') ? 'is-invalid' : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Grand Father
                                            Name</label>
                                        <input name="grand_father_name" required value="{{ $verification->grand_father_name }}"
                                            type="text"
                                            class="form-control personal-information form-control-lg {{ $errors->has('grand_father_name') ? 'is-invalid' : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Occupation</label>
                                        <input name="occupation" required value="{{ $verification->occupation }}" type="text"
                                            class="form-control personal-information form-control-lg {{ $errors->has('occupation') ? 'is-invalid' : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Birth Place</label>
                                        <input name="birth_place" required value="{{ $verification->birth_place }}" type="text"
                                            class="form-control personal-information form-control-lg {{ $errors->has('birth_place') ? 'is-invalid' : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Marital Status</label>
                                        {{-- <input name="marital_status" reuqired value="{{ $verification->marital_status }}"
                                        type="text" class="form-control personal-information form-control-lg"> --}}
                                        <select name="marital_status"
                                            class="form-control personal-information {{ $errors->has('marital_status') ? 'is-invalid' : '' }}">
                                            <option value="single">Single</option>
                                            <option value="married" selected>Married</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Living Duration in
                                            abroad</label>
                                        <div class="input-group">
                                            <input name="living_duration" required value="{{ $verification->living_duration }}"
                                                type="text"
                                                class="form-control personal-information form-control-lg {{ $errors->has('living_duration') ? 'is-invalid' : '' }}">
                                            <span class="input-group-addon" style="width:18%; padding:0; border:0;">
                                                <select name="living_duration_unit"
                                                    class="form-control personal-information">
                                                    <option value="months">Months</option>
                                                    <option value="years" selected>Years</option>
                                                </select>
                                            </span>
                                        </div>
                                        {{-- <input name="living_duration" value="{{ $verification->living_duration }}"
                                        type="text"
                                        class="form-control form-control-lg"> --}}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Last return date to
                                            Afghanistan <small> like 2012</small></label>
                                        <input name="last_trip" value="{{ $verification->last_trip }}" type="text" required
                                            class="form-control personal-information form-control-lg {{ $errors->has('last_trip') ? 'is-invalid' : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Contact No. in
                                            abroad</label>
                                        <input name="contact_no" value="{{ $verification->contact_no }}" type="text"
                                            class="form-control personal-information form-control-lg {{ $errors->has('contact_no') ? 'is-invalid' : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Email Address</label>
                                        <input name="email" value="{{ $verification->email }}" required type="email"
                                            class="form-control personal-information form-control-lg {{ $errors->has('email') ? 'is-invalid' : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <i class="fa fa-asterisk text-danger"></i> <label for="">Applicant photo
                                            <small>3x4 cm</small></label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input personal-information {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                                                name="photo">
                                            <label class="custom-file-label" for="validatedCustomFile">Choose
                                                image...</label>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="v-pills-services" role="tabpanel"
                            aria-labelledby="v-pills-services-tab">
                            <div class="row">
                                <legend>Which service you want?</legend>
                                <br>
                                <div class="form-group col-md-12">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Available Services</label>
                                    <select class="form-control simple-select2 {{ $errors->has('service_id') ? 'is-invalid' : '' }}" name="service_id" style="width:100%">
                                        @foreach (\App\Models\Verification\Service::all() as $service)
                                        <option value="{{$service->id}}" {{ $service->id == $verification->service_id ? 'selected' : null }}> 
                                        {{app()->isLocale('dr') || app()->isLocale('ps') ? $service->label_dr : $service->label_en}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">In case of new absence Tazkira, please select one below option.</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="new_absence_tazkira_case" value="oldness" {{ $verification->new_absence_tazkira_case == 'oldness' ? 'selected' : null }}>
                                        <label class="form-check-label" for="exampleRadios1">
                                          Effete, attrited or oldness
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="new_absence_tazkira_case" value="burned" {{ $verification->new_absence_tazkira_case == 'burned' ? 'selected' : null }}>
                                        <label class="form-check-label" for="exampleRadios2">
                                          Has been burned
                                        </label>
                                      </div>
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
                                    <select class="form-control {{ $errors->has('original_village') ? 'is-invalid' : '' }}" id="village" name="original_village" style="width:100%">
                                    </select>
                                    {{-- <input name="original_village" value="{{ old('original_village') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('original_village') ? 'is-invalid' : '' }}"> --}}
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Original District</label>
                                    <select class="form-control {{ $errors->has('original_district') ? 'is-invalid' : '' }}" id="district" name="original_district" style="width:100%">
                                    </select>
                                    {{-- <input name="original_district" value="{{ old('original_district') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('original_district') ? 'is-invalid' : '' }}"> --}}
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Original Province</label>
                                    <select class="form-control simple-select2 {{ $errors->has('original_province') ? 'is-invalid' : '' }}" name="original_province" style="width:100%">
                                        @foreach (\DB::table('provinces')->get() as $province)
                                        <option value="{{$province->id}}" {{ $province->id == $verification->original_province ? 'selected' : null }}> 
                                            {{ ucfirst($province->label_en) }} ({{$province->label_dr}})
                                        </option>
                                        @endforeach
                                    </select>
                                    {{-- <input name="original_province" value="{{ old('original_province') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('original_province') ? 'is-invalid' : '' }}"> --}}
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Current City</label>
                                    <input name="current_city" value="{{ $verification->current_city }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('current_city') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Zip Code</label>
                                    <input name="zip_code" value="{{ $verification->zip_code }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('zip_code') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Current Country</label>
                                    <select class="form-control simple-select2 {{ $errors->has('current_country') ? 'is-invalid' : '' }}" name="current_country" style="width:100%">
                                        @foreach (\DB::table('countries')->get() as $country)
                                        <option value="{{$country->id}}" {{ $country->id == $verification->current_country ? 'selected' : null }}> 
                                            {{ ucfirst($country->name_en) }} ({{$country->name_dr}})
                                        </option>
                                        @endforeach
                                    </select>
                                    {{-- <input name="current_country" value="{{ old('current_country') }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('current_country') ? 'is-invalid' : '' }}"> --}}
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
                                    <input name="height" value="{{ $verification->height }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('height') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Eyes Color</label>
                                    <input name="eyes" value="{{ $verification->eyes }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('eyes') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Skin Color</label>
                                    <input name="skin" value="{{ $verification->skin }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('skin') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Hair Color</label>
                                    <input name="hair" value="{{ $verification->hair }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('hair') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6 col-lg-4">
                                    <label for="">Other Information</label>
                                    <input name="other" value="{{ $verification->other }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('other') ? 'is-invalid' : '' }}">
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
                                    <input name="d_name" value="{{ $verification->d_name }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('d_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Delegate Last Name</label>
                                    <input name="d_last_name" required value="{{ $verification->d_last_name }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('d_last_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Delegate Father Name</label>
                                    <input name="d_father_name" required value="{{ $verification->d_father_name }}"
                                        type="text" class="form-control personal-information form-control-lg">
                                </div>
                                <div class="form-group col-md-4">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Delegate Contact No. 1</label>
                                    <input name="d_contact" required value="{{ $verification->d_contact }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('d_contact') ? 'is-invalid' : '' }}">
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
                                    <input name="sibling_name" value="{{ $verification->sibling_name }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('sibling_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Siblings Last Name</label>
                                    <input name="sibling_last_name" required value="{{ $verification->sibling_last_name }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('sibling_last_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Siblings Father Name</label>
                                    <input name="sibling_father_name" required value="{{ $verification->sibling_father_name }}"
                                        type="text" class="form-control personal-information form-control-lg {{ $errors->has('sibling_father_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Siblings Grand Father Name</label>
                                    <input name="sibling_grand_father_name" required
                                        value="{{ $verification->sibling_grand_father_name }}" type="text"
                                        class="form-control personal-information form-control-lg {{ $errors->has('sibling_grand_father_name') ? 'is-invalid' : '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <i class="fa fa-asterisk text-danger"></i> <label for="">Sibling relation with applicant</label>
                                    <select class="form-control simple-select2 {{ $errors->has('sibling_id') ? 'is-invalid' : '' }}" name="sibling_id" style="width:100%">
                                        @foreach (\App\Models\Verification\Sibling::all() as $sibling)
                                        <option value="{{$sibling->id}}" {{ $sibling->id == $verification->sibling_id ? 'selected' : null }}> 
                                            {{$sibling->code}} ({{$sibling->label_en}})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-md-12"><i class="fa fa-asterisk text-danger"></i> Siblings Tazkira Details </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('page_no') ? 'is-invalid' : '' }}" name="page_no"
                                        value="{{ $verification->page_no }}"
                                            placeholder="Page No.">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('version_no') ? 'is-invalid' : '' }}" name="version_no"
                                        value="{{ $verification->version_no }}"
                                            placeholder="Version No.">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('note_no') ? 'is-invalid' : '' }}" name="note_no"
                                        value="{{ $verification->note_no }}"
                                            placeholder="Note No.">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 col-md-12"><i class="fa fa-asterisk text-danger"></i> Siblings Tazkira Issue Date</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year"
                                        value="{{ $verification->year }}" placeholder="Year">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('month') ? 'is-invalid' : '' }}" name="month"
                                        value="{{ $verification->month }}" placeholder="Month">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control {{ $errors->has('day') ? 'is-invalid' : '' }}" name="day"
                                        value="{{ $verification->day }}" placeholder="Day">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <button class="btn btn-primary btn-lg" type="submit"><i
                        class="fa fa-save"></i>&nbsp;&nbsp;{{ __('tazkira.update') }}</button>
                <br><br>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>

<script type="text/javascript">

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

        $('#village').append("{!! '<option value=\"' . $verification->village->id . '\" selected>' .$verification->village->name. '</option>' !!}").change();

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

        $('#district').append("{!! '<option value=\"' . $verification->district->id . '\" selected>' .$verification->district->name. '</option>' !!}").change();

    });
</script>
@endsection