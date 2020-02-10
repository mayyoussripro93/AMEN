@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Project Studies')])

    <style>
        .form-control {
            font-size: 12px;
        }
        .am-links {
            position: absolute;
            margin-left: 5px;
            left: 0;
        }
    </style>
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-md-9 col-sm-8">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-8">
                            @include('projects.inc.project_header')
                            <div class="job-header">
                                <div class="contentbox" style="overflow: auto;">
                                    <div class="portlet light portlet-fit portlet-datatable bordered" style="position:relative;">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <h6 class="green-color am-sub-title">{{__('Project Studies')}} ({{$project->uploads_count}})</h6>

                                            </div>
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
                                                            <td></td>
                                                            <td></td>

                                                        </tr>
                                                        <tr role="row" class="heading">
                                                            <th scope="col">{{__('Date')}}</th>
                                                            <th scope="col">{{__('Project_consultant')}}</th>
                                                            <th scope="col">{{__('Type')}}</th>
                                                            <th scope="col"></th>
                                                            <th scope="col"></th>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
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
                    url: '{!! route('fetch.data.project.studies') !!}',
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
                    {data: 'show', name: 'show'},
                    {data: 'download', name: 'download'},
                    {data: 'delete', name: 'delete'},
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
                $.post("{{ route('front.delete.studies') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
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