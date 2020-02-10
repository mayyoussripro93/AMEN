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
                <li> <a href="{{ route('list.projects') }}">{{__('Projects')}}</a> <i class="fa fa-circle"></i> </li>
                <li> <span>{{__('Violations')}}</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">{{__('Manage Violations')}}</h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject font-red-sunglo sbold uppercase">{{__('Violations')}}</span> </div>
{{--                        <div class="actions"> <a href="" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> {{__('Add Violation')}}</a> </div>--}}

                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="datatable-search-form">

                                <table class="table table-striped table-bordered table-hover" id="violationDatatableAjax">
                                    <thead>
                                    <tr role="row" class="filter">
                                        <td>
                                            <input type="text" class="form-control" name="date_txt" id="date_date" autocomplete="off" placeholder="{{__('Date')}}">

                                        </td>
                                        <td>{!! Form::select('project_id', ['' => 'Select Project']+$projects, $project_id, array('id'=>'project_id', 'class'=>'form-control')) !!}</td>

                                        <td>
                                            {!! Form::select('danger_cat_id', [''=>__('Select Danger')]+$danger_cat,null , array('class'=>'form-control', 'id'=>'danger_cat_id')) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('danger_status', ['High'=>__('High'),'Medium'=>__('Medium'),'Low'=>__('Low')],null, array('class'=>'form-control', 'id'=>'danger_status','placeholder'=>__('Danger Level'))) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('payment_status', ['1'=>__('Paid'),'Null'=>__('Not Paid')],null, array('class'=>'form-control', 'id'=>'payment_status','placeholder'=>__('Payment Status'))) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('danger_status_last', ['removed'=>__('removed'),'exist'=>__('exist'),'work on'=>__('work on')],null, array('class'=>'form-control', 'id'=>'danger_status_last','placeholder'=>__('Violation Status'))) !!}
                                        </td>
                                        {{--                                                    <td>--}}
                                        {{--                                                        {!! Form::select('objection_status', ['1'=>__('Yes'),'null' =>__('No')],null, array('class'=>'form-control', 'id'=>'objection_status','placeholder'=>__('Objection Status'))) !!}--}}
                                        {{--                                                    </td>--}}
                                        <td></td>

                                    </tr>

                                    <tr role="row" class="heading">
                                        <th scope="col" style="max-width: 75px !important;">{{__('Date')}}</th>
                                        <th scope="col">{{__('Project')}}</th>
                                        <th scope="col" style="max-width: 75px !important;">{{__('Danger Category')}}</th>
                                        <th scope="col">{{__('Danger Level')}}</th>
                                        <th scope="col">{{__('Paid')}}</th>
                                        <th scope="col">{{__('Violation Status')}}</th>
                                        {{--                                                    <th scope="col">{{__('Objection Status')}}</th>--}}
                                        <th scope="col">{{__('Action')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody id="mydata">
                                    </tbody>
                                </table>
                            </form>
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
        <script type="text/javascript">
            $('#project_id').trigger('change');
            ///////////////////////////////////////////////////////////////////////
            $(function () {
                var oTable = $('#violationDatatableAjax').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    searching: false,
                    /*
                     "order": [[1, "asc"]],
                     paging: true,
                     info: true,
                     */
                    ajax: {
                        url: '{!! route('fetch.admin.data.violations') !!}',
                        data: function (d) {
                            d.project_id = $('#project_id').val();
                            d.date_txt = $('#date_date').val();
                            d.danger_cat_id = $('#danger_cat_id').val();
                            d.danger_status = $('#danger_status').val();
                            d.payment_status = $('#payment_status').val();
                            d.danger_status_last = $('#danger_status_last').val();
                            // d.objection_status=$('#objection_status').val();
                        }
                    }, columns: [
                        {data: 'gregorian_date', name: 'gregorian_date'},
                        {data: 'project_id', name: 'project_id'},
                        {data: 'danger_cat_id', name: 'danger_cat_id'},
                        {data: 'danger_status', name: 'danger_status'},
                        {data: 'payment_status', name: 'payment_status'},
                        {data: 'danger_status_last', name: 'danger_status_last'},
                        {data: 'action', name: 'action'},

                    ],
                    "language": {
                        "lengthMenu": "عدد العناصر بالصفحة _MENU_ عنصر",
                        "zeroRecords": "لا يوجد نتائج",
                        "info": "عرض _PAGE_ من _PAGES_ صفحة",
                        "infoEmpty": "لا يوجد نتائج مطابقة",
                        "infoFiltered": "(تم البحث في إجمالي _MAX_ سجلات)"
                    },
                    "initComplete": function (settings, json) {

                    }
                });
                $('#date_date').daterangepicker({
                    // "singleDatePicker": true,
                    // "timePicker": true,
                    // "timePicker24Hour": true,
                    "autoUpdateInput": false,
                    "locale": {
                        "format": "YYYY-MM-DD",
                        "applyLabel": "Apply",
                        "cancelLabel": "Cancel",
                        "fromLabel": "From",
                        "toLabel": "To",
                        "customRangeLabel": "Custom",
                        "weekLabel": "W",
                        "daysOfWeek": [
                            "Su",
                            "Mo",
                            "Tu",
                            "We",
                            "Th",
                            "Fr",
                            "Sa"
                        ],
                        "monthNames": [
                            "January",
                            "February",
                            "March",
                            "April",
                            "May",
                            "June",
                            "July",
                            "August",
                            "September",
                            "October",
                            "November",
                            "December"
                        ],
                        "firstDay": 1
                    },
                }).on('apply.daterangepicker', function(ev, picker) {

                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));

                    oTable.draw();
                    event.preventDefault();
                    // console.log(picker.startDate.format('YYYY-DD'));
                    // console.log(picker.endDate.format('YYYY-MM-DD'));
                });
                $('#datatable-search-form').on('submit', function (e) {
                    oTable.draw();
                    e.preventDefault();
                });
                $('#danger_cat_id').on('change', function (e) {
                    oTable.draw();
                    e.preventDefault();
                });
                $('#danger_status').on('change', function (e) {
                    oTable.draw();
                    e.preventDefault();
                });
                $('#payment_status').on('change', function (e) {
                    oTable.draw();
                    e.preventDefault();
                });
                $('#danger_status_last').on('change', function (e) {
                    oTable.draw();
                    e.preventDefault();
                });
                $('#project_id').on('change', function (e) {
                    oTable.draw();
                    e.preventDefault();
                });
            });
            function deleteViolation(id) {
                var msg = 'Are you sure?';
                if (confirm(msg)) {
                    $.post("{{ route('delete.violation') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                        .done(function (response) {
                            if (response == 'ok')
                            {
                                var table = $('#violationDatatableAjax').DataTable();
                                table.row('violationDtRow' + id).remove().draw(false);
                            } else
                            {
                                alert('Request Failed!');
                            }
                        });
                }
            }
            function deleteObjection(id) {
                var msg = 'Are you sure?';
                if (confirm(msg)) {
                    $.post("{{ route('delete.objection') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                        .done(function (response) {
                            if (response == 'ok')
                            {
                                alert('Request Succeeded!');
                            } else
                            {
                                alert('Request Failed!');
                            }
                        });
                }
            }
        </script>

{{--        violationDtRow--}}
    @endpush