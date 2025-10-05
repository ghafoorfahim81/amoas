@extends('layouts.app', ['title' => __('app.final_step_title')])

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.welcome_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.welcome_subtitle') }}</p>
        </div>
    </div>

    <div class="container">
        <div class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="progress mx-lg-12">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar"
                            style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <strong>100%</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                @if (Session::has('paypal_error'))
                    <div class="alert alert-danger col-md-12">{{ session('paypal_error') }}</div>
                @endif
                <div class="col-12">
                    <br>
                    <div class="alert alert-success col-md-12">
                        <h5>{{ __('app.booking_success_msg') }}</h5>
                    </div>
                </div>

                <div class="col-md-4">
                    <br>
                    <h3>{{ __('app.booking_summary') }}</h3>
                    <br>
                    <h6><i class="fas fa-user fa-lg text-primary"></i>&nbsp;&nbsp;{{ $booking->info->full_name }}</h6>
                    <h6><i class="fas fa-envelope fa-lg text-primary"></i>&nbsp;&nbsp;{{ $booking->info->email }}</h6>
                    <h6><i class="fas fa-phone fa-lg text-primary"></i>&nbsp;&nbsp;{{ $booking->info->phone }}</h6>
                    <h6><i class="fas fa-map-marker fa-lg text-primary"></i>&nbsp;&nbsp;{{ $booking->info->full_address }}
                    </h6>
                    <h6><i class="fas fa-calendar fa-lg text-primary"></i>&nbsp;&nbsp;{{ $booking->booking_date }}
                        {{ $booking->booking_time }}</h6>
                    </h6>
                    <br>
                    <h4>{{ __('app.booking_details') }}</h4>
                    <h5>{{ $category }} > {{ $package->title }}</h5>
                    <br>

                </div>
                <div class="col-md-8">

                    <br>
                    <h3>&nbsp;</h3>
                    <br>
                    @if ($booking->info->participants->count() > 0)
                        <h6>{{ __('app.participant') }} </h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>{{ __('app.full_name') }}</td>
                                        <td>{{ __('app.id_card') }}</td>
                                        <td>{{ __('app.relationType') }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking->info->participants as $participant)
                                        <tr>
                                            <td>{{ $participant['full_name'] }}</td>
                                            <td>{{ $participant['id_card'] }}</td>
                                            <td>{{ $participant['relation'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    @else
                        <p>{{ __('app.no_participant') }}</p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <a href="{{ route('printNow', [$booking->id]) }}" onclick="open(this.href).print(); return false"
                        class="btn btn-primary">
                        <i class="fa fa-print"></i> {{ __('app.print_now') }}
                    </a>
                    <a href="{{ route('printPdf', [$booking->id]) }}" class="btn btn-primary">
                        <i class="fa fa-print"></i> {{ __('app.print_pdf') }}
                    </a>
                </div>
                <div class="col-md-8">

                </div>
            </div>

        </div>
    </div>

    <br>
    <br>

    <footer class="footer">
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

@endsection

@section('scripts')
    @if (config('settings.stripe_enabled'))
        <script src="https://js.stripe.com/v2/"></script>
        <script type="text/javascript">
            Stripe.setPublishableKey('{{ config('
                settings.stripe_sandbox_enabled ') ?
                config('settings.stripe_test_key_pk'): config('settings.stripe_live_key_pk')
            }
            }
            ');
            $('#stripe_cc_form').submit(function(e) {
                $form = $(this);
                $form.find('button').prop('disabled', true);
                $('#cc_loader').removeClass('d-none');
                Stripe.card.createToken($form, function(status, response) {

                    if (response.error) {
                        $('#cc_loader').addClass('d-none');
                        $form.find('.stripe_error').html('<div class="alert alert-danger">' + response.error
                            .message + '</div>');
                        $form.find('button').prop('disabled', false);
                    } else {
                        var token = response.id;
                        $form.append($('<input type="hidden" name="stripe-token">').val(token));
                        $form.get(0).submit();
                    }
                });
                return false;
            });
        </script>
    @endif
@endsection
