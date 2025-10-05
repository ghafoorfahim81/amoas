@extends('layouts.login', ['title' => __('passwords.page_title')])

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">
            <a href="{{ route('index') }}" class="brand">
                <img src="{{ asset('images/logo-dark.png') }}" alt="Logo" class="img-responsive">
            </a>
            <h1 class="auth-title">{{ __('passwords.page_title') }}</h1>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="post" action="{{ route('password.email') }}" class="auth-form" novalidate>
                @csrf
                <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">{{ __('auth.email_placeholder') }}</label>
                    <input type="email" class="form-control modern-input" id="email" name="email"
                        placeholder="{{ __('auth.email_placeholder') }}" value="{{ old('email') }}" autocomplete="email"
                        required>
                    @if ($errors->has('email'))
                        <p class="text-danger">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <button type="submit" class="btn modern-btn">{{ __('passwords.reset_btn') }}</button>
                <div class="auth-links">
                    <span>{{ __('passwords.remembered') }}</span>
                    <a href="{{ route('login') }}">{{ __('passwords.back_to_login_btn') }}</a>
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
            max-width: 420px;
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
            justify-content: space-between;
            gap: 8px;
            margin-top: 14px;
            font-size: 14px;
            align-items: center;
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

        @media (max-width: 420px) {
            .auth-card {
                padding: 24px 18px;
                border-radius: 14px;
            }

            .brand img {
                max-width: 140px;
            }

            .auth-links {
                flex-direction: column;
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

            .field label {
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
