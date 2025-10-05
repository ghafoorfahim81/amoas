<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title -->
    <title>{{ __('errors.error_404') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('favicon.png') }}">
</head>
<body style="background-color: #F2F2F2;">

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center" style="margin-top:10%;">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 text-center">
                        <p style="text-align: center;">
                            <img src="{{ asset('images/icon-booking-failed.png') }}">
                        </p>
                        <h1 class="text-dark"><strong>We didn\'t find any matches.</strong></h1>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>