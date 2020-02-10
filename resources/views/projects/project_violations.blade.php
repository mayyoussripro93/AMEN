@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Project Violations')])

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
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    @include('flash::message')

                    <div class="row">
                    @include('includes.employee_dashboard_menu')


                    <!-- Violations List -->
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            @include('projects.inc.project_header')
                            <div class="job-header">
                                <div class="contentbox" style="overflow: auto;">
                                    <div class="portlet light portlet-fit portlet-datatable bordered"
                                         style="position:relative;">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                @php
                                                    $violations_count=\App\Violation::where('objection_status','!=','1')->where('project_id','=',$project->id)->count();
                                                @endphp
                                                <h6 class="green-color am-sub-title">{{__('Project Violations')}} ({{$violations_count}})</h6>
                                                <ul class="am-links pull-left">
                                                    <li><a href="#" title="{{__('Print')}}"><i
                                                                    class="fa fa-print print_violations"
                                                                    aria-hidden="true"></i></a></li>
                                                    <li><form action="{{route('generate.pdf.violations')}}" method="post" id="pdf-form1" >
                                                        <input type="hidden" value="" id="pdf-data" name="pdf-data">
                                                        @csrf
                                                        <button class="btn-link" type="submit" title="{{__('Download')}}"><i class="fa fa-download down-pdf" aria-hidden="true"></i></button>
                                                    </form></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-container">
                                                <form method="post" role="form" id="datatable-search-form">
                                                    <input type="hidden" name="project_id" id="project_id"
                                                           value="{{$project->id}}">
                                                    <table class="table table-striped table-bordered table-hover"
                                                           id="violationDatatableAjax">
                                                        <thead>
                                                        <tr role="row" class="filter">
                                                            <td>
                                                                <input type="text" class="form-control" name="date_txt"
                                                                       id="date_date" autocomplete="off"
                                                                       placeholder="{{__('Date')}}">
                                                            </td>
                                                            <td></td>
                                                            <td>
                                                                {!! Form::select('danger_cat_id', [''=>__('Select Danger')]+$danger_cat,null , array('class'=>'form-control', 'id'=>'danger_cat_id')) !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::select('danger_status', ['High'=>__('High'),'Medium'=>__('Medium'),'Low'=>__('Low')],null, array('class'=>'form-control', 'id'=>'danger_status','placeholder'=>__('Danger Level'))) !!}
                                                            </td>
                                                            <td class="trial-hidden">
                                                                {!! Form::select('payment_status', ['1'=>__('Paid'),'Null'=>__('Not Paid')],null, array('class'=>'form-control', 'id'=>'payment_status','placeholder'=>__('Payment Status'))) !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::select('danger_status_last', ['removed'=>__('removed'),'exist'=>__('exist'),'work on'=>__('work on')],null, array('class'=>'form-control', 'id'=>'danger_status_last','placeholder'=>__('Violation Status'))) !!}
                                                            </td>
                                                            {{--                                                    <td>--}}
                                                            {{--                                                        {!! Form::select('objection_status', ['1'=>__('Yes'),'null' =>__('No')],null, array('class'=>'form-control', 'id'=>'objection_status','placeholder'=>__('Objection Status'))) !!}--}}
                                                            {{--                                                    </td>--}}
                                                            <td class="trial-hidden"></td>
                                                            <td></td>
                                                        </tr>

                                                        <tr role="row" class="heading">
                                                            <th scope="col" style="max-width: 75px !important;">{{__('Date')}}</th>
                                                            <th scope="col">{{__('Code')}}</th>
                                                            <th scope="col" style="max-width: 75px !important;">{{__('Danger Category')}}</th>
                                                            <th scope="col">{{__('Danger Level')}}</th>
                                                            <th class="trial-hidden" scope="col">{{__('Paid')}}</th>
                                                            <th scope="col">{{__('Violation Status')}}</th>
                                                            {{--                                                    <th scope="col">{{__('Objection Status')}}</th>--}}
                                                            <th class="trial-hidden" scope="col">{{__('Invoice')}}</th>
                                                            <th scope="col">{{__('Details')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="mydata">
                                                        </tbody>
                                                    </table>

                                                    <div id="print_section" style="display: none;">
                                                        <img src="{{ asset('/') }}images/print-header.png">
                                                        <hr>
                                                        <table id="project-table" class="header-table">
                                                            <tr>
                                                                <td width="25%">{{__('State')}}:</td>
                                                                <td width="25%">{{$project->state->state}}</td>
                                                                <td width="25%">{{__('City')}}:</td>
                                                                <td width="25%">{{$project->city->city}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="25%">{{__('Project Name')}}:</td>
                                                                <td width="25%">{{$project->name}}</td>
                                                                <td width="25%">{{__('Owner')}}:</td>
                                                                <td width="25%">{{$project->owner}}</td>
                                                            </tr>
                                                        </table>

                                                        <span class="am-label">{{__('Project Violations')}}</span>
                                                        <table id="print_table" class="table table-hover table-striped print-vios"></table>
                                                    </div>
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
    <iframe id="myList" style="display: none;"></iframe>
    @include('includes.footer')
@endsection

@push('scripts')
    <script type="text/javascript">
        $(".print_violations").click(function () {
            $('#print_table').empty();
            $('#print_table').append($('.heading').html());
            $('#print_table').append($('#mydata').html());
            var divToPrint1 = $('#print_section').html();
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html lang="ar" class="rtl" dir="rtl"><head><link href="{{asset('/')}}css/font-awesome.css" rel="stylesheet"><link rel="stylesheet" href="{{asset('/')}}css/main.css" type="text/css" /> <link rel="stylesheet" href="{{asset('/')}}css/rtl-style.css" type="text/css" /><link rel="stylesheet" href="{{asset('/')}}css/print.css" type="text/css" /></head><body onload="window.print()">' + divToPrint1 + '</body></html>');
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
                    url: '{!! route('fetch.data.violations') !!}',
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
                    {data: 'gregorian_date', name: 'gregorian_date',orderable: false},
                    {data: 'code', name: 'code'},
                    {data: 'danger_cat_id', name: 'danger_cat_id',orderable: false},
                    {data: 'danger_status', name: 'danger_status',orderable: false},
                    {data: 'payment_status', name: 'payment_status',orderable: false, class: 'trial-hidden'},
                    {data: 'danger_status_last', name: 'danger_status_last',orderable: false},
                    // {data: 'objection_status', name: 'objection_status'},
                    {data: 'invoice', name: 'invoice',orderable: false, class: 'trial-hidden'},
                    {data: 'show', name: 'show',orderable: false},
                ],
                "language": {
                    "lengthMenu": "عدد العناصر بالصفحة _MENU_ عنصر",
                    "zeroRecords": "لا يوجد نتائج",
                    "info": "عرض _PAGE_ من _PAGES_ صفحة",
                    "infoEmpty": "لا يوجد نتائج مطابقة",
                    "infoFiltered": "(تم البحث في إجمالي _MAX_ سجلات)"
                },
                "initComplete": function (settings, json) {
                    $(".print-btn").click(function () {
                        var divToPrint = $(this).parent().parent().children('.modal-body')[0];
                        var newWin = window.open('', 'Print-Window');
                        newWin.document.open();
                        newWin.document.write('<html lang="ar" class="rtl" dir="rtl"><head><link rel="stylesheet" href="{{asset('/')}}css/main.css" type="text/css" /> <link rel="stylesheet" href="{{asset('/')}}css/rtl-style.css" type="text/css" /><link rel="stylesheet" href="{{asset('/')}}css/print.css" type="text/css" /></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
                        newWin.document.close();
                    });
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
            // $('#objection_status').on('change', function (e) {
            //     oTable.draw();
            //     e.preventDefault();
            // });
        });
    </script>
@endpush