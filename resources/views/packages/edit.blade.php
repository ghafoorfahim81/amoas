@extends('layouts.admin', ['title' => __('backend.edit_package')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.edit_package') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('packages.index') }}">{{ __('backend.packages') }}</a></li>
                <li class="active">{{ __('backend.edit_package') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.edit_package') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{ route('packages.update', $package->id) }}"
                            enctype="multipart/form-data">

                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="col-md-6 form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label class="control-label" for="title">{{ __('backend.title') }}</label>
                                <input type="text" class="form-control" name="title" value="{{ $package->title }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label class="control-label" for="price">{{ __('backend.price') }}</label>
                                <input type="text" class="form-control" name="price" value="{{ $package->price }}">
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                <label class="control-label" for="category_id">{{ __('backend.category') }}</label>
                                <select class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $package->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="col-md-6 form-group{{ $errors->has('duration') ? ' has-error' : '' }}">
                                <label class="control-label" for="duration">{{ __('backend.duration_in_minutes') }}</label>
                                <select class="form-control" name="duration">
                                    @for ($factor = 1; $factor <= 6; $factor++)
                                        <option value="{{ config('settings.slot_duration') * $factor }}"
                                            {{ $package->duration == config('settings.slot_duration') * $factor ? 'selected' : '' }}>
                                            @if (config('settings.slot_duration') * $factor < 60)
                                                {{ config('settings.slot_duration') * $factor }}
                                                {{ __('backend.minutes') }}
                                            @elseif(config('settings.slot_duration') * $factor >= 60)
                                                {{ floor((config('settings.slot_duration') * $factor) / 60) }}

                                                @if (floor((config('settings.slot_duration') * $factor) / 60) > 1)
                                                    {{ __('backend.hours') }}
                                                @else
                                                    {{ __('backend.hour') }}
                                                @endif

                                                @if ((config('settings.slot_duration') * $factor) % 60 > 0)
                                                    {{ (config('settings.slot_duration') * $factor) % 60 }}
                                                    {{ __('backend.minutes') }}
                                                @endif
                                            @endif
                                        </option>
                                    @endfor
                                </select>
                                @if ($errors->has('duration'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('duration') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group {{ $errors->has('daily_acceptance') ? ' has-error' : '' }}">
                                <label class="control-label"
                                    for="daily_acceptance">{{ __('backend.daily_acceptance') }}</label>
                                <input type="number" class="form-control" name="daily_acceptance"
                                    value="{{ $package->daily_acceptance }}">
                                @if ($errors->has('daily_acceptance'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('daily_acceptance') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div
                                class="col-md-6 form-group {{ $errors->has('emergency_acceptance') ? ' has-error' : '' }}">
                                <label class="control-label"
                                    for="emergency_acceptance">{{ __('backend.emergency_acceptance') }}</label>
                                <input type="number" class="form-control" name="emergency_acceptance"
                                    value="{{ $package->emergency_acceptance }}">
                                @if ($errors->has('emergency_acceptance'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('emergency_acceptance') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group {{ $errors->has('lock_for_missions') ? 'has-error' : '' }}">
                                <label class="control-label"
                                    for="lock_for_missions">{{ __('Lock the availablity of the package for following missions\' areas') }}</label>
                                <select class="form-control" name="lock_for_missions[]" multiple>
                                    <option value="" {{ $isLockedForAnyMission ?? 'selected' }}>
                                        {{ __('All mission can request for termin') }}</option>
                                    @foreach ($availablePostCodeForMissions as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ in_array($id, $missionAreLocked) ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('lock_for_missions'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('lock_for_missions') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label class="control-label" for="description">{{ __('backend.description') }}</label>
                                <textarea name="description" class="summernote">{{ $package->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{ $errors->has('photo_id') ? ' has-error' : '' }}">
                                <label for="photo_id" class="control-label">{{ __('backend.select_image') }}</label>
                                <input type="file" id="photo_id" name="photo_id">
                                @if ($errors->has('photo_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block">
                                    <strong class="text-info">{{ __('backend.package_image_info') }}</strong>
                                </span>
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit"
                                    class="btn btn-primary btn-lg">{{ __('backend.update_package') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
