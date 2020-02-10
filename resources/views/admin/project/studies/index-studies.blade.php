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
                <li> <span>{{__('Studies')}}</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">{{__('Manage Studies')}}</h3>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">{{__('Studies')}}</span> </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="datatable-search-form">
                                <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}">
                                <table class="table table-striped table-bordered table-hover" id="ProjectDatatableAjax">
                                    <thead>
                                    <tr role="row" class="filter">
                                        <td>
                                            <input type="text" class="form-control" name="date" id="date_input" autocomplete="off" placeholder="{{__('Date')}}">

                                        </td>
                                        <td></td>

                                        <td>
                                            {!! Form::select('title', ['Fire and Alarm'=>__('Fire and Alarm'),'Evacuation and Rescue'=>__('Evacuation and Rescue'),'Surrounding Environment'=>__('Surrounding Environment'),'Dangerous Areas'=>__('Dangerous Areas')],null, array('class'=>'form-control', 'id'=>'title','placeholder'=>__('Study Type'))) !!}
                                        </td>


                                        <td></td>



                                    </tr>
                                    <tr role="row" class="heading">
                                        <th scope="col">{{__('Date')}}</th>
                                        <th scope="col">{{__('Project_consultant')}}</th>
                                        <th scope="col">{{__('Type')}}</th>
                                        <th scope="col"></th>

                                    </tr>
                                    </thead>
                                    <tbody>
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

        ///////////////////////////////////////////////////////////////////////
        $(function () {


            var oTable = $('#ProjectDatatableAjax').DataTable({
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
                    url: '{!! route('fetch.admin.data.studies') !!}',
                    data: function (d) {
                        d.name = $('#name').val();
                        d.date = $('#date_input').val();
                        d.title = $('#title').val();
                        d.project_id = $('#project_id').val();

                    }
                }, columns: [
                    {data: 'created_at', name: 'created_at'},
                    {data: 'name', name: 'name'},
                    {data: 'title', name: 'title'},
                    {data: 'action', name: 'action'}
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
            $('#datatable-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#name').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });

            $('#title').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });

        });
        function deleteStudy(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post("{{ route('delete.studies') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#ProjectDatatableAjax').DataTable();
                            table.row('study_dt_row_' + id).remove().draw(false);
                        } else
                        {
                            alert('Request Failed!');
                        }
                    });
            }
        }
    </script>
@endpush