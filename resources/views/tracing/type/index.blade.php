@extends('layouts.admin', ['title' => 'Tracing types'])

@section('content')

    <div class="page-title">
        <h3>Traceable Documents</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('misc.index') }}">Miscellaneous</a></li>
                <li class="active">Misc Types</li>
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
                            <h4 class="panel-title">Create Misc Types</h4>
                        </div>
                        <div class="panel-body">

                            <form method="POST" action="{{ route('misc-types.store') }}">

                                {{csrf_field()}}

                                <div class="form-group {{$errors->has('name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="name">{{ __(' Name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">Create</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">All Misc Types</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($types as $type)
                                        <tr>
                                            <td>{{ $type->id }}</td>
                                            <td>{{ $type->type }}</td>
                                            <td>
                                                <a href="{{ route('misc-types.edit', $type->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                
                                                @if (!$type->miscs()->exists())
                                                    <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $type->id }}"><i class="fa fa-trash-o"></i></a>
                                                    <!-- Category Delete Modal -->
                                                    <div id="{{ $type->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
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
                                                                <form method="post" action="{{ route('misc-types.destroy', $type->id) }}">
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