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
                <li> <a href="{{route('edit.project',['id'=> $project->id])}}">{{$project->name}}</a> <i class="fa fa-circle"></i> </li>
                <li> <span>{{__('Evaluation')}}</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">{{__('Manage Evaluations')}}</h3>

        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject font-red-sunglo sbold uppercase">{{__('View Evaluations')}}</span> </div>
                        <div class="actions"> <a href="{{ route('create.evaluation',['project_id'=>$project_id]) }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> {{__('Add New Evaluation')}}</a> </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="datatable-search-form">
                                <input type="hidden" name="project_id" id="project_id" value="{{$project_id}}">
                                <table class="table table-striped table-bordered table-hover" id="EvaluationDatatableAjax">
                                    <thead>
                                    <tr role="row" class="filter">
                                        <td>
                                            <input type="text" class="form-control" name="date" id="date_input" autocomplete="off" placeholder="{{__('Date')}}">
                                        </td>
                                        <td>  <input type="text"  class="form-control" name="name" id="name" autocomplete="off" placeholder="{{__('Name')}}"></td>
                                        <td>
                                            {!! Form::select('employee_role_id', ['3'=>__('Safety_consultant'),'4'=>__('Project_consultant'),'5'=>__('Contractor')],null, array('class'=>'form-control', 'id'=>'employee_role_id','placeholder'=>__('Position'))) !!}

                                        </td>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr role="row" class="heading">
                                        <th scope="col" width="80px">{{__('Date')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Position')}}</th>

                                        <th width="10%">{{__('Performance And Achievement')}}</th>
                                        <th width="10%">{{__('Initiative And Invention')}}</th>
                                        <th width="10%">{{__('Collaboration And Career Commitment')}}</th>
                                        <th width="10%">{{__('Participation And Responsibility')}}</th>
                                        <th width="10%">{{__('Supervisory Skills')}}</th>
                                        <th width="10%"></th>
                                    </tr>
                                    </thead>

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

        ///////////////////////////////////////////////////////////////////////
        $(function () {


            var oTable = $('#EvaluationDatatableAjax').DataTable({
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
                    url: '{!! route('fetch.admin.data.evaluations') !!}',
                    data: function (d) {
                        d.date = $('#date_input').val();
                        d.project_id = $('#project_id').val();
                        d.name = $('#name').val();
                        d.employee_role_id = $('#employee_role_id').val();
                    }
                }, columns: [
                    {data: 'evaluation_date', name: 'evaluation_date'},
                    {data: 'name', name: 'name'},
                    {data: 'role_name', name: 'role_name'},
                    {data: 'performance', name: 'performance'},
                    {data: 'initiative', name: 'initiative'},
                    {data: 'collaboration', name: 'collaboration'},
                    {data: 'participation', name: 'participation'},
                    {data: 'supervisory', name: 'supervisory'},
                    {data: 'action', name: 'action'},
                ],
                "language": {
                    "lengthMenu": "عدد العناصر بالصفحة _MENU_ عنصر",
                    "zeroRecords": "لا يوجد نتائج",
                    "info": "عرض _PAGE_ من _PAGES_ صفحة",
                    "infoEmpty": "لا يوجد نتائج مطابقة",
                    "infoFiltered": "(تم البحث في إجمالي _MAX_ سجلات)"
                }
            });

            $('#date_input').daterangepicker({
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


            $('#project_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#employee_role_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#name').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });

        function deleteEvaluation(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post("{{ route('delete.evaluation') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#EvaluationDatatableAjax').DataTable();
                            table.row('evaluationDtRow' + id).remove().draw(false);
                        } else
                        {
                            alert('Request Failed!');
                        }
                    });
            }
        }
    </script>
@endpush