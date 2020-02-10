@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Add Violation')])

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


    </style>
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">

            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    @include('flash::message')

                    <div class="row">
                    @include('includes.employee_dashboard_menu')


                    <!-- Add Violation -->
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            @include('projects.inc.project_header')

                            <div class="employeeccount userccount">
                                <div class="formpanel">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h5 class="green-color am-title"><i class="fa fa-plus-circle"
                                                                                aria-hidden="true"></i> {{__('Add Violation')}}
                                            </h5>
                                        </div>
                                    </div>

                                    <form class="form-horizontal " id="violation_form" method="POST"
                                          action="{{route('project.store_violation')}}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$project->id}}" name="project_id">
                                        <div class="form-body">

                                            <div class="row page-sec">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <h6 class="am-sub-title green-color">{{__('Violation Details')}}</h6>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="formrow {{ $errors->has('gregorian_date') ? ' has-error' : '' }} no-margin-btm">
                                                        <label class="am-label"><span
                                                                    class="red-color">*</span> {{__('Violation Date')}}:</label>
                                                        {{--                                                        {!! Form::text('gregorian_txt',  old('gregorian_date'), array('class'=>'form-control', 'id'=>'datagregoian', 'placeholder'=>__('Violation Date'),'autocomplete'=>'off')) !!}--}}
                                                        <input type="text" value="{{old('gregorian_date')}}" name="gregorian_date_str" id="gregorian_date" class="form-control" placeholder="{{__('Violation Date')}}" data-validation="required">

                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'gregorian_date') !!}</strong> </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="formrow {{ $errors->has('axles') ? ' has-error' : '' }} no-margin-btm">
                                                        <label class="am-label"><span class="red-color">*</span> {{__('axles')}}:</label>
                                                        <input type="text" name="axles" class="form-control" data-validation="required" placeholder="{{__('axles')}}" value="{{old('axles')}}">
                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'axles') !!}</strong> </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="formrow {{ $errors->has('floor') ? ' has-error' : '' }} no-margin-btm">
                                                        <label class="am-label"><span
                                                                    class="red-color">*</span> {{__('floor')}}:</label>
                                                        <input type="text" name="floor" class="form-control"
                                                               data-validation="required" placeholder="{{__('floor')}}"
                                                               value="{{old('floor')}}">
                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'floor') !!}</strong> </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="formrow {{ $errors->has('area') ? ' has-error' : '' }} no-margin-btm">
                                                        <label class="am-label"><span
                                                                    class="red-color">*</span> {{__('area')}}:</label>
                                                        <input type="text" name="area" class="form-control"
                                                               data-validation="required" placeholder="{{__('area')}}"
                                                               value="{{old('area')}}">
                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'area') !!}</strong> </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="formrow {{ $errors->has('special_marque') ? ' has-error' : '' }} no-margin-btm">
                                                        <label class="am-label"><span
                                                                    class="red-color">*</span> {{__('Special Marque')}}
                                                            :</label>
                                                        <input type="text" name="special_marque" class="form-control" data-validation="required"
                                                               placeholder="{{__('Special Marque')}}"
                                                               value="{{old('special_marque')}}">
                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'special_marque') !!}</strong> </span>

                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="formrow {{ $errors->has('danger_cat_id') ? ' has-error' : '' }} no-margin-btm">
                                                        <label class="am-label"><span class="red-color">*</span> {{__('Danger Category')}}
                                                            :</label>
                                                        {!! Form::select('danger_cat_id', [''=>__('Select Danger')]+$danger_cat,null , array('class'=>'form-control', 'id'=>'danger_cat_id','data-validation'=>'required')) !!}
                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'danger_cat_id') !!}</strong> </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="formrow {{ $errors->has('danger_sub_cat_id') ? ' has-error' : '' }} no-margin-btm">
                                                        <label class="am-label"><span
                                                                    class="red-color">*</span> {{__('Danger Subcategory')}}
                                                            :</label>
                                                        <span id="danger_dd">{!! Form::select('danger_sub_cat_id', [''=>__('Select Danger Subcategory')],null , array('class'=>'form-control', 'id'=>'danger_sub_cat_id')) !!}</span>
                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'danger_sub_cat_id') !!}</strong> </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="formrow {{ $errors->has('description') ? ' has-error' : '' }} no-margin-btm">
                                                        <label class="am-label"><span
                                                                    class="red-color">*</span> {{__('Danger Description')}}
                                                            :</label>
                                                        <textarea name="description" class="form-control" data-validation="required"
                                                                  placeholder="{{__('Danger Description')}}"></textarea>
                                                        <p id="remaining_letters"></p>
                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'description') !!}</strong> </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="formrow  no-margin-btm">
                                                        <label class="am-label"><span class="red-color">*</span> {{__('Danger Level')}}:</label>
                                                        {{Form::select('danger_status',['High'=>__('High'),'Medium'=>__('Medium'),'Low'=>__('Low')],old('danger_status'),array('class'=>'form-control','data-validation'=>'required')) }}

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row page-sec">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="formrow {{ $errors->has('description') ? ' has-error' : '' }}{{ $errors->has('uploads') ? ' has-error' : '' }}">
                                                        <h6 class="am-sub-title green-color">{{__('Attachments')}}</h6>
                                                        <input type="file" class="form-control-file form-control"
                                                               id="exampleFormControlFile1" name="uploads[]" multiple data-validation="size" data-validation-max-size="10M">
                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'uploads') !!}</strong> </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 30px;">
                                                <div class="col-md-4 pull-left">
                                                    <button type="submit" class="btn"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{__('Save')}}
                                                    </button>
                                                </div>
                                            </div>
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

    @include('includes.footer')
