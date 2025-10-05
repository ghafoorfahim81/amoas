<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ $title }} | {{ config('settings.business_name') }} {{ __('backend.admin') }}</title>

    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta charset="UTF-8">
    <meta name="title" content="{{ $title }}" />
    <meta name="description" content="Admin Panel for {{ config('settings.business_name') }}." />
    <meta name="keywords" content="Booking, Calender, Make Booking, Laravel" />
    <meta name="author" content="Mohammad Asif Gulistani" />

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="{{ asset('plugins/pace-master/themes/blue/pace-theme-flash.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/fontawesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/line-icons/simple-line-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/waves/waves.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/summernote-master/summernote.css') }}" rel="stylesheet" type="text/css" />


    <!-- Theme Styles -->
    <link href="{{ asset('css/backend.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/green.css') }}" class="theme-color" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />

    @yield('styles')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

@yield('template')

<body class="page-header-fixed">
    <div class="overlay"></div>

    <main class="page-content content-wrap">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="sidebar-pusher">
                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <div class="logo-box">
                    <a href="{{ route('home') }}"
                        class="logo-text"><span>{{ strtoupper(str_limit(config('settings.business_name'), 9)) }}</span></a>
                </div><!-- Logo Box -->

                <div class="topmenu-outer">
                    <div class="top-menu">
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <a href="javascript:void(0);"
                                    class="waves-effect waves-button waves-classic sidebar-toggle"><i
                                        class="fa fa-bars"></i></a>
                            </li>
                            <li>
                                <a href="{{ route('bookings.index') }}">
                                    <i class="icon-calendar text-success"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.index') }}">
                                    <i class="icon-users text-info"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}">
                                    <i class="icon-settings text-danger"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"
                                    class="waves-effect waves-button waves-classic toggle-fullscreen"><i
                                        class="fa fa-expand"></i></a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle waves-effect waves-button waves-classic"
                                    data-toggle="dropdown">
                                    <span class="user-name">{{ Auth::user()->first_name }}
                                        {{ Auth::user()->last_name }}<i class="fa fa-angle-down"></i></span>
                                    <img class="img-circle avatar"
                                        src="{{ Auth::user()->photo ? asset(Auth::user()->photo->file) : asset('images/profile-placeholder.png') }}"
                                        width="40" height="40"
                                        alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                                </a>
                                <ul class="dropdown-menu dropdown-list" role="menu">
                                    <li role="presentation"><a href="{{ route('users.edit', Auth::user()->id) }}"><i
                                                class="icon-user"></i>{{ __('backend.my_profile') }}</a></li>
                                    <li role="presentation"><a href="{{ route('changePassword') }}"><i
                                                class="icon-lock"></i>{{ __('backend.change_password') }}</a></li>
                                    <li role="presentation"><a href="{{ route('logout') }}"
                                            onclick="
                                event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                            <i class="icon-logout m-r-xs"></i>{{ __('backend.logout') }}
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    class="log-out waves-effect waves-button waves-classic"
                                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <span><i class="icon-logout m-r-xs"></i>{{ __('backend.logout') }}</span>
                                </a>
                            </li>
                        </ul><!-- Nav -->
                    </div><!-- Top Menu -->
                </div>
            </div>
        </div><!-- Navbar -->
        <div class="page-sidebar sidebar">
            <div class="page-sidebar-inner slimscroll">
                <div class="sidebar-header">
                    <br>
                    <p class="text-center">
                        <img class="img-circle avatar"
                            src="{{ Auth::user()->photo ? asset(Auth::user()->photo->file) : asset('images/profile-placeholder.png') }}"
                            width="60" height="60"
                            alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                    </p>
                    <br>
                    <div class="sidebar-profile">
                        <a href="{{ route('users.edit', Auth::user()->id) }}">
                            <div class="sidebar-profile-details">
                                <span>Welcome!<br>{{ Auth::user()->first_name }}
                                    {{ Auth::user()->last_name }}<br><small>{{ ucfirst(Auth::user()->role->name) }}</small></span>
                            </div>
                        </a>
                    </div>
                </div>
                <ul class="menu accordion-menu">


                    <li class="{{ Request::is('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="waves-effect waves-button">
                            <span class="menu-icon icon-home"></span>
                            <p>{{ __('backend.dashboard') }}</p>
                        </a>
                    </li>

                    <li
                        class="{{ Request::is('bookings') || Request::is('bookings/*') || Request::is('invoice/*') ? 'active' : '' }}">
                        <a href="{{ route('bookings.index') }}" class="waves-effect waves-button">
                            <span class="menu-icon icon-calendar"></span>
                            <p>{{ __('backend.bookings') }}</p>
                        </a>
                    </li>

                    <li
                        class="droplink {{ Request::is('tracing') || Request::is('tracing/*') ? 'active open' : '' }}">

                        <a class="waves-effect waves-button">
                            <span class="menu-icon icon-docs"></span>
                            <p>Traceable Docs</p>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu" style="display: none;">
                            <li
                                class="{{ Request::is('tracing/docs') || Request::is('tracing/docs/*') ? 'active' : '' }}">
                                <a href="{{ route('docs.index') }}">All Docs</a>
                            </li>
                            <li
                                class="{{ Request::is('tracing/passport') || Request::is('tracing/passport/*') ? 'active' : '' }}">
                                <a href="{{ route('passport.index') }}">Passport</a>
                            </li>
                            <li
                                class="{{ Request::is('tracing/misc') || Request::is('tracing/misc/*') ? 'active' : '' }}">
                                <a href="{{ route('misc.index') }}">Miscellaneous</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Request::is('postal') || Request::is('postal/*') ? 'active' : '' }}">
                        <a href="{{ route('postal.index') }}" class="waves-effect waves-button">
                            <span class="menu-icon icon-bag"></span>
                            <p>Postal Packages</p>
                        </a>
                    </li>

                    <li class="droplink {{ Request::is('users') || Request::is('users/*') ? 'active open' : '' }}">
                        <a class="waves-effect waves-button">
                            <span class="menu-icon icon-users"></span>
                            <p>{{ __('backend.users') }}</p>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu" style="display: none;">
                            <li class="{{ Request::is('users') || Request::is('users/*/edit') ? 'active' : '' }}"><a
                                    href="{{ route('users.index') }}">{{ __('backend.all_users') }}</a></li>
                            <li class="{{ Request::is('users/create') ? 'active' : '' }}"><a
                                    href="{{ route('users.create') }}">{{ __('backend.add_new_user') }}</a></li>
                            <li class="{{ Request::is('users/roles') ? 'active' : '' }}"><a
                                    href="{{ route('roles.index') }}">{{ __('backend.role') }}</a></li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('categories') || Request::is('categories/*') ? 'active' : '' }}">
                        <a href="{{ route('categories.index') }}" class="waves-effect waves-button">
                            <span class="menu-icon icon-briefcase"></span>
                            <p>{{ __('backend.categories') }}</p>
                        </a>
                    </li>


                    <li
                        class="droplink {{ Request::is('packages') || Request::is('packages/*') ? 'active open' : '' }}">
                        <a class="waves-effect waves-button">
                            <span class="menu-icon icon-list"></span>
                            <p>{{ __('backend.packages') }}</p>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu" style="display: none;">
                            <li
                                class="{{ Request::is('packages') || Request::is('packages/*/edit') ? 'active' : '' }}">
                                <a href="{{ route('packages.index') }}">{{ __('backend.all_packages') }}</a>
                            </li>
                            <li class="{{ Request::is('packages/create') ? 'active' : '' }}"><a
                                    href="{{ route('packages.create') }}">{{ __('backend.add_new_package') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="droplink {{ Request::is('holidays') || Request::is('holidays/*') ? 'active open' : '' }}">
                        <a class="waves-effect waves-button">
                            <span class="menu-icon icon-calendar"></span>
                            <p>{{ __('backend.holidays') }}</p>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu" style="display: none;">
                            {{-- <li class="{{ Request::is('holidays') || Request::is('holidays/*/edit') ? 'active' : '' }}"><a href="{{ route('holidays.index') }}">{{ __('backend.addHolidays') }}</a></li> --}}
                            <li class="{{ Request::is('holidays/index') ? 'active' : '' }}"><a
                                    href="{{ route('holidays.index') }}">{{ __('backend.addHolidays') }}</a></li>
                        </ul>
                    </li>
                    <li
                        class="droplink {{ Request::is('settings') || Request::is('booking-times') ? 'active open' : '' }}">
                        <a class="waves-effect waves-button">
                            <span class="menu-icon icon-settings"></span>
                            <p>{{ __('backend.settings') }}</p>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu" style="display: none;">
                            <li class="{{ Request::is('settings') ? 'active' : '' }}"><a
                                    href="{{ route('settings.index') }}">{{ __('backend.settings') }}</a></li>
                            <li class="{{ Request::is('booking-times') ? 'active' : '' }}"><a
                                    href="{{ route('booking-times.index') }}">{{ __('backend.booking_times') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="waves-effect waves-button">
                            <span class="menu-icon icon-logout"></span>
                            <p>{{ __('backend.logout') }}</p>
                        </a>
                    </li>

                </ul>
            </div><!-- Page Sidebar Inner -->
        </div><!-- Page Sidebar -->
        <div class="page-inner">

            @yield('content')

            <!-- Main Wrapper -->
            <div class="page-footer">
                <p class="no-s">
                    {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }}
                    {{ config('settings.business_name', 'Bookify') }}.
                </p>
            </div>
        </div><!-- Page Inner -->
    </main><!-- Page Content -->
    <div class="cd-overlay"></div>


    <!-- Javascripts -->
    <script src="{{ asset('plugins/jquery/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('plugins/pace-master/pace.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('plugins/waves/waves.min.js') }}"></script>
    <script src="{{ asset('js/backend.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('plugins/summernote-master/summernote.min.js') }}"></script>
    <script src="{{ asset('js/pages/form-elements.js') }}"></script>
    @yield('scripts')
</body>

</html>
