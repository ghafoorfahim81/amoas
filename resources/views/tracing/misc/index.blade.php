@extends('layouts.admin', ['title' => 'Traceable Documents'])

@section('styles')
<link href="{{ asset('plugins/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

@endsection

@section('content')

<div class="page-title">
    <h3>Traceable Documents</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
            <li class="active"><a href="{{ route('misc.index') }}">Miscellaneous</a></li>
        </ol>
    </div>
</div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12" >
                @include('alerts.alert')
                <a class="btn btn-primary" href="{{ route('misc.create') }}"><i
                    class="fa fa-plus"></i>&nbsp;&nbsp;Create</a>
                <a class="btn btn-default" href="{{ route('misc-types.index') }}"><i
                    class="fa fa-list-ul"></i>&nbsp;&nbsp;Misc Types</a>
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
                                    <th>UID</th>
                                    <th>Title</th>
                                    <th>Applicant</th>
                                    <th>Booking ID</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Is Public</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th searching="false">#</th>
                                    <th>UID</th>
                                    <th>Title</th>
                                    <th>Booking ID</th>
                                    <th>Applicant</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Is Public</th>
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

<script src="{{ asset('plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/buttons.print.min.js') }}"></script>

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
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                    },
                },
            ],
            ajax: "{!! route('misc.data') !!}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                },
                {
                    data: 'uid',
                    name: 'uid'
                },
                {
                    data: 'type.type',
                    name: 'type.type'
                },
                {
                    data: 'trace.applicant',
                    name: 'trace.applicant'
                },
                {
                    data: 'booking.serial_no',
                    name: 'booking.serial_no'
                },
                {
                    data: 'trace.email',
                    name: 'trace.email'
                },
                {
                    data: 'trace.status',
                    name: 'trace.status'
                },
                {
                    data: 'isPublic',
                    name: 'isPublic'
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