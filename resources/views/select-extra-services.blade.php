@extends('layouts.app', ['title' => __('app.step_three_title')])

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.welcome_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.welcome_subtitle') }}</p>
        </div>
    </div>

    <form method="post" id="booking_step_2" action="{{ route('postStep3') }}">
        <input type="hidden" name="session_email" value="{{ Auth::user()->email }}">
        {{ csrf_field() }}
        <div class="container">
            <div class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-12" style="height: 30px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0"
                                aria-valuemax="100"><strong>75%</strong></div>
                        </div>
                    </div>
                </div>

                <br>

                @if (count($errors) > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{ __('app.validation_t_message') }}</h4>
                            <div class="error">
                                <ol>
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    @if (session()->has('participant'))
                        <div class="col-md-12">
                            <br>
                            <h5>{{ __('app.participantInfo', ['participant' => session('participant')]) }}</h5>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">{{ __('app.full_name') }}
                                    <small>({{ __('app.required') }})</small></label>
                                <label class="col-3 col-form-label">{{ __('app.id_card') }}
                                    <small>({{ __('app.required') }})</small></label>
                                <label class="col-3 col-form-label">{{ __('app.relationType') }}
                                    <small>({{ __('app.required') }})</small></label>
                                <label class="col-3 col-form-label">{{ __('app.select_service') }}
                                    <small>({{ __('app.required') }})</small></label>
                            </div>
                            @for ($i = 0; $i < session('participant'); $i++)
                                <div class="form-group row">
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            name="participant[{{ $i }}][name]"
                                            value='{{ old("participant[$i][name]") }}'>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            name="participant[{{ $i }}][id_card]"
                                            value='{{ old("participant[$i][id_card]") }}'>
                                    </div>
                                    <div class="col-3">
                                        <select name="participant[{{ $i }}][relation]"
                                            class="form-control select2" placeholder="{{ __('app.required') }} ...">
                                            <option value="">{{ __('app.select_option') }}</option>
                                            <option value="father"
                                                {{ old("participant[$i][relation]") == 'father' ? 'selected' : '' }}>
                                                {{ __('app.father') }}</option>
                                            <option value="mother"
                                                {{ old("participant[$i][relation]") == 'mother' ? 'selected' : '' }}>
                                                {{ __('app.mother') }}</option>
                                            <option value="brother"
                                                {{ old("participant[$i][relation]") == 'brother' ? 'selected' : '' }}>
                                                {{ __('app.brother') }}</option>
                                            <option value="sister"
                                                {{ old("participant[$i][relation]") == 'sister' ? 'selected' : '' }}>
                                                {{ __('app.sister') }}</option>
                                            <option value="son"
                                                {{ old("participant[$i][relation]") == 'son' ? 'selected' : '' }}>
                                                {{ __('app.son') }}</option>
                                            <option value="daughter"
                                                {{ old("participant[$i][relation]") == 'daughter' ? 'selected' : '' }}>
                                                {{ __('app.daughter') }}</option>
                                            <option value="spouse"
                                                {{ old("participant[$i][relation]") == 'spouse' ? 'selected' : '' }}>
                                                {{ __('app.spouse') }}</option>
                                            <option value="grand father"
                                                {{ old("participant[$i][relation]") == 'grand_father' ? 'selected' : '' }}>
                                                {{ __('app.grand_father') }}</option>
                                            <option value="grand mother"
                                                {{ old("participant[$i][relation]") == 'grand_mother' ? 'selected' : '' }}>
                                                {{ __('app.grand_mother') }}</option>
                                            <option value="grand son"
                                                {{ old("participant[$i][relation]") == 'grand_son' ? 'selected' : '' }}>
                                                {{ __('app.grand_son') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            name="participant[{{ $i }}][package]"
                                            placeholder="{{ __('app.required') }} ..." readonly
                                            value='{{ $package->title }}'>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <h5>{{ __('app.select_date') }}
                            <small>{{ __('app.no_paticipant_including_you', ['paticipant' => session()->has('participant') ? session('participant') + 1 : 1]) }}</small>
                        </h5>
                        <div class="form-group">
                            <input type="text"
                                class="form-control form-control-lg {{ $errors->has('event_date') ? ' is-invalid' : '' }}"
                                onkeydown="return false" name="event_date" id="event_date"
                                placeholder="{{ __('app.date_placeholder') }}" value="{{ old('event_date') }}">
                            <p class="form-text text-danger d-none" id="date_error_holder">
                                {{ __('app.date_error') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="slots_loader" class="d-none">
                            <p style="text-align: center;"><img src="{{ asset('images/loader.gif') }}" width="52"
                                    height="52"></p>
                        </div>
                    </div>
                </div>
                <div id="slots_holder"></div>
                <div id="emergency_holder"></div>

                <div class="row col-md-12">
                    <div class="alert alert-danger col-md-12 d-none" id="slot_error" style="margin-bottom: 50px;">
                        {{ __('app.time_slot_error') }}
                    </div>
                </div>

            </div>
        </div>

        <br>
        <br>

        <footer class="footer d-none d-sm-none d-md-block d-lg-block d-xl-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-copyrights">
                            {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }}
                            {{ config('settings.business_name', 'Bookify') }}.
                        </span>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="navbar-btn btn btn-light btn-lg mr-2" onclick="history.back()">
                            {!! __('pagination.previous') !!}
                        </button>
                        <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            {!! __('pagination.next') !!}
                        </button>
                    </div>
                </div>
            </div>
        </footer>

        {{-- FOOTER FOR PHONES --}}
        <footer class="footer d-block d-sm-block d-md-none d-lg-none d-xl-none">
            <div class="container">
                <div class="row">
                    <div class="col-6 text-left">
                        <button type="button" class="navbar-btn btn btn-light btn-lg" onclick="history.back()">
                            {!! __('pagination.previous') !!}
                        </button>
                    </div>
                    <div class="col-6 text-right">
                        <button type="submit" class="navbar-btn btn btn-primary btn-lg">
                            {!! __('pagination.next') !!}
                        </button>
                    </div>
                </div>
            </div>
        </footer>

    </form>

@endsection

@section('scripts')
    <script src="{{ asset('plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        var nowDate = new Date();
        var firstDay = new Date(nowDate.getFullYear(), nowDate.getMonth(), 1);
        var lastDay = new Date(nowDate.getFullYear(), nowDate.getMonth() + 1, 0);
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        $('#event_date').datepicker({
            orientation: "auto right",
            autoclose: true,
            startDate: today,
            endDate: new Date(lastDay.setMonth(lastDay.getMonth() + 6)),
            datesDisabled: JSON.parse('{!! auth()->check() && auth()->user()->role && (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                ? '[]'
                : $disabledDates !!}'),
            format: 'yyyy-mm-dd',
            // format: 'dd-mm-yyyy',
            daysOfWeekDisabled: "{{ $disable_days_string }}",
            language: "{{ App::getLocale() }}"
        });
    </script>


    @if (config('settings.google_maps_api_key') != null)
        <script src="{{ asset('js/map.js') }}"></script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.google_maps_api_key') }}&libraries=places&callback=initAutocomplete"
            async defer></script>
    @endif
@endsection
