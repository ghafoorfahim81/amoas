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
                            <h4 class="panel-title">Edit Misc Types</h4>
                        </div>
                        <div class="panel-body">

                            <form method="POST" action="{{ route('misc-types.update', $misc_type->id) }}">

                                {{csrf_field()}}
                                @method('PUT')

                                <div class="form-group {{$errors->has('name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="name">{{ __('Type\'s Name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $misc_type->type }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('Update') }}</button>
                                </div>

                            </form>

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