<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $cssUrl = isset($isPdf) && $isPdf ? public_path('css/bootstrap.slim.css') : asset('css/app.css');
    @endphp
    <link rel="stylesheet" href="{{ $cssUrl }}" type="text/css">
    {{-- <link rel="stylesheet" href="{{ public_path('css/bootstrap.slim.css') }}" type="text/css"> --}}

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #040404;
        }

        .container {
            background-color: #bbc7eb54;
        }

        .img-logo h3 {
            color: #323232;
        }

        .e-section {
            background-color: white;
        }

        .e-logo {
            background-color: #5163af;
            height: 5rem;
        }

        .e-list {
            color: #323232;
        }

        .list-group-item {
            display: list-item;
        }
    </style>
</head>

<body>
    <div class="container text-black mt-3" style="background-color: white;">
        <div class="row">
            <div class="col-md-12 text-center img-logo">
                @php
                    $logo =
                        isset($isPdf) && $isPdf
                            ? public_path('images/email_afg_logo.png')
                            : asset('images/email_afg_logo.png');
                @endphp
                <img src="{{ $logo }}" width="130">
                <h4>Islamic Republic of Afghanistan</h4>
                <h4>Ministry of Foreign Affairs</h4>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-md-12 offset-0 text-center shadow-lg rounder e-logo"
                style="background-color: #5163af; height: 5rem;">
                <span style="font-size: 50px; color:white;">&#9993;</span>
            </div>
            <div class="col-md-12 text-left small bg-white pb-3 pt-4">
                <h4>Dear
                    {{ $name ?? isset($booking->info->full_name) ? $booking->info->full_name : null ?? $booking->user->first_name . ' ' . $booking->user->last_name }},
                </h4>
                <p style="font-size:15px">
                    We're pleased to confirm your appointment for
                    <strong>{{ $booking->booking_date . ' ' . $booking->booking_time }}</strong>
                    at our mission in
                    <u>{{ $booking->department->name_en }}</u>.
                    Please arrive promptly and present your printed appointment confirmation.
                </p>
            </div>
            <div class="col-md-12 text-center mt-4">
                <span
                    style="font-size: 20px; letter-spacing:2px; font-weight: bold; border: solid 1.5px #5163af; padding: 10px;">{{ $booking->serial_no }}</span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                @php
                    $hash = Crypt::encryptString($booking->serial_no);
                    $url = route('booking.verify', $hash);
                @endphp
                <div class="p-2 bg-white mx-auto text-center">
                    <img src="data:image/png;base64,{{ \DNS2D::getBarcodePNG("$url", 'QRCODE') }}" alt="barcode" />
                </div>
            </div>

        </div>
        <div class="row mt-3 text-center">
            <div class="col-md-12">
                <img src="data:image/png;base64,{{ \DNS1D::getBarcodePNG("$booking->serial_no", 'C128', 2, 50, [0, 0, 0], false) }}"
                    alt="barcode" />
            </div>
        </div>
        @if ($booking->info->participants->count() > 0)
            <div class="row mt-3">
                <div class="col-md-12">
                    <p>
                        Please be aware that you have also booked appointments for your family members.
                        To facilitate a seamless visit for everyone, we kindly request that you arrive together at the
                        scheduled time.

                    <ol>
                        @foreach ($booking->info->participants as $relative)
                            <li>
                                <u>{{ $relative->full_name }},</u>
                                IDCard:&nbsp;<u>{{ $relative->id_card }},</u>
                                Family:&nbsp;<u>{{ $relative->relation }}</u>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif
        <div class="row mt-3">
            <div class="col-md-12 text-left small mt-4 list-option">
                <p style="font-size:15px">You have requested for <strong>{{ $booking->package->title }}</strong>, you
                    must provide the
                    following document before the booking</p>

                <div>
                    <strong>Service conditions and requirements:</strong>
                    <hr>

                    {!! $booking->package->description !!}

                </div>
            </div>
        </div>
    </div>
</body>

</html>
