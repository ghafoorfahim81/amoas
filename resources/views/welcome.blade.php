@extends('layouts.app', ['title' => __('app.welcome_page_title')])

@section('content')
    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.welcome_title') }}</h1>
            <p class="promo-desc text-center">
                {{ __('app.welcome_subtitle') }}
            </p>
        </div>
    </div>

    <form method="post" id="booking_step_1" action="{{ Auth::user() ? route('postStep1') : route('register') }}">

        {{ csrf_field() }}
        <div class="container">
            <div class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-12">
                            <div id="progressbar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100">0%</div>
                        </div>
                        <br><br>
                    </div>
                </div>

                <div class="row" id="guideline">
                    <div class="col-md-8">
                        <h5>@lang('app.howToReserve')</h5>
                        @lang('app.guidelineStep')
                    </div>
                    <div class="col-md-4">
                        <h5>@lang('app.quickLinks')</h5>
                        <ul>
                            {{-- @lang('app.quickLinksCheckVisa', ['href'=> route('check-status')]) --}}
                            @lang('app.quickLinksCreateAccount', ['href' => route('register')])
                            @lang('app.quickLinksTraceDoc', ['href' => route('docs.check')])

                        </ul>
                    </div>
                </div>
                {{-- <br>
                <div id="categories_holder">
                    <h5>@lang('app.selectCategoryOfService')</h5>
                    <br>
                    <div class="row">
                        @if (count($categories))
                            @foreach ($categories as $category)
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                    <div class="type_box category_box" data-category-id="{{ $category->id }}">
                                        <div class="responsive-image"><img class="responsive-image" alt="{{ $category->title }}" src="{{ asset($category->photo->file) }}"></div>
                                        <div class="type_title">
                                            <div class="text-container">
                                                <p class="text_type">{{ Lang::has('app.' . $category->title, app()->getLocale()) ? __('app.' . $category->title) : $category->title }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="alert alert-danger">{{ __('app.no_category_error') }}</div>
                            </div>
                        @endif
                    </div>
                    <br>
                </div> --}}

                <div class="row">
                    <div class="col-md-12">
                        <div id="packages_loader" class="d-none">
                            <p style="text-align: center;"><img src="{{ asset('images/loader.gif') }}" width="52"
                                    height="52"></p>
                        </div>
                    </div>
                </div>

                <div id="packages_holder">
                    @include('blocks.packages')
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="package_info_loader" class="d-none">
                            <p style="text-align: center;"><img src="{{ asset('images/loader.gif') }}" width="52"
                                    height="52"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 d-none" id="package_desc_container">
                        <h5>@lang('app.requirementsForPackage')</h5>
                        <div id="package_desc"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger d-none" id="package_error">{{ __('app.no_package_selected_error') }}
                        </div>
                        <br>
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
                    <div class="col-md-6 text-right">
                        @if (Auth::user())
                            <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                                {!! __('pagination.next') !!}
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="navbar-btn btn btn-primary btn-lg ml-auto">
                                <i class="fa fa-sign-in-alt"></i> &nbsp; @lang('app.loginOrRegister')
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </footer>

        {{-- FOOTER FOR PHONES --}}

        <footer class="footer d-block d-sm-block d-md-none d-lg-none d-xl-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        @if (Auth::user())
                            <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                                {!! __('pagination.next') !!}
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="navbar-btn btn btn-primary btn-lg ml-auto login-btn">
                                <i class="fa fa-sign-in-alt"></i> &nbsp; @lang('app.loginOrRegister')
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </footer>

    </form>

    <!-- Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="{{ asset('images/loader.gif') }}" alt="loading..." srcset="">
                    <h2>@lang('app.loadingPlzWait')</h2>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        //append form with selected package_id

        $('body').on('click', 'a.btn_package_select', function() {

            var package_id = $(this).attr('data-package-id');
            $('#package_error').addClass('d-none');

            $('#package_id').remove();
            $('#booking_step_1').append('<input type="hidden" name="package_id" id="package_id" value="' +
                package_id + '">');

            $('.btn_package_select').text('{{ __('app.booking_package_btn_select') }}').removeClass(
                'btn-secondary').addClass('btn-primary').css('color', 'white');
            $(this).text('{{ __('app.booking_package_btn_selected') }}').removeClass('btn-primary').addClass(
                'btn-secondary');

            var package_id = $(this).attr('data-package-id');
            $('#package_info_loader').removeClass('d-none');

            $.get("{{ URL('/ajax_package_info') }}", {
                id: package_id
            }, function(data) {

                $('#package_desc_container').removeClass('d-none');
                $('#package_desc').html(data);

                $('#package_info_loader').addClass('d-none');

                $('html,body').animate({
                    scrollTop: $('#package_desc').offset().top
                }, 'slow');

                // set progress bar 25%
                $('#progressbar').css('width', '25%').attr('aria-valuenow', 25).text('25%');

            });
        });
    </script>
@endsection
