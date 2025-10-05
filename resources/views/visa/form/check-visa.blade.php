@extends('layouts.app', ['title' => __('app.step_two_page_title')])

@section('content')

<div class="jumbotron promo">
    <div class="container">
        <h1 class="text-center promo-heading">{{ __('app.welcome_title') }}</h1>
        @if(session()->has('department'))
            @php
                $department = session('department');
            @endphp
            <h3 class="text-center promo-heading">{{ $department->name_en }}</h3>
        @endif
        <p class="promo-desc text-center">{{ __('app.welcome_subtitle') }}</p>
    </div>
</div>

<div class="container">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">{{ __('app.checkOnlineStatus') }}</h3>
                <hr>
                @if (count($errors) > 0)
                <h4>Invalid information. please fill the following form correctly.</h4>
                <div class="error">
                    <ol>
                        @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ol>
                </div>
                @endif
            </div>
        </div>
        <br>

        <div class="row">
            <div class="container">
                <form action="{{route('do-check-status')}}" id="searchInput" class="col-12" method="post">
                        {{ csrf_field() }}
                    <div class="col-md-6">
                        <div class="form-group">
                                <i class="fa fa-asterisk text-danger"></i> <label for="">@lang('app.visaStatusSerial')</label>
                                <input name="serial_no" placeholder="@lang('app.serialHere')" value="" type="text"
                                    class="form-control form-control-lg">
                        </div>
                    </div>
                    <div class="col-md-2">
                            <div class="form-group">
                        <button class="btn btn-default btn-lg btn-light"><i class="fa fa-search"></i>
                            @lang('app.search')</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @if($message)
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            </div>
            @endif

            @if($visa)
            <div class="col-md-12">
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Serial Number</th>
                                <th>Applied Mission</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>{{$visa->serial_no}}</th>
                                <td>{{$visa->department->name_en}}</td>
                                <td>{{$visa->status}}</td>
                                <td>
                                    <a href="{{ route('visa.print', [$visa->id]) }}">Print</a>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            @endif
        </div>


        <div id="slots_holder"></div>

        <div class="row col-md-12">
            <div class="alert alert-danger col-md-12 d-none" id="slot_error" style="margin-bottom: 50px;">
                {{ __('app.time_slot_error') }}
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
        </div>
    </div>
</footer>
@endsection

@section('scripts')

<script>

</script>
@endsection