@endsection
@push('scripts')
    <script type="text/javascript">

        filterSubCat(<?php  echo old('danger_cat_id'); ?>);
        /****************************************************************/
        //HH:mm
        $('#gregorian_date').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "startDate":"{{$project->date_gregorian}}",
            "endDate":"{{$date=($project->end_date)!='' ?$project->end_date : date('Y-m-d')}}",
            "minDate":"{{$project->date_gregorian}}",
            "maxDate":"{{$date=($project->end_date)!='' ?$project->end_date : date('Y-m-d')}}",
            "locale": {
                "format": "YYYY-MM-DD HH:mm",
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
            console.log(picker.startDate.format('YYYY-DD'));
            console.log(picker.endDate.format('YYYY-MM-DD'));
        });
        /****************************************************************/
        $(document).on('change', '#danger_cat_id', function (e) {
            e.preventDefault();
            filterSubCat(0);
        });

        function filterSubCat(state_id) {
            var country_id = $('#danger_cat_id').val();
            if (country_id != '') {
                $.post("{{ route('filter.lang.cat.dropdown') }}", {
                    country_id: country_id,
                    state_id: state_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {

                        $('#danger_dd').html(response);
                        $('#state_id').val(<?php  echo old('danger_sub_cat_id'); ?>)
                    });
            }
        }


        {{--$('#violation_form').submit(function () {--}}
        {{--    var check = true;--}}
        {{--    var totalfilesizes = 0;--}}
        {{--    var files = $("#exampleFormControlFile1").get(0).files;--}}

        {{--    for (i = 0; i < files.length; i++) {--}}
        {{--        var ext = files[i].name.substr((files[i].name.lastIndexOf('.') + 1));--}}
        {{--        if (ext == 'jpg' || ext == 'png' || ext == 'jpeg') {--}}
        {{--        } else {--}}
        {{--            check = false;--}}
        {{--        }--}}
        {{--        totalfilesizes += files[i].size;--}}

        {{--    }--}}
        {{--    if (totalfilesizes > 2097152) {--}}
        {{--        check = false;--}}

        {{--    }--}}
        {{--    if (!check) {--}}
        {{--        alert('{{__('Invalid Files')}}');--}}
        {{--    }--}}
        {{--    return check;--}}


        {{--});--}}
    </script>
@endpush