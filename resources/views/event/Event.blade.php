@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Add Event')])
    <div class="listpgWraper">
        <div class="container-fluid" id="create-calendar">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @elseif (Session::has('warnning'))
                        <div class="alert alert-danger">{{ Session::get('warnning') }}</div>
                    @endif

                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="employeeccount userccount">
                                <div class="formpanel">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h5 class="green-color am-title"><i class="fa fa-calendar-plus-o"
                                                                                aria-hidden="true"></i> {{__('Add Event')}}
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="row page-sec">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h6 class="am-sub-title green-color">{{__('Add New Event')}}</h6>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="panel panel-primary">

                                                <div class="panel-body">

                                                    {!! Form::open(array('route' => 'events.add','method'=>'POST','files'=>'true')) !!}
                                                    <div class="row">

                                                        <div class="col-md-6 col-sm-6 col-xs-12">

                                                            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'event_name') !!}"
                                                                 id="event_name_div">
                                                                <label class="am-label"><span
                                                                            class="red-color">*</span> {{__('Meeting Title')}}
                                                                    :</label>
                                                                <div class="">
                                                                    {!! Form::text('event_name', null, ['class' => 'form-control','data-validation'=>'required' ])!!}

                                                                    <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'event_name') !!}</strong></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">

                                                            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'consultant') !!}"
                                                                 id="country_id_div">
                                                                <label class="am-label"><span
                                                                            class="red-color">*</span> {{__('Project Name')}}
                                                                    :</label>
                                                                {!! Form::select('consultant', ['' => __('Select Project')]+$projects, old('consultant'), array('class'=>'form-control', 'id'=>'consultant','data-validation'=>'required')) !!}
                                                                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'consultant') !!}</strong></span>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'start_date') !!}"
                                                                 id="start_date_div">
                                                                <label class="am-label"><span
                                                                            class="red-color">*</span> {{__('Start Date')}}
                                                                    :</label>
                                                                <div class="">
                                                                    {!! Form::input('text','start_date', null, ['id'=>'start_date','class' => 'form-control','autocomplete'=>"off",'data-validation'=>'required']) !!}
                                                                    <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'start_date') !!}</strong></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'end_date') !!}"
                                                                 id="end_date_div">
                                                                <label class="am-label"><span
                                                                            class="red-color">*</span> {{__('End Date')}}
                                                                    :</label>

                                                                <div class="">
                                                                    {{--                                {!! Form::date('end_date', null, ['class' => 'form-control']) !!}--}}
                                                                    {!! Form::input('text','end_date',null, ['id'=>'end_date','class' => 'form-control','min'=> date('Y-m-d\TH:i',strtotime(Carbon\Carbon::now())),'autocomplete'=>"off",'data-validation'=>'required']) !!}
                                                                    <span class="help-block"> <strong>
                                                                                  <span id="datespan_red_2"
                                                                                        class="datespan_red"
                                                                                        style="display: none;">{{__('Please enter valid end for event')}} </span>{!! APFrmErrHelp::showErrors($errors, 'end_date') !!}</strong></span>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <h6 class="am-sub-title green-color">{{__('Meating Detail')}}
                                                                <small class="red-color">*</small></h6>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'description') !!}"> {!! Form::textarea('description', null, array('class'=>'form-control', 'id'=>'description')) !!}
                                                                {!! APFrmErrHelp::showErrors($errors, 'description') !!} </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-xs-6 text-center pull-left"
                                                             style="margin-top: 30px;">
                                                            <button type="submit" class="btn" id="sub_1">{!! __('Save') !!}</button>
                                                            {{--                                                            {!! Form::submit(__('Save'),['class'=>'btn','id'=>'sub_1']) !!}--}}
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row page-sec">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h6 class="am-sub-title green-color">{{__('Visits and Meetings')}}</h6>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="panel panel-primary">

                                                <div id='calendar'></div>
                                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                                     aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h6 class="modal-title green-color"
                                                                    id="name_event"></h6>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <input type="hidden" name="event_id" id="event_id"
                                                                       value=""/>
                                                                <input type="hidden" name="appointment_id"
                                                                       id="appointment_id"
                                                                       value=""/>
                                                                <div class="formrow" style="margin-bottom: 15px;">
                                                                    <label class="am-label"><span
                                                                                class="red-color">*</span> {{__('Meeting Title')}}
                                                                        :</label>
                                                                    <input type="text" name="event_name_edit"
                                                                           class="form-control input-time "
                                                                           id='event_name_edit'
                                                                    >
                                                                    <span class="help-block red-color"
                                                                          id="event_name_edit_1"> </span>
                                                                </div>

                                                                <div class="formrow" style="margin-bottom: 15px;">
                                                                    <label class="am-label"><span
                                                                                class="red-color">*</span> {{__('Project Name')}}
                                                                        :</label>
                                                                    {!! Form::select('project_name_edit', ['' => __('Select Project')]+$projects, old("project_name_edit"), array('class'=>'form-control', 'id'=>'project_name_edit','autocomplete'=>"off",'disabled' )) !!}
                                                                    <span class="help-block red-color"
                                                                          id="project_name_edit_1"> </span>
                                                                    {{--                                                                <select name="project_name_edit" class='form-control' id='project_name_edit' >--}}
                                                                    {{--                                                                    @foreach ($projects as $key => $value)--}}
                                                                    {{--                                                                        <option value="{{ $key }}"--}}
                                                                    {{--                                                                                @if ($key == '2')--}}
                                                                    {{--                                                                               selected--}}
                                                                    {{--                                                                                @endif--}}
                                                                    {{--                                                                        >{{ $value }}</option>--}}
                                                                    {{--                                                                    @endforeach--}}
                                                                    {{--                                                                </select>--}}
                                                                    {{--                                                                <input type="text" name="start_date_edit"--}}
                                                                    {{--                                                                       class="form-control input-time " id='project_name_edit'--}}
                                                                    {{--                                                                       min=date('Y-m-d\TH:i',strtotime(Carbon\Carbon::now()))>--}}
                                                                </div>
                                                                <div class="formrow" style="margin-bottom: 15px;">
                                                                    <label class="am-label"><span
                                                                                class="red-color">*</span> {{__('Start Date')}}
                                                                        :</label>
                                                                    <input type="text" name="start_date_edit"
                                                                           class="form-control input-time "
                                                                           id='start_date_edit'
                                                                           min=date('Y-m-d\TH:i',strtotime(Carbon\Carbon::now()))>
                                                                    <span class="help-block red-color"
                                                                          id="start_date_1"> </span>

                                                                </div>
                                                                <div class="formrow" style="margin-bottom: 15px;">
                                                                    <label class="am-label"><span
                                                                                class="red-color">*</span> {{__('End Date')}}
                                                                        :</label>
                                                                    <input type="text" name="end_date_edit" value=""
                                                                           class="form-control input-time "
                                                                           id='end_date_edit'
                                                                           min=date('Y-m-d\TH:i',strtotime(Carbon\Carbon::now()))>
                                                                    <span class="help-block red-color"
                                                                          id="end_date_1"> </span>
                                                                    <span id="datespan_red_3"
                                                                          class="datespan_red"
                                                                          style="display: none;">{{__('Please enter valid end for event')}} </span>
                                                                </div>
                                                                <div class="formrow" style="margin-bottom: 15px;">
                                                                    <label class="am-label"><span
                                                                                class="red-color">*</span> {{__('Meating Detail')}}
                                                                    </label>
                                                                    <input type="textarea" name="description_name_edit"
                                                                           class="form-control input-time "
                                                                           id='description_name_edit'
                                                                    >

                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal" id="appointment_update"><i
                                                                            class="fa fa-pencil"></i> {{__('Edit')}}
                                                                </button>
                                                                <button type="submit" class="btn btn-default-focus"
                                                                        id="appointment_delete"><i
                                                                            class="fa fa-trash-o"></i> {{__('Delete')}}
                                                                </button>
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
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
@push('styles')
    @include('includes.tinyMCEFront')
    <style type="text/css">
        .userccount p {
            text-align: left !important;
        }
        .datepicker > div {
            display: block;
        }
    </style>

    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css'/>



