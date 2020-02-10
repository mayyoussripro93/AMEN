@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Job Details')])
    <div class="listpgWraper">
        <div class="container-fluid" id="show-calendar">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="employeeccount userccount">
                                <div class="formpanel">
                                    <div class="row page-sec">
                                        <div class="col-md-12 col-xs-12">
                                            <h6 class="am-sub-title green-color">{{__('Visits and Meetings')}}</h6>
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <div class="panel panel-primary">
                                                <div id='calendar'></div>
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
    </style>
    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css'/>
@endpush
@push('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script>
        $(document).ready(function () {
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
                        @foreach($appointments as $appointment1)
                        @foreach($appointment1 as $appointment)
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
                        // color: 'yellow',
                        // textColor: 'black'
                    },
                    @endforeach

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
                    $('#start_date_edit').val(moment(calEvent.start).format('YYYY-MM-DD HH:mm:ss'));
                    $('#end_date_edit').val(moment(calEvent.end).format('YYYY-MM-DD HH:mm:ss'));
                    $('#editModal').modal();
                }
            });
        });
    </script>
@endpush
