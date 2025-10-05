@extends('layouts.admin', ['title' => __('backend.role')])

@section('styles')
    {{-- <link href="{{ asset('plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/> --}}
    {{-- <link href="{{ asset('plugins/select2/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
@endsection

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

                <div class="col-md-3">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('Add New Role') }}</h4>
                        </div>
                        <div class="panel-body">

                            <form method="POST" action="{{ route('roles.store') }}">

                                {{csrf_field()}}

                                <div class="form-group {{$errors->has('name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="name">{{ __('Role\'s Name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{-- <div class="form-group {{$errors->has('guard_name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="guard_name">{{ __('Role\'s Guard Name') }}</label>
                                    <input type="text" class="form-control" name="guard_name" value="{{old('guard_name')}}">
                                    @if ($errors->has('guard_name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('guard_name') }}</strong>
                                        </span>
                                    @endif
                                </div> --}}

                                <div class="form-group {{$errors->has('permissions') ? ' has-error' : ''}}">
                                    <label class="control-label" for="repeated">{{ __('Associate Permissions') }}</label>
                                    <select name="permissions[]" multiple size="20" style="height: 100%;" class="form-control" id="permissions">
                                        @foreach($permissions as $perm)
                                            <option value="{{$perm->name}}">{{$perm->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('permissions'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('permissions') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('Create Role') }}</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('All Roles') }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Gaurd') }}</th>
                                        <th>{{ __('Permissions') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Gaurd') }}</th>
                                        <th>{{ __('Permissions') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($roles as $holiday)
                                        <tr>
                                            <td>{{ $holiday->id }}</td>
                                            <td>{{ $holiday->name }}</td>
                                            <td>{{ $holiday->guard_name }}</td>
                                            <td>{{ implode(' | ', optional($holiday->permissions)->pluck('name')->toArray()) }}</td>
                                            <td>
                                                <a href="{{ route('roles.edit', $holiday->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
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
                                                            <form method="post" action="{{ route('roles.destroy', $holiday->id) }}">
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