@endpush
@push('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    {!! $calendar_details->script() !!}

    <script>
        $("form").submit(function () {
            $(this).find(":button").filter(function () {
                return !this.value;
            }).attr("disabled", "disabled");
            return true;
        });
        $("form").find(":button").prop("disabled", false);
        var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();
        $(document).ready(function () {
            $('#start_date').daterangepicker({
                minDate: new Date(currentYear, currentMonth, currentDate)
                , dateFormat: 'yy-mm-dd'
                , startDate: moment(date).add(0, 'days'),
                "singleDatePicker": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "autoUpdateInput": false,
                "locale": {
                    "format": "YYYY-MM-DD HH:mm:ss",
                    "separator": " - ",
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
            }).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                event.preventDefault();
                var a = new Date($('#end_date').val());
                var b = new Date($('#start_date').val());
                if (a == '' || b == '') {
                    $('#datespan_red_2').css('color', 'red');
                    $('#datespan_red_2').show();
                    $('#sub_1').attr("disabled", true);
                } else if (a <= b) {
                    $('#datespan_red_2').css('color', 'red');
                    $('#datespan_red_2').show();
                    $('#sub_1').attr("disabled", true);
                } else if (a > b) {
                    $('#datespan_red_2').css('color', 'black');
                    $('#datespan_red_2').hide();
                    $('#sub_1').attr("disabled", false);
                }
                // console.log(picker.startDate.format('YYYY-DD'));
                // console.log(picker.endDate.format('YYYY-MM-DD'));
            });
            $('#end_date').daterangepicker({
                minDate: new Date(currentYear, currentMonth, currentDate)
                , dateFormat: 'yy-mm-dd'
                , startDate: moment(date).add(0, 'days'),
                "singleDatePicker": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "autoUpdateInput": false,
                "locale": {
                    "format": "YYYY-MM-DD HH:mm:ss",
                    "separator": " - ",
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
            }).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                event.preventDefault();
                var a = new Date($('#end_date').val());
                var b = new Date($('#start_date').val());
                if (a == '' || b == '') {
                    $('#datespan_red_2').css('color', 'red');
                    $('#datespan_red_2').show();
                    $('#sub_1').attr("disabled", true);
                } else if (a <= b) {
                    $('#datespan_red_2').css('coleor', 'red');
                    $('#datespan_red_2').show();
                    $('#sub_1').attr("disabled", true);
                } else if (a > b) {
                    $('#datespan_red_2').css('color', 'black');
                    $('#datespan_red_2').hide();
                    $('#sub_1').attr("disabled", false);
                }
                // console.log(picker.startDate.format('YYYY-DD'));
                // console.log(picker.endDate.format('YYYY-MM-DD'));
            });
            // $("#end_date").on("change", function (e) {
            //     var a = new Date($('#end_date').val());
            //     var b = new Date($('#start_date').val());
            //     if (a == '' || b == '') {
            //         $('#datespan_red_2').css('color', 'red');
            //         $('#datespan_red_2').show();
            //         $('#sub_1').attr("disabled", true);
            //     } else if (a < b) {
            //
            //         $('#datespan_red_2').css('color', 'red');
            //         $('#datespan_red_2').show();
            //         $('#sub_1').attr("disabled", true);
            //     } else if (a > b) {
            //
            //         $('#datespan_red_2').css('color', 'black');
            //         $('#datespan_red_2').hide();
            //         $('#sub_1').attr("disabled", false);
            //     }
            // });
            $('#start_date_edit').daterangepicker({
                minDate: new Date(currentYear, currentMonth, currentDate)
                , dateFormat: 'yy-mm-dd',
                // , startDate: moment(date).add(0,'days'),
                "singleDatePicker": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "locale": {
                    "format": "YYYY-MM-DD HH:mm:ss",
                    "separator": " - ",
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
            }).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                event.preventDefault();
                var a = new Date($('#end_date_edit').val());
                var b = new Date($('#start_date_edit').val());
                if (a == '' || b == '') {
                    $('#datespan_red_3').css('color', 'red');
                    $('#datespan_red_3').show();
                    $('#appointment_update').attr("disabled", true);
                } else if (a <= b) {
                    $('#datespan_red_3').css('color', 'red');
                    $('#datespan_red_3').show();
                    $('#appointment_update').attr("disabled", true);
                } else if (a > b) {
                    $('#datespan_red_3').css('color', 'black');
                    $('#datespan_red_3').hide();
                    $('#appointment_update').attr("disabled", false);
                }
                // console.log(picker.startDate.format('YYYY-DD'));
                // console.log(picker.endDate.format('YYYY-MM-DD'));
            });
            $('#end_date_edit').daterangepicker({
                minDate: new Date(currentYear, currentMonth, currentDate)
                , dateFormat: 'yy-mm-dd'
                , startDate: moment(date).add(0, 'days'),
                "singleDatePicker": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "locale": {
                    "format": "YYYY-MM-DD HH:mm:ss",
                    "separator": " - ",
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
            }).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                event.preventDefault();
                var a = new Date($('#end_date_edit').val());
                var b = new Date($('#start_date_edit').val());
                if (a == '' || b == '') {
                    $('#datespan_red_3').css('color', 'red');
                    $('#datespan_red_3').show();
                    $('#appointment_update').attr("disabled", true);
                } else if (a <= b) {
                    $('#datespan_red_3').css('color', 'red');
                    $('#datespan_red_3').show();
                    $('#appointment_update').attr("disabled", true);
                } else if (a > b) {
                    $('#datespan_red_3').css('color', 'black');
                    $('#datespan_red_3').hide();
                    $('#appointment_update').attr("disabled", false);
                }
                // console.log(picker.startDate.format('YYYY-DD'));
                // console.log(picker.endDate.format('YYYY-MM-DD'));
            });
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                // defaultView: 'agendaWeek',
                displayEventTime: false,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultView: 'month',
                backgroundColor: 'red',
                events: [
                        @foreach($appointments as $appointment)
                    {
                        title: '{{ $appointment->event_name}}',
                        description: '{!! $appointment->description!!}',
                        id: '{{ $appointment->id }}',
                        {{--title : '{{ $appointment->client->first_name . ' ' . $appointment->client->last_name }}',--}}
                        start: '{{ $appointment->start_date }}',
                        @if ($appointment->end_date)
                        end: '{{ $appointment->end_date }}',
                        @endif
                        event_name: '{{ $appointment->event_name }}',
                        project_id: '{{ $appointment->project_id }}',
                        // color: 'yellow',
                        // textColor: 'black'
                    },
                    @endforeach
                ],
                eventAfterRender: function (event, element, view) {
                    $(element).tooltip({
                        title: event.description,
                        // title: element.event.extendedProps.description,
                        container: "body"
                    });
                    var dataHoje = new Date();
                    if (event.start < dataHoje && event.end > dataHoje) {
                        //event.color = "#FFB347"; //Em andamento
                        element.css('background-color', '#228251');
                    } else if (event.start < dataHoje && event.end < dataHoje) {
                        //event.color = "#77DD77"; //Concluído OK
                        element.css('background-color', '#d9534f');
                    } else if (event.start > dataHoje && event.end > dataHoje) {
                        //event.color = "#AEC6CF"; //Não iniciado
                        element.css('background-color', '#17ad68');
                    }
                },
                eventClick: function (calEvent, jsEvent, view) {
                    document.getElementById("name_event").innerHTML = calEvent.event_name;
                    $('#event_id').val(calEvent._id);
                    $('#appointment_id').val(calEvent.id);
                    $('#event_name_edit').val(calEvent.event_name);
                    $('#project_name_edit').val(calEvent.project_id);
                    $('#description_name_edit').val(calEvent.description);
                    $('#start_date_edit').val(moment(calEvent.start).format('YYYY-MM-DD HH:mm:ss'));
                    $('#end_date_edit').val(moment(calEvent.end).format('YYYY-MM-DD HH:mm:ss'));
                    $('#editModal').modal();
                }
            });
            $('#appointment_update').click(function (e) {
                e.preventDefault();
                var data = {
                    _token: '{{ csrf_token() }}',
                    appointment_id: $('#appointment_id').val(),
                    start_date: $('#start_date_edit').val(),
                    end_date: $('#end_date_edit').val(),
                    event_name_edit: $('#event_name_edit').val(),
                    description_name_edit: $('#description_name_edit').val(),
                    project_name_edit: $('#project_name_edit').val(),
                };
                $.post('{{ route('appointments.ajax_update') }}', data, function (result) {
                    if (result == 'ok') {
                        window.location.href = ' {{route('events.index')}}';
                        $('#calendar').fullCalendar('removeEvents', $('#event_id').val());
                        $('#calendar').fullCalendar('renderEvent', {
                            // title: result.appointment.client.first_name + ' ' + result.appointment.client.last_name,
                            start: $('#start_date_edit').val(),
                            end: $('#end_date_edit').val()
                        }, true)
                    }
                    if (typeof JSON.parse(result)["event_name_edit"] != "undefined" ||
                        typeof JSON.parse(result)["project_name_edit"] != "undefined" ||
                        typeof JSON.parse(result)["start_date"] != "undefined" ||
                        typeof JSON.parse(result)["end_date"] != "undefined") {
                        $('#editModal').modal('show');
                        if (typeof JSON.parse(result)["event_name_edit"] != "undefined") {
                            $('#event_name_edit_1').html(JSON.parse(result)["event_name_edit"][0]);
                        } else if (typeof JSON.parse(result)["project_name_edit"] != "undefined") {
                            $('#project_name_edit_1').html(JSON.parse(result)["project_name_edit"][0]);
                        } else if (typeof JSON.parse(result)["start_date"] != "undefined") {
                            $('#start_date_1').html(JSON.parse(result)["start_date"][0]);
                        } else if (typeof JSON.parse(result)["end_date"] != "undefined") {
                            $('#end_date1').html(JSON.parse(result)["end_date"][0]);
                        }
                    }
                });
            });
            $('#appointment_delete').click(function (e) {
                e.preventDefault();
                var data = {
                    _token: '{{ csrf_token() }}',
                    appointment_id: $('#appointment_id').val(),
                    start_date: $('#start_date_edit').val(),
                    end_date: $('#end_date_edit').val(),
                };
                $.post('{{ route('appointments.ajax_delete') }}', data, function (result) {
                    $('#calendar').fullCalendar('removeEvents', $('#event_id').val());
                    $('#calendar').fullCalendar('renderEvent', {
                        // title: result.appointment.client.first_name + ' ' + result.appointment.client.last_name,
                        start: $('#start_date_edit').val(),
                        end: $('#end_date_edit').val()
                    }, true);
                    // $('#editModal').modal('hide');
                }).done(function (response) {
                    if (response == 'ok') {
                        $('#editModal').modal('hide');
                        alert("{{__('Event deleted')}}");
                        window.location.href = ' {{route('events.index')}}';
                    } else {
                        $('#editModal').modal('hide');
                        alert("{{__('Request Failed!')}}");
                    }
                });
                ;
            });
        });
        $.validate({
            modules : 'file',
            addValidClassOnAll : true,
            errorMessagePosition : 'top' ,// Instead of 'inline' which is default
            validateOnBlur : false,
            showHelpOnFocus : false,
            addSuggestions : false
        });
    </script>
@endpush