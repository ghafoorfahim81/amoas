@extends('layouts.admin', ['title' => 'Postal Packages'])

@section('content')

    <div class="page-title">
        <h3>Postal Packages</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('misc.index') }}">Postal Packages</a></li>
                <li class="active">Edit</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.alert')
                <a class="btn btn-danger btn-lg" data-toggle="modal" data-target="#reject-dg"><i
                    class="fa fa-times"></i>&nbsp;&nbsp;Reject Post</a>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">Edit Postal Packages</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('postal.update', $postal->id)}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            @method('PUT')

                            <div class="col-md-3 form-group {{$errors->has('name') ? ' has-error' : ''}}">
                                <label class="control-label" for="name"><span class="text-danger">*</span> Applicant full name</label>
                                <input type="text" class="form-control" name="name" value="{{$postal->name}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('post') ? ' has-error' : ''}}">
                                <label class="control-label" for="post">Postal Code</label>
                                <input type="text" class="form-control" name="post" value="{{$postal->post}}">
                                @if ($errors->has('post'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('post') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('place') ? ' has-error' : ''}}">
                                <label class="control-label" for="place">City</label>
                                <input type="text" class="form-control" name="place" value="{{$postal->place}}">
                                @if ($errors->has('place'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('place') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('address') ? ' has-error' : ''}}">
                                <label class="control-label" for="address"><span class="text-danger">*</span>Track Number</label>
                                <input type="text" class="form-control" name="address" value="{{$postal->address}}">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('street') ? ' has-error' : ''}}">
                                <label class="control-label" for="street">Street</label>
                                <input type="text" class="form-control" name="street" value="{{$postal->street}}">
                                @if ($errors->has('street'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('street') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('house_no') ? ' has-error' : ''}}">
                                <label class="control-label" for="house_no">House Number</label>
                                <input type="text" class="form-control" name="house_no" value="{{$postal->house_no}}">
                                @if ($errors->has('house_no'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('house_no') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('doc_price') ? ' has-error' : ''}}">
                                <label class="control-label" for="doc_price">Document Price (€)</label>
                                <input type="number" step="any" class="form-control" name="doc_price" value="{{$postal->doc_price}}">
                                @if ($errors->has('doc_price'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('doc_price') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('post_price') ? ' has-error' : ''}}">
                                <label class="control-label" for="post_price">Post Price (€)</label>
                                <input type="number" step="any" class="form-control" name="post_price" value="{{$postal->post_price}}">
                                @if ($errors->has('post_price'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('post_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3 form-group {{$errors->has('phone_no') ? ' has-error' : ''}}">
                                <label class="control-label" for="phone_no">Phone Number</label>
                                <input type="text" class="form-control" name="phone_no" value="{{$postal->phone}}">
                                @if ($errors->has('phone_no'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone_no') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('email') ? ' has-error' : ''}}">
                                <label class="control-label" for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="{{$postal->email}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('date') ? ' has-error' : ''}}">
                                <label class="control-label" for="date">Date</label>
                                <input type="date" value="{{$postal->date}}" class="form-control" name="date">
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 form-group {{$errors->has('status') ? ' has-error' : ''}}">
                                <label class="control-label" for="status">Status 
                                    (<input type="checkbox" checked name="send_status_email"> Send Email to Applicant)
                                </label>
                                {{-- <input type="text" class="form-control" name="status" value="{{old('status')}}"> --}}
                                <select class="form-control" name="status">
                                    
                                    <option value="Label Created" {{$postal->status == 'Label Created' ? 'selected' : '' }}>Label Created</option>
                                    <option value="Shipped" {{$postal->status == 'Shipped' ? 'selected': ''}}>Shipped</option>
                                    <option value="Delivered" {{$postal->status == 'Delivered' ? 'selected': ''}}>Delivered</option>
                                    <option value="Returned" {{$postal->status == 'Returned' ? 'selected': ''}}>Returned</option>
                                    <option value="Rejected" {{$postal->status == 'Rejected' ? 'selected': ''}}>Rejected</option>
                                    <option value="Data Entry" {{$postal->status == 'Data Entry' ? 'selected': ''}}>Data Entry</option>
                                    <option value="Waiting" {{$postal->status == 'Waiting' ? 'selected': ''}}>Waiting</option>
                                </select>
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <hr>
                                @php
                                    $checklists = $postal->checklists()->pluck('status','id')->toArray();
                                    $deactiveChecklists = array_filter($checklists, function($val){ return $val == 0 ;});
                                    $deactiveChecklists = $deactiveChecklists ? \App\Models\Post\PostCheckList::find(array_keys($deactiveChecklists)) : [];
                                @endphp
                                <div class="row">
                                    @foreach (\App\Models\Post\PostCheckList::active()->get() as $cl)
                                        <div class="col-md-3">
                                            <input type="checkbox" name="checklist[{{$cl->id}}]" {{ !in_array($cl->id, array_keys($checklists)) ? null : 'checked'}}> 
                                            {{$cl->name}}
                                        </div>
                                    @endforeach
                                    @foreach ($deactiveChecklists as $dcl)
                                        <div class="col-md-3">
                                            <input type="checkbox" name="checklist[{{$dcl->id}}]" checked> 
                                            {{$dcl->name}}
                                        </div>
                                    @endforeach
                                    <div class="col-md-3">
                                        <input type="text" name="others" value="{{old('others')}}" style="width: 100%" placeholder="Others... if more, saparete with (-)dash.">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <hr>
                                <h3>List of Deliverable Documents</h3>
                            </div>

                            <div class="col-md-4">
                            @php
                                $count = $postal->deliverables()->count();
                            @endphp
                            @foreach ($postal->deliverables as $counter => $d)
                                @php
                                    $counter++
                                @endphp
                                <input type="hidden" name="id{{$counter}}" value="{{$d->id}}">
                                <div class="form-group {{$errors->has('name'. $counter) ? ' has-error' : ''}}">
                                    <label class="control-label" for="name">Name {{$counter}}</label>
                                    <input type="text" class="form-control" name="name{{$counter}}" value="{{$d->name}}">
                                    @if ($errors->has('name'. $counter))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name'. $counter) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endforeach

                            @foreach (range(++$count,8) as $counter)
                                <div class="form-group {{$errors->has('name'. $counter) ? ' has-error' : ''}}">
                                    <label class="control-label" for="name">Name {{$counter}}</label>
                                    <input type="text" class="form-control" name="name{{$counter}}" value="{{old('name'. $counter)}}">
                                    @if ($errors->has('name'. $counter))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name'. $counter) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                            
                            </div>
                            <div class="col-md-8 form-group {{$errors->has('description') ? ' has-error' : ''}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label" for="description">Remarks</label>
                                        <textarea class="form-control" name="description" rows="19">{{$postal->description}}</textarea>
                                        @if ($errors->has('descriptions'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('descriptions') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        @foreach ($logs as $index => $log)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>{{$log->causer->first_name .' '. $log->causer->last_name .' '. $log->description}} on {{$log->created_at}}</h4>
                                                    <ul>
                                                        @if ($log->properties->get('attributes'))
                                                            @foreach ($log->properties->get('attributes') as $key => $value)
                                                                <li>{{$key}}: {{$value}}</li>
                                                            @endforeach
                                                        @endif

                                                        @php
                                                            // get the curent CL and Deliverables
                                                            $newCL = $log->getExtraProperty('checklists');
                                                            $deliverables = $log->getExtraProperty('deliverables');

                                                            // get old CL and Deliverables
                                                            $nextLog = $logs->get(++$index);
                                                            $oldCL = !$nextLog ? [] : $nextLog->getExtraProperty('checklists');
                                                            $oldDel = !$nextLog ? [] : $nextLog->getExtraProperty('deliverables');

                                                            $diffCL = array_diff($newCL ?? [], $oldCL ?? []);
                                                            $diffDel = array_diff($deliverables ?? [], $oldDel ?? []);
                                                        @endphp
                                                        
                                                        <li> Checklists:
                                                            <ol>
                                                                @foreach ((array) $diffCL as $checklist)
                                                                    <li>{{$checklist}}</li>
                                                                @endforeach
                                                            </ol>
                                                            
                                                        </li>
                                                        <li> Deliverables:
                                                            <ol>
                                                                @foreach ((array) $diffDel as $deliverable)
                                                                    <li>{{$deliverable}}</li>
                                                                @endforeach
                                                            </ol>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4>Old Data</h4>
                                                    <ul>
                                                        @if ($log->properties->get('old'))
                                                            @foreach ($log->properties->get('old') as $key => $value)
                                                                <li>{{$key}}: {{$value}}</li>
                                                            @endforeach
                                                        @endif
                                                                
                                                        <li> Checklists:
                                                            <ol>
                                                                @foreach (array_diff($oldCL ?? [], $newCL ?? []) as $oldChecklist)
                                                                    <li>{{$oldChecklist}}</li>
                                                                @endforeach
                                                            </ol>
                                                        </li>
                                                        <li> Deliverables:
                                                            <ol>
                                                                @foreach (array_diff($oldDel ?? [], $deliverables ?? []) as $oldDeliverable)
                                                                    <li>{{$oldDeliverable}}</li>
                                                                @endforeach
                                                            </ol>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group  text-right">
                                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="reject-dg" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false">
            <div class="modal-dialog">
                <form method="post" action="{{ route('postal.reject', $postal->id) }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Rejecting Postal Package!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Reason to Reject package</label>
                                <small>The below text will send directly to user's email address.</small>
                                <textarea name="reason" required class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">{{ __('backend.update') }}</button>
                            <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{ __('backend.close') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection