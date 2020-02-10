@extends('admin.layouts.admin_layout')
@section('content')
<style type="text/css">
    .table td, .table th {
        font-size: 12px;
        line-height: 2.42857 !important;
    }
</style>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">{{__('Home')}}</a> <i class="fa fa-circle"></i> </li>
                <li> <span>الحسابات المحذوفة</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">إدارة الحسابات المحذوفة</h3>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject font-red-sunglo sbold uppercase">حسابات محذوفة</span> </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="user-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="user_datatable_ajax">
                                    <thead>
                                        <tr role="row" class="filter">
                                            <td><input type="text" class="form-control" name="id" id="id" autocomplete="off"></td>
                                            <td><input type="text" class="form-control" name="name" id="name" autocomplete="off"></td>
                                            <td><input type="text" class="form-control" name="email" id="email" autocomplete="off"></td>
                                            <td></td>
                                        </tr>
                                        <tr role="row" class="heading">
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table></form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
@endsection
@push('scripts')
<script>
    $(function () {
        var oTable = $('#user_datatable_ajax').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: false,
            "order": [[0, "desc"]],
            /*
             paging: true,
             info: true,
             */
            ajax: {
                url: '{!! route('fetch.data.employees.deleted') !!}',
                data: function (d) {
                    d.id = $('input[name=id]').val();
                    d.name = $('input[name=name]').val();
                    d.email = $('input[name=email]').val();

                }
            }, columns: [
                /*{data: 'id_checkbox', name: 'id_checkbox', orderable: false, searchable: false},*/
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#user-search-form').on('submit', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#id').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#name').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#email').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });

    });


    function restore_employee(id) {
        if (confirm('Are you sure! you want to Restore?')) {
            $.post("{{ route('make.restore.employee') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
console.log(response);
                        if (response == 'ok')
                        {
                            var table = $('#user_datatable_ajax').DataTable();
                            table.row('user_dt_row_' + id).remove().draw(false);

                        } else
                        {
                            alert('Request Failed!');
                        }
                    });
        }
    }
</script>
@endpush