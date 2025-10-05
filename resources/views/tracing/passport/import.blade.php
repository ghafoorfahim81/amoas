@extends('layouts.admin', ['title' => __('backend.bookings')])

@section('content')

    <div class="page-title">
        <h3>Traceable Documents</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('passport.index') }}">Passport</a></li>
                <li class="active">Import Excel</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12" >
                @include('alerts.users')
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-8" id="options">
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" id="importForm" action="{{route('passport.store')}}" onsubmit="importForm()" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="import">
                            <div class="col-md-12 form-group {{$errors->has('department_id') ? ' has-error' : ''}}">
                                <label class="control-label" for="department_id">{{ __('app.department') }}</label>
                                <select class="form-control" name="department_id">
                                    <option>{{ __('backend.select_one') }}</option>
                                    @foreach(\App\Department::where('continent', 'europe')->get() as $department)
                                        @if(old('department_id') == $department->id)
                                            <option value="{{$department->id}}" selected>{{$department->name_en}}</option>
                                        @else
                                            <option value="{{$department->id}}">{{$department->name_en}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('department_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('department_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group {{$errors->has('is_public') ? ' has-error' : ''}}">
                                <label class="control-label" for="is_active">Is public? (<small>Set visiblity while searching by clients</small>)</label>
                                <select class="form-control" name="is_public">
                                    <option value="1">Visible</option>
                                    <option value="0">Hide from clients</option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group {{$errors->has('note') ? ' has-error' : ''}}">
                                <label class="control-label" for="note">Note (<small>a short note to client</small>)</label>
                                <input type="text" class="form-control" name="note" value="{{old('note')}}">
                                @if ($errors->has('note'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('note') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group {{$errors->has('excel_file') ? ' has-error' : ''}}">
                                <label for="excel_file" class="control-label">Select Excel file</label>
                                <input type="file" id="excel_file" name="excel_file">
                                @if ($errors->has('excel_file'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('excel_file') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group  text-right">
                                <button type="submit" class="btn btn-primary btn-lg">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{asset('images/loader.gif')}}" alt="" srcset="">
                <h2>{{ __('app.loadingPlzWait') }}</h2>
                {{-- <div class="progress">
                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span></span>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function() {

    });

    function importForm()
    {
        // event.preventDefault();
        $('#loadingModal').modal({backdrop: 'static', keyboard: false, show: true});

        window.onbeforeunload = function(){
            alert('You can\'t leave, the operation need time to perform so be patient.')
        }
        // var timer = setInterval(function(){ progress_bar_process(timer); },1500);
    }

    function progress_bar_process(timer)
    {
        $.ajax({
            url:"{{route('passport.import-progress')}}",
            method:"GET",
            success:function(data){
                
                percentage = 0;
                if(data.importedTotalCount <= 0){
                    $('.progress-bar').html('<span style="color:black">' + data.status + '</span>');
                    return;
                }

                percentage = parseInt(data.importedCount * 100 / data.importedTotalCount);

                $('.progress-bar').css('width', percentage + '%');
                $('.progress-bar').html('<span >' + percentage + '% ' + data.status + ' (' + data.importedCount + '/' + data.importedTotalCount + ')</span>');
                
                if(percentage > 100){
                    clearInterval(timer);
                    $('.progress').html('<span style="color:black">Importing has been finish. This page will reload automatically.</span>');
                    return;
                }
            }
        })
    }
</script>

@endsection