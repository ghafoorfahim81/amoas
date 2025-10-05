@extends('layouts.app', ['title' => 'AMOAS Verify email'])

@section('content')
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('app.email_verification') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('app.fresh_verification_link') }}
                            </div>
                        @endif

                        {{ __('app.before_proceeding') }}
                        {{ __('app.if_not_received') }}
                    </div>
                    <div class="card-footer">
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">{{ __('app.request_new_link') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
