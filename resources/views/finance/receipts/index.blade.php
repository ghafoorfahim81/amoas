@extends('layouts.admin', ['title' => 'Receipts'])

@section('styles')
<link href="{{ asset('plugins/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

@endsection

@section('content')

<div class="page-title">
    <h3>Receipts</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
            <li class="active"><a href="{{ route('receipts.dashboard') }}">Receipts</a></li>
            <li class="active">List</li>
        </ol>
    </div>
</div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12" >
                @include('alerts.alert')
                <a class="btn btn-primary" href="{{ route('receipts.create') }}"><i
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
                                    <th>Transaction No</th>
                                    <th>Receipt No</th>
                                    <th>Date</th>
                                    <th>Client Name</th>
                                    <th>Services</th>
                                    <th>Qauntity</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Bill No</th>
                                    <th>Remarks</th>
									<th>UID</th>
                                    <th>Received By</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th searching="false">#</th>
                                    <th>Transaction No</th>
                                    <th>Receipt No</th>
                                    <th>Date</th>
                                    <th>Client Name</th>
                                    <th>Services</th>
                                    <th>Qauntity</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Bill No</th>
                                    <th>Remarks</th>
									<th>UID</th>
                                    <th>Received By</th>
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
			lengthMenu: [
				[10, 50, 100, 500, 1000],
				[10, 50, 100, 500, 1000],
			],
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                'print',
                'copy',
                'excel',
                'colvis'
            ],
            ajax: "{!! route('receipts.data') !!}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                },
                {
                    data: 'transaction_no',
                    name: 'transaction.id'
                },
                {
                    data: 'receipt_no',
                    name: 'receipt_no'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'client_name',
                    name: 'client_name'
                },
                {
                    data: 'service.name',
                    name: 'service.name'
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                    defaultContent: '-',
                    visible:false
                },
                {
                    data: 'transaction.amount',
                    name: 'transaction.amount',
                    defaultContent: '-'
                },
                {
                    data: 'payment_method',
                    name: 'payment_method',
                    defaultContent: '-'
                },
                {
                    data: 'bill_no',
                    name: 'bill_no',
                    defaultContent: '-',
                    visible:false
                },
                {
                    data: 'remarks',
                    name: 'remarks',
                    defaultContent: '-',
                    visible:false
                },
				{
                    data: 'id_card',
                    name: 'id_card',
                    defaultContent: '-',
                    visible:false
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