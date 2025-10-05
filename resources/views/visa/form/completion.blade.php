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
                    <h3 class="text-center">Afghanistan Online Visa Form</h3>
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
            <br><br>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
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
    $(function () {
        $('.simple-select2').select2({
            'theme': 'bootstrap'
        });


        $('#village').select2({
            'theme': 'bootstrap',
            minimumInputLength: 2,
            tags: true,
            multiple: true,
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

        if (nextTab === undefined || nextTab == null || nextTab.length <= 0) $('#save-form').submit();
        $('#' + param + '-tab').removeClass("active show");
        // if(!validateSection(param)) return false;
        var next = $('#' + nextTab);
        next.addClass("active show");
        next.removeClass("disabled");

        var activedTab = $('.tab-content > .active');
        activedTab.removeClass("active show");
        activedTab.next().addClass("active show");
    }

    function validateSection(param) {
        console.log(param);
        var sectionForms = $('#' + param + ' input');
        for (i = 0; i < sectionForms.length; i++) {

            console.log($(sectionForms[i]));
        }
        console.log(sectionForms);
        // console.log(sectionForms.valid());
        return sectionForms.valid();
    }
</script>
@endsection