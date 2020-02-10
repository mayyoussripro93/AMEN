@extends('admin.layouts.admin_layout')
@section('content')
<style type="text/css">
    .table td, .table th {
        font-size: 12px;
        line-height: 2.42857 !important;
    }
    .btn.btn-default, button[type='submit'] {
        width: 30%;
        /*background-color: #17ad68;*/
        /*color: #fff;*/
        border-radius: 0;
        padding: 10px;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
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
                <li> <span>{{__('Events')}}</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">{{__('Manage Events')}}</h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject font-red-sunglo sbold uppercase">{{__('Visits and Meetings')}}</span> </div>
                        <div class="actions"> <a href="{{ route('create.event') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> {{__('Add Event')}}</a> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <div class="row page-sec">

                                <div class="col-md-12">
                                    <div class="panel panel-primary">

                                        <div id='calendar'></div>
                                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                             aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title green-color" id="name_event"></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                            <label class="am-label"><span class="red-color">*</span> {{__('Employee Name')}}</label>
                                                            {!! Form::select('employee_id_edit', ['' => __('Select Employee')]+$employees, old("employee_id_edit"), array('class'=>'form-control', 'id'=>'employee_id_edit','autocomplete'=>"off" ,'disabled')) !!}
                                                            <span class="help-block red-color" id="employee_id_edit_1"> </span>

                                                        </div>
                                                        <div class="formrow" style="margin-bottom: 15px;">
                                                            <label class="am-label"><span class="red-color">*</span> {{__('Meeting Title')}}</label>
                                                            <input type="text" name="event_name_edit"
                                                                   class="form-control input-time " id='event_name_edit'
                                                            >
                                                            <span class="help-block red-color" id="event_name_edit_1"> </span>
                                                        </div>

                                                        <div class="formrow" style="margin-bottom: 15px;">
                                                            <label class="am-label"><span class="red-color">*</span> {{__('Project Name')}}</label>
                                                            {!! Form::select('project_name_edit', ['' => 'Select Project']+$projects, old("project_name_edit"), array('class'=>'form-control', 'id'=>'project_name_edit','autocomplete'=>"off" ,'disabled' )) !!}
                                                            <span class="help-block red-color" id="project_name_edit_1"> </span>

                                                        </div>
                                                        <div class="formrow" style="margin-bottom: 15px;">
                                                            <label class="am-label"><span class="red-color">*</span> {{__('Start Date')}}</label>
                                                            <input type="text" name="start_date_edit"
                                                                   class="form-control input-time " id='start_date_edit'
                                                                   min=date('Y-m-d\TH:i',strtotime(Carbon\Carbon::now()))>
                                                            <span class="help-block red-color" id="start_date_1"> </span>

                                                        </div>
                                                        <div class="formrow" style="margin-bottom: 15px;">
                                                            <label class="am-label"><span class="red-color">*</span> {{__('End Date')}}</label>
                                                            <input type="text" name="end_date_edit" value=""
                                                                   class="form-control input-time " id='end_date_edit'
                                                                   min=date('Y-m-d\TH:i',strtotime(Carbon\Carbon::now()))>
                                                            <span class="help-block red-color" id="end_date_1"> </span>
                                                            <span id="datespan_red_3"
                                                                  class="datespan_red" style="display: none;">{{__('Please enter valid end for event')}}</span>
                                                        </div>
                                                        <div class="formrow" style="margin-bottom: 15px;">
                                                            <label class="am-label"><span class="red-color">*</span> {{__('Meating Detail')}}</label>
                                                            <input type="textarea" name="description_name_edit"
                                                                   class="form-control input-time " id='description_name_edit'
                                                            >

                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal" id="appointment_update"><i class="fa fa-pencil"></i> {{__('Edit')}}</button>
                                                        <button type="submit" class="btn btn-default-focus" id="appointment_delete"><i class="fa fa-trash-o"></i> {{__('Delete')}}</button>
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
    <!-- END CONTENT BODY --> 
</div>
@endsection
@push('scripts')

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
        var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();
        $(document).ready(function () {




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
            }).on('apply.daterangepicker', function(ev, picker) {

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
            }).on('apply.daterangepicker', function(ev, picker) {

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
                        employee_id: '{{ $appointment->employee_id}}',
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
                    $('#employee_id_edit').val(calEvent.employee_id);
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
                    employee_id_edit: $('#employee_id_edit').val(),
                };

                $.post('{{ route('update.event') }}', data, function (result) {
                    if (result == 'ok') {
                        window.location.href = ' {{route('list.event')}}';
                        $('#calendar').fullCalendar('removeEvents', $('#event_id').val());
                        $('#calendar').fullCalendar('renderEvent', {
                            // title: result.appointment.client.first_name + ' ' + result.appointment.client.last_name,
                            start: $('#start_date_edit').val(),
                            end: $('#end_date_edit').val()
                        }, true)}

                    if(typeof JSON.parse(result)["event_name_edit"] != "undefined" ||
                        typeof JSON.parse(result)["project_name_edit"] != "undefined" ||
                        typeof JSON.parse(result)["employee_id_edit"] != "undefined" ||
                        typeof JSON.parse(result)["start_date"] != "undefined" ||
                        typeof JSON.parse(result)["end_date"] != "undefined" ){
                        $('#editModal').modal('show');
                        if (typeof JSON.parse(result)["event_name_edit"] != "undefined") {
                            $('#event_name_edit_1').html(JSON.parse(result)["event_name_edit"][0]);
                        }
                        else if (typeof JSON.parse(result)["project_name_edit"] != "undefined") {
                            $('#project_name_edit_1').html(JSON.parse(result)["project_name_edit"][0]);
                        }
                        else if (typeof JSON.parse(result)["start_date"] != "undefined") {
                            $('#start_date_1').html(JSON.parse(result)["start_date"][0]);
                        }
                        else if (typeof JSON.parse(result)["employee_id"] != "undefined") {
                            $('#employee_id_edit_1').html(JSON.parse(result)["employee_id"][0]);
                        }
                        else  if (typeof JSON.parse(result)["end_date"] != "undefined") {
                            $('#end_date1').html(JSON.parse(result)["end_date"][0]);
                        }}

                });
            });
            $('#appointment_delete').click(function (e) {

                e.preventDefault();
                var data = {
                    _token: '{{ csrf_token() }}',
                    appointment_id: $('#appointment_id').val(),
                    start_date: $('#start_date_edit').val(),
                    end_date: $('#end_date_edit').val(),
                    employee_id: $('#employee_id_edit').val(),
                };

                $.post('{{ route('delete.event') }}', data, function (result) {

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
                        alert("Event deleted");
                        window.location.href = ' {{route('list.event')}}';

                    } else {
                        $('#editModal').modal('hide');
                        alert("Request Failed!");
                    }


                });
                ;
            });
        });
    </script>
@endpush