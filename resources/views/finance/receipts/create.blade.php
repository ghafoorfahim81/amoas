@extends('layouts.admin', ['title' => 'Receipts'])

@section('content')

    <div class="page-title">
        <h3>Receipts</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('receipts.dashboard') }}">Receipts</a></li>
                <li class="active">Create</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">Add new Receipts</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" id="form" action="{{route('receipts.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

                            <div class="form-group {{$errors->has('client_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="client_name"><span class="text-danger">*</span> Client Name (required)</label>
                                <input type="text" minlength="2" autofocus class="form-control" required name="client_name" value="{{old('client_name')}}">
                                @if ($errors->has('client_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('client_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('id_card') ? ' has-error' : ''}}">
                                <label class="control-label" for="id_card">IDCard No. (optional)</label>
                                <input type="text" class="form-control" name="id_card" value="{{old('id_card')}}">
                                @if ($errors->has('id_card'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('id_card') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('service_id') ? ' has-error' : ''}}">
                                <label class="control-label" for="name"><span class="text-danger">*</span> Payment Services (required)</label>
                                <select class="form-control" required name="service_id">
									<option value=""></option>
                                    @foreach (\App\Models\Finance\PaymentService::active()->get() as $s)
                                        <option value="{{$s->id}}">{{$s->name}} ({{$s->amount . ' ' . $s->currency}})</option>                                       
                                    @endforeach
                                </select>
                                @if ($errors->has('service_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('service_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">Save and Print</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="panel panel-white">
                    <!-- 4:3 aspect ratio -->
                    <div class="embed-responsive embed-responsive-4by3">
                        <iframe class="embed-responsive-item" src="{{asset('images/loader.gif')}}" allowfullscreen></iframe>
                    </div>
                </div>
            </div> --}}
        </div>
        
    </div>

    <div class="modal fade" id="print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Print the Bill</h4>
                </div>
                <div class="modal-body">
                    <!-- 4:3 aspect ratio -->
                    <div class="embed-responsive embed-responsive-4by3" style="border: 1px solid grey">
                        <iframe id='print-iframe' class="embed-responsive-item" src="{{asset('images/loader.gif')}}" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // this is the id of the form
        $("#form").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            $('#print').modal({
                backdrop: 'static',
                keyboard: false
            });

            var form = $(this);
            var url = form.attr('action');
            
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(res){
                    //reset the form
                    form.trigger('reset');
                    form.trigger('change');

                    // set iframe src
                    iframeUrl = '{{route("receipts.print", "")}}' + '/' + res.receiptNo;
                    $('#print-iframe').attr('src', iframeUrl);
                    
                }
            });

            
        });
    </script>
@endsection