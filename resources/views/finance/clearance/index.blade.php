@extends('layouts.admin', ['title' => 'Clearance'])

@section('styles')
<link href="{{ asset('plugins/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

@endsection

@section('content')

<div class="page-title">
    <h3>Clearance</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
            <li class="active"><a href="{{ route('clearance.dashboard') }}">Clearance</a></li>
            <li class="active">List</li>
        </ol>
    </div>
</div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12" >
                @include('alerts.alert')
                <a class="btn btn-primary" href="{{ route('clearance.create') }}"><i
                    class="fa fa-plus"></i>&nbsp;&nbsp;Create</a>
                {{-- <a class="btn btn-default" href="{{ route('misc-types.index') }}"><i
                    class="fa fa-list-ul"></i>&nbsp;&nbsp;Misc Types</a> --}}
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-8" id="options">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Received Date</th>
                                    <th>Receiver</th>
                                    <th>From</th>
                                    <th>to</th>
                                    <th>Delivered By</th>
                                    <th>Registrar</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th searching="false">#</th>
                                    <th>Amount</th>
                                    <th>Received Date</th>
                                    <th>Receiver</th>
                                    <th>From</th>
                                    <th>to</th>
                                    <th>Delivered By</th>
                                    <th>Registrar</th>
                                    <th searching="false">{{ __('backend.actions') }}</th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script src="{{ asset('plugins/datatables/js/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/colVis.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/excel.datatables.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('#xtreme-table tfoot th').each( function () {
            var title = $(this).text();
            if($(this).attr('searching') != 'false')
                $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
        });

        var table = $('#xtreme-table').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                'print',
                'copy',
                'excel',
                'colvis'
            ],
            ajax: "{!! route('clearance.data') !!}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                },
                {
                    data: 'amount',
                    name: 't.amount'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'receiver.full_name',
                    name: 'receiver.last_name'
                },
                {
                    data: 'clear_from',
                    name: 'clear_from'
                },
                {
                    data: 'clear_to',
                    name: 'clear_to'
                },
                {
                    data: 'deliver.full_name',
                    name: 'deliver.last_name',
                    defaultContent: '-'
                },
                {
                    data: 'registrar.full_name',
                    name: 'registrar.last_name',
                    defaultContent: '-'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "order": []
        });

        // Apply the search
        table.columns().every( function () {
            var that = this;
    
            $( 'input', this.footer() ).on( 'keyup change clear', function () {
                if ( that.search() !== this.value ) {
                    that.search(this.value.replace(/;/g, "|"), true, false)
                        .draw();
                }
            });
        });

    });
</script>

@endsection