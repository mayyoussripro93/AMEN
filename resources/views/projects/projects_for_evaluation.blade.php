@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Evaluation')])

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
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="job-header">
                                <div class="contentbox" style="overflow: auto;">
                                    <div class="portlet light portlet-fit portlet-datatable bordered" style="position:relative;">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <h6 class="green-color am-sub-title">{{__('Evaluate Projects')}} ({{$project_count}})</h6>

                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-container">
                                                <form method="post" role="form" id="datatable-search-form">

                                                    <table class="table table-striped table-bordered table-hover"  id="ProjectDatatableAjax">
                                                        <thead>
                                                        <tr role="row" class="filter">
                                                            <td>
{{--                                                                <input type="text" class="form-control  datepicker" name="date_gregorian_txt" id="date_gregorian_txt" autocomplete="off" placeholder="{{__('Date')}}">--}}
                                                                <input type="text" class="form-control" name="start_date" id="start_date" placeholder="{{__('Date')}}">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control" name="name" id="name" autocomplete="off" placeholder="{{__('Name')}}">

                                                            </td>
                                                            <td>
                                                                {!! Form::select('state_id', ['' => __('State')] + $states,Auth::guard('employee')->user()->state_id, array( 'id'=>'state_id' ,'class' => 'form-control')); !!}
                                                            </td>
                                                            <td>
                                                                <span id="city_dd"> {!! Form::select('city_id', [''=>__('City')], null, array('class'=>'form-control', 'id'=>'city_id')) !!}</span>
                                                            </td>
                                                            <td>
                                                                {!! Form::select('is_active', [1=>__('Work On'),0=>__('Completed')],null, array('class'=>'form-control', 'id'=>'is_active','placeholder'=>__('Status'))) !!}
                                                            </td>
                                                            {{--                                                        <td></td>--}}

                                                            <td></td>


                                                        </tr>
                                                        <tr role="row" class="heading">
                                                            <th scope="col" style="max-width: 75px !important;">{{__('Start Date')}}</th>

                                                            <th scope="col" style="max-width: 75px !important;">{{__('Name')}}</th>
                                                            <th scope="col">{{__('State')}}</th>
                                                            <th scope="col">{{__('City')}}</th>
                                                            <th scope="col">{{__('Project Status')}}</th>
                                                            <th scope="col">{{__('Evaluation')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="mydata">
                                                        </tbody>
                                                    </table>
                                                    <div id="print_section" style="display: none;">
                                                        <table id="print_table"></table>
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

    @include('includes.footer')
@endsection
@push('scripts')

<script type="text/javascript">
    //


    $(".print_project").click(function() {
        $('#print_table').empty();
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
    // $(function () {


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
                url: '{!! route('fetch.data.projects.for.evaluation') !!}',
                data: function (d) {
                    d.name = $('#name').val();
                    d.start_date = $('#start_date').val();
                    d.state_id = $('#state_id').val();
                    d.city_id = $('#city_id').val();
                    d.is_active = $('#is_active').val();

                }
            }, columns: [
                {data: 'date_gregorian', name: 'date_gregorian'},
                {data: 'name', name: 'name'},
                {data: 'state', name: 'state'},
                {data: 'city', name: 'city'},
                {data: 'is_active', name: 'is_active'},
                // {data: 'violation_no', name: 'violation_no'},
                {data: 'show', name: 'show'},
            ],
            "language": {
                "lengthMenu": "عدد العناصر بالصفحة _MENU_ عنصر",
                "zeroRecords": "لا يوجد نتائج",
                "info": "عرض _PAGE_ من _PAGES_ صفحة",
                "infoEmpty": "لا يوجد نتائج مطابقة",
                "infoFiltered": "(تم البحث في إجمالي _MAX_ سجلات)"
            }
        });

        $('#start_date').daterangepicker({
            // "singleDatePicker": true,
            // "timePicker": true,
            // "timePicker24Hour": true,
            autoUpdateInput: false,
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
        $('#is_active').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#state_id').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
            filtercity();
        });

    function filtercity()
    {
        var state_id = $('#state_id').val();
        if (state_id != '') {
            $.post("{{ route('filter.lang.cities.dropdown') }}"
                , {
                    state_id: state_id,

                    _method: 'POST',
                    _token: '{{ csrf_token() }}'})
                .done(function (datacity) {
                    $('#city_dd').html(datacity);
                    $('#city_id').on('change', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                });
        }
    }

        filtercity();

    // });

</script>
@endpush
