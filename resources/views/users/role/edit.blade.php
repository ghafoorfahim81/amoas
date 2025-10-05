@extends('layouts.admin', ['title' => __('backend.role')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.holidays') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('roles.index') }}">{{ __('backend.holidays') }}</a></li>
                <li class="active">{{ __('Edit Role') }}</li>
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
                            <h4 class="panel-title">{{ __('Edit Role') }}</h4>
                        </div>
                        <div class="panel-body">

                            <form method="POST" action="{{ route('roles.update', $role->id) }}">

                                {{csrf_field()}}
                                @method('PUT')

                                <div class="form-group {{$errors->has('name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="name">{{ __('Role\'s Name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $role->name }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('permissions') ? ' has-error' : ''}}">
                                    <label class="control-label" for="repeated">{{ __('Associate Permissions') }}</label>
                                    <select name="permissions[]" multiple size="20" style="height: 100%;" class="form-control" id="permissions">
                                        @foreach($permissions as $perm)
                                            <option value="{{$perm->name}}" {{ in_array($perm->name, optional($role->permissions)->pluck('name')->toArray()) ? 'selected' : null }}>
                                                {{$perm->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('permissions'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('permissions') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('Update Role') }}</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('Users has this role') }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Primary Role') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Primary Role') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $idsOfAssignedUsers = optional($role->users)->pluck('id')->toArray();
                                        @endphp
                                    @foreach($users as $holiday)
                                        <tr>
                                            <td>{{ $holiday->first_name }} {{ $holiday->last_name }}</td>
                                            <td>{{ $holiday->email }}</td>
                                            <td>{{ optional($holiday->role)->name }}</td>
                                            <td>
                                                @if (in_array($holiday->id, $idsOfAssignedUsers))
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
                                                                    <p>{{ __('Are you sure want to revoke the from this user?') }}</p>
                                                                </div>
                                                                <form method="post" action="{{ route('roles.revoke', $role->id) }}">
                                                                    <div class="modal-footer">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <input type="hidden" name="user_id" value="{{$holiday->id}}">
                                                                        <button type="submit" class="btn btn-danger">{{ __('Yes, Revoke role') }}</button>
                                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.no') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                @else
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#{{ $holiday->id }}"><i class="fa fa-check"></i></a>
                                                    <!-- Category Assign Modal -->
                                                    <div id="{{ $holiday->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ __('Are you sure want to assign the role to this user?') }}</p>
                                                                </div>
                                                                <form method="post" action="{{ route('roles.assign', $role->id) }}">
                                                                    <div class="modal-footer">
                                                                        {{csrf_field()}}
                                                                        <input type="hidden" name="user_id" value="{{$holiday->id}}">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('backend.no') }}</button>
                                                                        <button type="submit" class="btn btn-primary">{{ __('backend.yes') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                @endif
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


@section('scripts')

<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#xtreme-table').DataTable();

    });
</script>

@endsection