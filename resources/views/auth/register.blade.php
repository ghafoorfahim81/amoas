@extends('layouts.app', ['title' => __('app.registration')])

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="{{ route('index') }}" class="brand">
                <img src="{{ asset('images/logo-dark.png') }}" alt="Logo" class="img-responsive">
            </a>
            <h1 class="auth-title">{{ __('app.registration') }}</h1>

            <form method="POST" action="{{ route('register') }}" class="auth-form" novalidate>
                @csrf
                <div class="field">
                    <label for="first_name">{{ __('app.first_name') }}</label>
                    <input id="first_name" type="text"
                        class="form-control modern-input{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                        name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" required autofocus>
                    @if ($errors->has('first_name'))
                        <span class="invalid-feedback"
                            role="alert"><strong>{{ $errors->first('first_name') }}</strong></span>
                    @endif
                </div>

                <div class="field">
                    <label for="last_name">{{ __('app.last_name') }}</label>
                    <input id="last_name" type="text"
                        class="form-control modern-input{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                        name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" required>
                    @if ($errors->has('last_name'))
                        <span class="invalid-feedback"
                            role="alert"><strong>{{ $errors->first('last_name') }}</strong></span>
                    @endif
                </div>

                <div class="field">
                    <label for="email">{{ __('app.email') }}</label>
                    <input id="email" type="email"
                        class="form-control modern-input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                        value="{{ old('email') }}" autocomplete="email" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                </div>

                <div class="field">
                    <label for="password">{{ __('app.password') }}</label>
                    <input id="password" type="password"
                        class="form-control modern-input{{ $errors->has('password') ? ' is-invalid' : '' }}"
                        name="password" autocomplete="new-password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback"
                            role="alert"><strong>{{ $errors->first('password') }}</strong></span>
                    @endif
                </div>

                <div class="field">
                    <label for="password-confirm">{{ __('app.password_confirmation') }}</label>
                    <input id="password-confirm" type="password" class="form-control modern-input"
                        name="password_confirmation" autocomplete="new-password" required>
                </div>

                <div class="field">
                    <label for="terms" class="terms-label{{ $errors->has('terms') ? ' text-danger' : '' }}">
                        <input id="terms" type="checkbox" name="terms" required> {{ __('app.i_accept_terms') }}
                    </label>
                    <div class="terms-note">{{ __('app.for_more_information') }} <a
                            href="{{ route('privacy-policy') }}">{{ __('app.data_privacy_policy') }}</a>.</div>
                </div>

                <button type="submit" class="btn modern-btn">{{ __('app.register') }}</button>
                <div class="auth-links">
                    <a href="{{ route('login') }}">{{ __('app.login_link') }}</a>
                </div>
            </form>

            <p class="auth-footer text-center m-t-xs text-sm">
                {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }}
                {{ config('settings.business_name', 'Bookify') }}.
            </p>
        </div>
    </div>
@endsection
@section('styles')
    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: radial-gradient(1200px 600px at 10% -10%, rgba(79, 70, 229, .08), transparent 60%), radial-gradient(1000px 600px at 110% 110%, rgba(59, 130, 246, .08), transparent 60%), linear-gradient(#f9fafb, #eef2ff);
        }

        .auth-card {
            width: 100%;
            max-width: 520px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            padding: 32px 28px;
        }

        .brand img {
            display: block;
            margin: 0 auto 8px;
            max-width: 160px;
            height: auto;
        }

        .auth-title {
            text-align: center;
            margin: 8px 0 20px;
            font-size: 20px;
            color: #111827;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .alert {
            border-radius: 12px;
        }

        .field {
            margin-bottom: 14px;
        }

        .field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .terms-label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .terms-note {
            font-size: 12px;
            color: #6b7280;
            margin-top: 6px;
        }

        .modern-input {
            height: 46px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 10px 14px;
            transition: box-shadow .2s, border-color .2s;
        }

        .modern-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, .15);
            outline: none;
        }

        .modern-btn {
            width: 100%;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(90deg, #4f46e5, #3b82f6);
            color: #fff;
            border: 0;
            font-weight: 600;
            letter-spacing: .2px;
            transition: transform .05s ease, box-shadow .2s, opacity .2s;
        }

        .modern-btn:hover {
            opacity: .95;
            box-shadow: 0 8px 24px rgba(59, 130, 246, .35);
        }

        .modern-btn:active {
            transform: translateY(1px);
        }

        .auth-links {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 14px;
            font-size: 14px;
        }

        .auth-links a {
            color: #4f46e5;
            text-decoration: none;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        .auth-footer {
            margin-top: 18px;
            color: #6b7280;
            font-size: 12px;
        }

        @media (max-width: 520px) {
            .auth-card {
                padding: 24px 18px;
                border-radius: 14px;
            }

            .brand img {
                max-width: 140px;
            }

            .auth-links {
                flex-direction: column;
                align-items: center;
                gap: 6px;
            }
        }

        @media (prefers-color-scheme: dark) {
            .auth-wrapper {
                background: linear-gradient(#0b0c10, #0b0c10) !important;
            }

            .auth-card {
                background: #111318;
                color: #e5e7eb;
                box-shadow: 0 8px 30px rgba(0, 0, 0, .5);
            }

            .auth-title {
                color: #f9fafb;
            }

            .field label,
            .terms-label {
                color: #e5e7eb;
            }

            .modern-input {
                background: #0b0c10;
                border-color: #1f2937;
                color: #e5e7eb;
            }

            .modern-input::placeholder {
                color: #6b7280;
            }

            .auth-footer {
                color: #9ca3af;
            }

            .auth-links a {
                color: #60a5fa;
            }
        }
    </style>
@endsection
