@extends('layouts.admin', ['title' => 'Postal Packages'])

@section('styles')
<link href="{{ asset('plugins/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

@endsection

@section('content')

<div class="page-title">
    <h3>Postal Packages</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
            <li class="active"><a href="{{ route('misc.index') }}">Postal Packages</a></li>
        </ol>
    </div>
</div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12" >
                @include('alerts.alert')
                <a class="btn btn-primary" href="{{ route('postal.create') }}"><i
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
                                    <th>DB ID</th>
                                    <th>UID</th>
                                    <th>Name</th>
                                    <th>Booking ID</th>
                                    <th>Postal Code</th>
                                    <th>Place</th>
                                    <th>Track No</th>
                                    <th>Street</th>
                                    <th>House No</th>
                                    <th>Date</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Documents</th>
                                    <th>Doc Price €</th>
                                    <th>Post Price €</th>
                                    <th>Status</th>
                                    <th>Registrar</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th searching="false">#</th>
                                    <th>DB ID</th>
                                    <th>UID</th>
                                    <th>Name</th>
                                    <th>Booking ID</th>
                                    <th>Postal Code</th>
                                    <th>City</th>
                                    <th>Track No</th>
                                    <th>Street</th>
                                    <th>House No</th>
                                    <th>Date</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Documents</th>
                                    <th>Doc Price €</th>
                                    <th>Post Price €</th>
                                    <th>Status</th>
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
            // $(this).html('<textarea class="form-control" rows="2"></textarea>');
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
            ajax: "{!! route('postal.data') !!}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                },
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'uid',
                    name: 'uid'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'booking.serial_no',
                    name: 'booking.serial_no'
                },
                {
                    data: 'post',
                    name: 'post'
                },
                {
                    data: 'place',
                    name: 'place'
                },
                {
                    data: 'address',
                    name: 'address',
                    visible: false
                },
                {
                    data: 'street',
                    name: 'street'
                },
                {
                    data: 'house_no',
                    name: 'house_no',
                    visible: false
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'phone',
                    name: 'phone',
                    visible: false
                },
                {
                    data: 'email',
                    name: 'email',
                    visible: false
                },
                {
                    data: 'documents',
                    name: 'documents'
                },
                {
                    data: 'doc_price',
                    name: 'doc_price'
                },
                {
                    data: 'post_price',
                    name: 'post_price'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'by',
                    name: 'registrar.last_name',
                    visible: false
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