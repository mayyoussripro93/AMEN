@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('All Employee Evaluation')])

    <style>
        .form-control {
            font-size: 12px;
        }
        .am-links {
            position: absolute;
            margin-left: 5px;
            left: 0;
        }
        table.dataTable tbody th, table.dataTable tbody td {
            white-space: nowrap;
        }
    </style>
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">

                            <div class="job-header">
                                <div class="contentbox" style="overflow: auto;">
                                    <div class="portlet light portlet-fit portlet-datatable bordered" style="position:relative;">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <h6 class="green-color am-sub-title">{{__('All Employee Evaluation')}}</h6>
                                                <ul class="am-links pull-left">
                                                    <li><a href="#" title="{{__('Print')}}"><i class="fa fa-print print_evaluation" aria-hidden="true"></i></a></li>
                                                    <li>
                                                        <form action="{{route('generate.pdf.evaluations')}}" method="post" id="pdf-form1" >
                                                            <input type="hidden" value="" id="pdf-data" name="pdf-data">
                                                            <input type="hidden" value="all" id="pdf-data" name="pdf-data-type">
                                                            @csrf
                                                            <button class="btn-link" type="submit" title="{{__('Download')}}"><i class="fa fa-download down-pdf" aria-hidden="true"></i></button>
                                                        </form>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-container">
                                                <form method="post" role="form" id="datatable-search-form">

                                                    <table class="table table-striped table-bordered table-hover" id="EvaluationDatatableAjax">
                                                        <thead>
                                                        <tr role="row" class="filter">
                                                            <td>
                                                                <input type="text" class="form-control" name="date" id="date_input" autocomplete="off" placeholder="{{__('Date')}}">
                                                            </td>

                                                            <td style="min-width: 90px;"> {!! Form::select('project_id', ['' => __('The Project')]+ $projects,null, array( 'id'=>'project_id' ,'class' => 'form-control')); !!}</td>

                                                            <td>  <input type="text"  class="form-control" name="name" id="name" autocomplete="off" placeholder="{{__('Name')}}"></td>
                                                            <td>
                                                                {!! Form::select('employee_role_id', ['3'=>__('Safety_consultant'),'4'=>__('Project_consultant'),'5'=>__('Contractor')],null, array('class'=>'form-control', 'id'=>'employee_role_id','placeholder'=>__('Position'))) !!}

                                                            </td>

                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr role="row" class="heading">
                                                            <th scope="col">{{__('Date')}}</th>
                                                            <th scope="col">{{__('The Project')}}</th>

                                                            <th>{{__('Name')}}</th>
                                                            <th>{{__('Position')}}</th>

                                                            <th>{{__('Performance And Achievement')}}</th>
                                                            <th>{{__('Initiative And Invention')}}</th>
                                                            <th>{{__('Collaboration And Career Commitment')}}</th>
                                                            <th>{{__('Participation And Responsibility')}}</th>
                                                            <th>{{__('Supervisory Skills')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="mydata">
                                                        </tbody>
                                                    </table>
                                                </form>
                                                <div id="print_section" style="display: none;">
                                                    <img src="{{ asset('/') }}images/print-header.png">
                                                    <hr>

                                                    <span class="am-label">{{__('Evaluation')}}</span>
                                                    <table id="print_table" class="table table-hover table-striped"></table>
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
    </div>
    @include('includes.footer')
@endsection
@push('scripts')
    <script type="text/javascript">

        $(".print_evaluation").click(function() {
            $('#print_table').empty();
            $('#print_table').append($('.user-info').html());
            $('#print_table').append($('.heading').html());
            $('#print_table').append($('#mydata').html());

            var divToPrint1=$('#print_section').html();

            var newWin=window.open('','Print-Window');

            newWin.document.open();

            newWin.document.write('<html lang="ar" class="rtl" dir="rtl"><head><link rel="stylesheet" href="{{asset('/')}}css/main.css" type="text/css" /> <link rel="stylesheet" href="{{asset('/')}}css/rtl-style.css" type="text/css" /><link rel="stylesheet" href="{{asset('/')}}css/print.css" type="text/css" /></head><body onload="window.print()">'+divToPrint1+'</body></html>');
            newWin.document.close();
        });

        $('#pdf-form1').submit(function(){
            var arr = []

            $("#mydata tr").each(function() {
                if(!isNaN($(this).attr("id")))
                    arr.push($(this).attr("id"));
            });
            $('#pdf-data').val(arr.join());
        });
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
                    url: '{!! route('fetch.data.allstaff.evaluation') !!}',
                    data: function (d) {
                        d.date = $('#date_input').val();
                        d.project_id = $('#project_id').val();
                        d.name = $('#name').val();
                        d.employee_role_id = $('#employee_role_id').val();
                    }
                }, columns: [
                    {data: 'evaluation_date', name: 'evaluation_date'},
                    {data: 'project_id', name: 'project_id'},
                    {data: 'name', name: 'name'},
                    {data: 'role_name', name: 'role_name'},
                    {data: 'performance', name: 'performance'},
                    {data: 'initiative', name: 'initiative'},
                    {data: 'collaboration', name: 'collaboration'},
                    {data: 'participation', name: 'participation'},
                    {data: 'supervisory', name: 'supervisory'},

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


    </script>
@endpush