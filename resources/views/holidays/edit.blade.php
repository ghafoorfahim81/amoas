@extends('layouts.admin', ['title' => __('backend.holidays')])

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/select2-bootstrap.min.css') }}">
@endsection

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.holidays') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('holidays.index') }}">{{ __('backend.holidays') }}</a></li>
                <li class="active">{{ __('backend.holidays') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.holidays') }}</h4>
                    </div>
                    <div class="panel-body">

                        <form method="POST" action="{{ route('holidays.update', $holiday->id) }}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            {{ method_field('PATCH') }}

                            <div class="form-group {{$errors->has('day') ? ' has-error' : ''}}">
                                <label class="control-label" for="day">{{ __('backend.day') }}</label>
                                <input type="text" class="form-control" name="day" value="{{$holiday->day}}">
                                @if ($errors->has('day'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('day') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('month') ? ' has-error' : ''}}">
                                <label class="control-label" for="month">{{ __('backend.month') }}</label>
                                <input type="text" class="form-control" name="month" value="{{$holiday->month}}">
                                @if ($errors->has('month'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('month') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('year') ? ' has-error' : ''}}">
                                <label class="control-label" for="year">{{ __('backend.year') }}</label>
                                <input type="text" class="form-control" name="year" value="{{$holiday->year}}">
                                @if ($errors->has('year'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('year') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('repeated') ? ' has-error' : ''}}">
                                <label class="control-label" for="repeated">{{ __('backend.repeated') }}</label>
                                <select name="repeated" class="form-control">
                                    <option value="1" {{$holiday->repeated == 1 ? 'selected' : ''}}>Yes</option>
                                    <option value="0" {{$holiday->repeated == 0 ? 'selected' : ''}}>No</option>
                                </select>
                                {{-- <input type="text" class="form-control" name="repeated" value="{{old('repeated')}}"> --}}
                                @if ($errors->has('repeated'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('repeated') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('description') ? ' has-error' : ''}}">
                                <label class="control-label" for="description">{{ __('backend.description') }}</label>
                                <input type="text" class="form-control" name="description" value="{{$holiday->description}}">
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="description">{{ __('backend.department') }}</label>
                                <br>
                                <input type="checkbox" name="all_department" class="form-check-input"> Add to all departments;
                                <br>
                                <br>
                                <select
                                    class="form-control simple-select2 {{ $errors->has('departments') ? 'is-invalid' : '' }}" multiple
                                    name="departments[]">
                                    @foreach (\App\Department::whereIn('type', ['embassy', 'consulate'])->where('status', 1)->get() as $department)
                                        <option value="{{$department->id}}"
                                            {{ $department->id == old('department_id') ? 'selected' : null }}>
                                            {{ ucfirst($department->name_en) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.add_category') }}</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')

<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>

<script>
    $(function () {
        $('.simple-select2').select2({
            // 'theme': 'bootstrap',
            multiple: true,
            tags:true
        // }).val(JSON.parse({{$departments}})).trigger('change')
        }).val({{$departments}}).trigger('change')
    });
</script>

@endsection