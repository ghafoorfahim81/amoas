@extends('layouts.admin', ['title' => 'Receipts'])

@section('content')

    <div class="page-title">
        <h3>Receipts</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('receipts.dashboard') }}">Receipts</a></li>
                <li class="active">Create Online Receipt</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">Add new Online Receipts</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        @include('alerts.alert')
                        <form method="post" id="form" action="{{route('receipts.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

                            <div class="form-group {{$errors->has('client_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="client_name"><span class="text-danger">*</span> Client Name (required)</label>
                                <input type="text" minlength="2" id="client_name" autofocus class="form-control" required name="client_name" value="{{old('client_name')}}">
                                @if ($errors->has('client_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('client_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('bill_no') ? ' has-error' : ''}}">
                                <label class="control-label" for="bill_no">Bill No. of online receipt</label>
                                <input type="number" class="form-control" name="bill_no" value="{{old('bill_no') ?? (isset($latestReceipt->bill_no) ? $latestReceipt->bill_no + 1 : 1)}}">
                                @if ($errors->has('bill_no'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('bill_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('service_id') ? ' has-error' : ''}}">
                                <label class="control-label" for="name"><span class="text-danger">*</span> Payment Services (required)</label>
                                <select class="form-control" required name="service_id">
									<option value=""></option>
                                    @foreach (\App\Models\Finance\PaymentService::active()->get() as $s)
                                        <option value="{{$s->id}}"> ({{$s->amount . ' ' . $s->currency}}) {{$s->name}}</option>                                        
                                    @endforeach
                                </select>
                                @if ($errors->has('service_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('service_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('quantity') ? ' has-error' : ''}}">
                                <label class="control-label" for="quantity"><span class="text-danger">*</span> Quantity (required)</label>
                                <input type="number" class="form-control" name="quantity" value="{{old('quantity') ?? 1}}">
                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('amount') ? ' has-error' : ''}}">
                                <label class="control-label" for="amount">
                                    Paid Amount (<input type="checkbox" name="amount_check" {{ old('amount_check') == 'on' ? 'checked' : null}} id="amount-enable"> enable custom amount)
                                </label>
                                <input type="number" {{ old('amount_check') == 'on' ? null : 'disabled'}} class="form-control" id="amount" name="amount" value="{{old('amount')}}">
                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('remarks') ? ' has-error' : ''}}">
                                <label class="control-label" for="remarks">Remarks</label>
                                <textarea name="remarks" rows="2" class="form-control">{{old('remarks')}}</textarea>
                                @if ($errors->has('remarks'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('remarks') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

@endsection

@section('scripts')
    <script>
        // this is the id of the form
        $("#amount-enable").click(function(e) {
            var amount = $("#amount");
            if(amount.is(':disabled')){
                amount.prop('disabled', false);
            }else{
                amount.prop('disabled', true);
            }
        });
    </script>
@endsection