@extends('layouts.admin', ['title' => __('backendholidays')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.holidays') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.holidays') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">

                @include('alerts.alert')

                <div class="col-md-4">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('backend.addHolidays') }}</h4>
                        </div>
                        <div class="panel-body">

                            <form method="POST" action="{{ route('holidays.store') }}">

                                {{csrf_field()}}

                                <div class="form-group {{$errors->has('day') ? ' has-error' : ''}}">
                                    <label class="control-label" for="day">{{ __('backend.day') }}</label>
                                    <input type="text" class="form-control" name="day" value="{{old('day')}}">
                                    @if ($errors->has('day'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('day') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{$errors->has('month') ? ' has-error' : ''}}">
                                    <label class="control-label" for="month">{{ __('backend.month') }}</label>
                                    <input type="text" class="form-control" name="month" value="{{old('month')}}">
                                    @if ($errors->has('month'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('month') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{$errors->has('year') ? ' has-error' : ''}}">
                                    <label class="control-label" for="year">{{ __('backend.year') }}</label>
                                    <input type="text" class="form-control" name="year" value="{{old('year')}}">
                                    @if ($errors->has('year'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('year') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{$errors->has('repeated') ? ' has-error' : ''}}">
                                    <label class="control-label" for="repeated">{{ __('backend.repeated') }}</label>
                                    <select name="repeated" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
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
                                    <input type="text" class="form-control" name="description" value="{{old('description')}}">
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.add_category') }}</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('backend.holidays') }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('backend.day') }}</th>
                                        <th>{{ __('backend.month') }}</th>
                                        <th>{{ __('backend.year') }}</th>
                                        <th>{{ __('backend.repeated') }}</th>
                                        <th>{{ __('backend.description') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('backend.day') }}</th>
                                        <th>{{ __('backend.month') }}</th>
                                        <th>{{ __('backend.year') }}</th>
                                        <th>{{ __('backend.repeated') }}</th>
                                        <th>{{ __('backend.description') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($holidays as $holiday)
                                        <tr>
                                            <td>{{ $holiday->id }}</td>
                                            <td>{{ $holiday->day }}</td>
                                            <td>{{ $holiday->month }}</td>
                                            <td>{{ $holiday->year }}</td>
                                            <td>{{ $holiday->repeated == 1 ? "Yes" : 'No' }}</td>
                                            <td>{{ $holiday->description }}</td>
                                            <td>
                                                <a href="{{ route('holidays.edit', $holiday->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $holiday->id }}"><i class="fa fa-trash-o"></i></a>
                                                <!-- Category Delete Modal -->
                                                <div id="{{ $holiday->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ __('backend.delete_category_message') }}</p>
                                                            </div>
                                                            <form method="post" action="{{ route('holidays.destroy', $holiday->id) }}">
                                                                <div class="modal-footer">
                                                                    {{csrf_field()}}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.no') }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection