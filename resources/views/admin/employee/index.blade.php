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
                <li> <span>{{__('Management Accounts')}}</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">{{__('Manage Employees')}}</h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">{{__('Management Accounts')}}</span> </div>
                        <div class="actions">
                            <a href="{{ route('create.employee') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> {{__('Add New Account')}}</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="user-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="user_datatable_ajax">
                                    <thead>
                                        <tr role="row" class="filter">                  
                                            <td><input type="text" class="form-control" name="id" id="id" autocomplete="off"></td>
                                            <td> {!! Form::select('employee_role_id',['' => __('Position')] +$roles, null, array('class' => 'form-control','id'=>'employee_role_id')) !!}</td>
                                            <td><input type="text" class="form-control" name="name" id="name" autocomplete="off"></td>
                                            <td><input type="text" class="form-control" name="email" id="email" autocomplete="off"></td>
                                            <td>  {!! Form::select('delete_request', ['yes'=>__('Yes'),'no'=>__('No')],null, array('class'=>'form-control', 'id'=>'delete_request','placeholder'=>__('Delete Request'))) !!}</td>
                                            <td></td>
                                        </tr>
                                        <tr role="row" class="heading"> 
                                            <th>Id</th>
                                            <th>Position</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>{{__('Delete Request')}}</th>
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
                url: '{!! route('fetch.data.employees') !!}',
                data: function (d) {
                    d.id = $('input[name=id]').val();
                    d.name = $('input[name=name]').val();
                    d.email = $('input[name=email]').val();
                    d.delete_request = $('#delete_request').val();
                    d.employee_role_id = $('#employee_role_id').val();
                }
            }, columns: [
                /*{data: 'id_checkbox', name: 'id_checkbox', orderable: false, searchable: false},*/
                {data: 'id', name: 'id'},
                {data: 'employee_role_id', name: 'employee_role_id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'delete_request', name: 'delete_request'},
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
        $('#delete_request').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#employee_role_id').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
    });

    function make_active(id) {
        $.post("{{ route('make.active.employee') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        $('#onclick_active_' + id).attr("onclick", "make_not_active(" + id + ")");
                        $('#onclick_active_' + id).html("<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>Make InActive");
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
    }
    function make_not_active(id) {
        $.post("{{ route('make.not.active.employee') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        $('#onclick_active_' + id).attr("onclick", "make_active(" + id + ")");
                        $('#onclick_active_' + id).html("<i class=\"fa fa-square-o\" aria-hidden=\"true\"></i>Make Active");
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
    }
    function delete_employee(id) {
        if (confirm('Are you sure! you want to delete?')) {
            $.post("{{ route('delete.employee') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {

                        if (response == 'ok')
                        {
                            var table = $('#user_datatable_ajax').DataTable();
                            table.row('user_dt_row_' + id).remove().draw(false);

                        } else
                        {
                            alert(response);
                        }
                    });
        }
    }
</script> 
@endpush