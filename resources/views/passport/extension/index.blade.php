@extends('layouts.admin', ['title' => 'Passport Extensions'])

@section('styles')
<link href="{{ asset('plugins/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

@endsection

@section('content')

<div class="page-title">
    <h3>Passport Extensions</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
            <li class="active"><a href="{{ route('extensions.index') }}">Passport Extensions</a></li>
        </ol>
    </div>
</div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12" >
                @include('alerts.alert')
                <a class="btn btn-primary" href="{{ route('extensions.create') }}"><i
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
                                    <th>Pass No</th>
                                    <th>Name</th>
                                    <th>Last Name</th>
                                    <th>Post</th>
                                    <th>City</th>
                                    <th>Street</th>
                                    <th>House No</th>
                                    <th>Phone</th>
                                    <th>Members</th>
                                    <th>Family Members</th>
                                    <th>Status</th>
									<th>Reg Date</th>
                                    <th>Registrar</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th searching="false">#</th>
                                    <th>Pass No</th>
                                    <th>Name</th>
                                    <th>Last Name</th>
                                    <th>Post</th>
                                    <th>City</th>
                                    <th>Street</th>
                                    <th>House No</th>
                                    <th>Phone</th>
                                    <th>Members</th>
                                    <th>Family Members</th>
                                    <th>Status</th>
									<th>Reg Date</th>
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
                $(this).html( '<input type="text" class="form-control" Cityholder="Search '+title+'" />' );
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
            ajax: "{!! route('extensions.data') !!}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                },
                {
                    data: 'pass_no',
                    name: 'pass_no'
                },
                {
                    data: 'given_name',
                    name: 'given_name'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'postal_code',
                    name: 'postal_code'
                },
                {
                    data: 'place',
                    name: 'place'
                },
                {
                    data: 'street',
                    name: 'street'
                },
                {
                    data: 'house_no',
                    name: 'house_no',
                },
                {
                    data: 'phone',
                    name: 'phone',
                    visible: false
                },
                {
                    data: 'total_member',
                    name: 'members.name'
                },
                {
                    data: 'members',
                    name: 'members.name',
                    visible: false
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
                    data: 'registrar.full_name',
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