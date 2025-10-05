@extends('layouts.admin', ['title' => __('backend.bookings')])

@section('styles')
<link href="{{ asset('plugins/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

@endsection

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.visa') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.visa') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.bookings')
                <div class="panel panel-white">
                    @php
                        if(app()->isLocale('dr') || app()->isLocale('ps')){
                            setlocale(LC_TIME, 'fa_IR');
                            Carbon\Carbon::setLocale('fa');
                        }
                    @endphp
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.serial_no') }}</th>
                                    <th>{{ __('tazkira.name') }}</th>
                                    <th>{{ __('tazkira.father_name') }}</th>
                                    <th>{{ __('backend.country') }}</th>
                                    <th>{{ __('backend.visa_type') }}</th>
                                    <th>{{ __('backend.occupation') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.serial_no') }}</th>
                                    <th>{{ __('tazkira.name') }}</th>
                                    <th>{{ __('tazkira.father_name') }}</th>
                                    <th>{{ __('backend.country') }}</th>
                                    <th>{{ __('backend.visa_type') }}</th>
                                    <th>{{ __('backend.occupation') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                {{-- @foreach($visaForms as $key => $form)
                                    <tr>
                                        <td>{{ ($visaForms->currentPage() == 0 ? 1 : $visaForms->currentPage() - 1) * $visaForms ->perPage() + $key + 1}}</td>
                                        <td>{{ $form->serial_no }}</td>
                                        <td>{{ ucwords($form->title) }} {{ $form->given_name }} {{ $form->family_name }}</td>
                                        <td>{{ $form->father_name }}</td>
                                        <td>{{ $form->country->name_en }}</td>
                                        <td>{{ $form->type->label_en }}</td>
                                        <td>{{ $form->occupation }}</td>
                                        <td>{{ $form->status }}</td>
                                        <td>{{ $form->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('visa-form.show', $form->id) }}" class="btn btn-primary btn-sm">{{ __('backend.details') }}</a>
                                        </td>
                                    </tr>
                                @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script src="{{ asset('plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/buttons.print.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#xtreme-table').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                    },
                },
            ],
            ajax: "{!! route('visa-form.data') !!}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'serial_no',
                    name: 'serial_no'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'father_name',
                    name: 'father_name'
                },
                {
                    data: 'country.name_en',
                    name: 'country.name_en'
                },
                {
                    data: 'type.label_en',
                    name: 'type.label_en'
                },
                {
                    data: 'occupation',
                    name: 'occupation'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false, 
                    searchable: false
                }
            ]
        });
        
    // table.buttons().container()
    //     .appendTo( $('#options') );

        // new $.fn.dataTable.Buttons( table, {
        //     buttons: [
        //         'copy', 'excel', 'pdf'
        //     ]
        // });

        // table.buttons( 0, null ).container().prependTo(
        //     table.table().container()
        // );

    });
</script>

@endsection