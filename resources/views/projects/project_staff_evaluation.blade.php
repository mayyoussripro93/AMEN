@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Add Evaluation')])

    <style>
        th {
            text-align: center;
        }

        .tab-pane.fade.show.active {
            opacity: 1;
        }

        .tab-pane {
            line-height: 1.5;
        }

        .nav-tabs > li {
            float: right;
        }

        .job-header .contentbox ul li {
            padding: 7px 0 0 0;
        }

        .job-header .contentbox ul li:before {
            content: none;
        }

        .nav-tabs > li > a.active {
            border-color: #ddd;
            border-bottom-color: transparent !important;
            background: #fff;
        }

        h6.mb-0 {
            cursor: pointer;
        }

        td .form-control {
            text-align: center;
        }
        @media screen and (max-width: 810px) {
            .table > tbody > tr > td, .table > tbody > tr > th,
            .table > tfoot > tr > td, .table > tfoot > tr > th,
            .table > thead > tr > td, .table > thead > tr > th {
                font-size: 11px;
            }
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
                            <div class="employeeccount userccount">
                                <div class="formpanel">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h5 class="green-color am-title"><i class="fa fa-list-ol"
                                                                                aria-hidden="true"></i> {{__('Add Evaluation')}}
                                            </h5>
                                        </div>
                                    </div>


                                    @if($project->assignees_count>0)
                                        <form method="post" action="{{route('project.evaluation.post')}}"
                                              name="evaluation_form" id="evaluation_form">
                                            @csrf
                                            <input type="hidden" name="project_id" id="project_id"
                                                   value="{{Crypt::encryptString($project->id)}}">
                                            <div class="row page-sec">
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <div class="formrow no-margin-btm">
                                                        <label class="am-label"><span
                                                                    class="red-color">*</span> {{__('Date')}} :</label>
                                                        <input type="text" name="year_month"
                                                               value="{{$yearmonth}}" class="form-control "
                                                               id="year_gregoian">
                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'year_month') !!}</strong> </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12 col-xs-12" id="results">
                                                    @include('projects.inc.evaluation')
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 30px;">
                                                <div class="col-md-4 col-sm-4 col-xs-6 pull-left">
                                                    <button type="submit" class="btn"><i
                                                                class="fa fa-arrow-circle-right"
                                                                aria-hidden="true"></i> {{__('Save')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <div class="row page-sec" style="margin-top: 20px">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <h6 class="text-center"
                                                    style="color: #908f8f;">{{__('No Results!!')}}</h6>
                                                <p>{{__('You have to assign employees for this project first, so you could add evaluation for them.')}}
                                                <br>{{__('For that, click on the edit project button that appears in the upper section.')}}</p>
                                            </div>
                                        </div>
                                    @endif
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

        //////////////////////////////////////////////////////////////////////////////////////////
        $('#year_gregoian').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            // "timePicker": true,
            // "timePicker24Hour": true,
            "startDate":"{{$project->date_gregorian}}",
            "endDate":"{{$date=($project->end_date)!='' ?$project->end_date : date('Y-m-d')}}",
            "minDate": "{{$project->date_gregorian}}",
            "maxDate":"{{$date=($project->end_date)!='' ?$project->end_date : date('Y-m-d')}}",
            "locale": {
                "format": "YYYY-MM-DD ",
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
            // console.log(picker.startDate.format('YYYY-DD'));
            // console.log(picker.endDate.format('YYYY-MM-DD'));

            var id = $("#project_id").val();
            var year_month = $("#year_gregoian").val();
            $.post("{{ route('project.staff.evaluation_fetch') }}", {
                id: id,
                year_month: year_month,
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            }).done(function (response) {
                $('#results').html(response);
            });
        });
    </script>
@endpush