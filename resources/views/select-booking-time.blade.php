@extends('layouts.app', ['title' => __('app.step_two_page_title')])

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.welcome_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.welcome_subtitle') }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('postStep2') }}">
        {{ csrf_field() }}
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-12">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0"
                                aria-valuemax="100"><strong>50%</strong></div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label>{{ __('app.booking_for') }} <small>({{ __('app.required') }})</small></label>
                        <div class="form-group {{ $errors->has('booking_for') ? 'has-danger' : '' }}">
                            <select name="booking_for" required
                                class="form-control {{ $errors->has('booking_for') ? 'is-invalid' : '' }}">
                                <option value="" selected disabled>{{ __('app.select_option') }}</option>
                                <option value="myself" {{ old('booking_for') == 'myself' ? 'selected' : null }}>
                                    {{ __('app.myself') }}
                                </option>
                                <option value="someone_else"
                                    {{ old('booking_for') == 'someone_else' ? 'selected' : null }}>
                                    {{ __('app.someone_else') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-6">
                        <label>{{ __('app.provide_address') }} <small>({{ __('app.required') }})</small></label>
                        <div class="form-group">
                            <input name="email" type="email" required
                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ old('email') }}">
                            <small>{{ __('app.email_description') }}</small>
                            <p class="form-text text-danger d-none" id="address_error_holder">
                                {{ __('app.address_error') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('app.full_name') }} <small>({{ __('app.required') }})</small></label>
                            <div class="form-group">
                                <input name="full_name" type="text" required
                                    class="form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }} "
                                    value="{{ old('full_name') }}">
                                <small>&nbsp;</small>
                                <p class="form-text text-danger d-none" id="address_error_holder">
                                    {{ __('app.address_error') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('app.phone') }} <small>({{ __('app.required') }})</small></label>
                            <div class="form-group">
                                <input name="phone" type="text" required
                                    class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                    value="{{ old('phone') }}">
                                <p class="form-text text-danger d-none" id="address_error_holder">
                                    {{ __('app.address_error') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('app.participant') }} <small>({{ __('app.optional') }})</small></label>

                            <select name="participant"
                                class="form-control {{ $errors->has('participant') ? 'is-invalid' : '' }}">
                                <option value="" selected>{{ __('app.iam_alone') }}</option>
                                @for ($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}"
                                        {{ old('participant') == $i ? 'selected' : null }}>
                                        {{-- {{ $i }} {{ __('app.family_member') }} --}}
                                        {{ trans_choice('app.family_member', $i, ['count' => $i]) }}
                                    </option>
                                @endfor
                            </select>

                            <p class="form-text text-danger d-none" id="address_error_holder">
                                {{ __('app.address_error') }}
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('app.current_street_house') }}
                                <small>({{ __('app.required') }})</small></label>
                            <div class="form-group">
                                <input name="street" type="text" required
                                    class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}"
                                    value="{{ old('street') }}">
                                <p class="form-text text-danger d-none">
                                    {{ __('app.street') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('app.postal') }}
                                <small>({{ __('app.required') }})</small></label>
                            <select id="postal-code" name="postal" required
                                class="form-control {{ $errors->has('postal') ? 'is-invalid' : '' }}">
                                <option value="">{{ __('app.select_option') }}</option>
                            </select>
                            <p class="form-text text-danger d-none" id="address_error_holder">
                                {{ __('app.address_error') }}
                            </p>
                            @if ($errors->has('postal'))
                                <p class="form-text text-danger">
                                    {{ $errors->first('postal') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ __('app.current_city') }}
                                <small>({{ __('app.required') }})</small></label>
                            <select id="place" name="place" required
                                class="form-control {{ $errors->has('place') ? 'is-invalid' : '' }}">
                                <option value="">{{ __('app.select_option') }}</option>
                            </select>
                            <p class="form-text text-danger d-none">
                                {{ __('app.place') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <br>
            <br>
        </div> <!-- Closing the container div -->

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
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>

    <script>
        var selectedPostalCode;

        $(document).ready(function() {
            $('#postal-code').select2({
                ajax: {
                    url: "{{ route('postal-codes.list') }}", // Route to fetch postal codes
                    dataType: 'json',
                    delay: 50,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    state: item.state,
                                    place: item.place,
                                    zip: item.zip,
                                    text: item.zip + ' ' + item.place + ' (' + item.state + ')',
                                    id: item.zip
                                }
                            })
                        };
                    },
                    cache: true
                },
                placeholder: '{{ __('app.select_option') }}',
                minimumInputLength: 2,
                theme: 'bootstrap4',
            }).on('select2:select', function(e) {
                selectedPostalCode = e.params.data;
                // set the #city select2 value 
                const cityValue = {
                    id: selectedPostalCode.place,
                    text: selectedPostalCode.place + ' (' + selectedPostalCode.state + ')'
                };

                const place = $('#place');

                place.append(new Option(cityValue.text, cityValue.id, true, true));

            });

            $('#city').select2({
                ajax: {
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },
                placeholder: '{{ __('app.select_option') }}',
                minimumInputLength: 2,
                theme: 'bootstrap4',
            });
        });

        var myself = @json(['email' => auth()->user()->email, 'full_name' => auth()->user()->full_name]);

        // add on value change event listener to select named booking_for with jquery
        $('select[name="booking_for"]').on('change', function() {
            var bookingFor = $(this).val();
            if (bookingFor === 'myself') {
                $('input[name="email"]').val(myself.email);
                $('input[name="full_name"]').val(myself.full_name);
            } else {
                $('input[name="email"]').val('');
                $('input[name="full_name"]').val('');
            }
        });
    </script>
@endsection
