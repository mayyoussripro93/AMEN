@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Add New Employee')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                @include('flash::message')
                <div class="col-md-9 col-sm-8">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-8">
                            <div class="employeeccount userccount">
                                <div class="formpanel">
                                <!-- Personal Information -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="am-title green-color"><i class="fa fa-user-plus" aria-hidden="true"></i> {{__('Add New Employee')}}
                                            </h5>
                                        </div>
                                    </div>

                                    {{--{!! Form::model($user, array('method' => 'post', 'route' => array('employee.add'), 'class' => 'form', 'files'=>true)) !!}--}}
                                    <form method="post" action="{{route('employee.add')}}" class="form"
                                          enctype="multipart/form-data" id="register_form">

                                        @csrf

                                        {{ Form::hidden('employee_role_id',Auth::guard('employee')->user()->employee_role_id) }}
                                        {{ Form::hidden('report_to',Auth::guard('employee')->user()->id) }}
                                        <div class="row page-sec">
                                            <div class="col-md-6">
                                                <div class="formrow">
                                                    <h6 class="am-sub-title">{{__('Profile Image')}}</h6>
                                                    <div id="thumbnail">
                                                        <img src="{{ asset('/') }}images/user.png">
                                                        {{--                                                {{ ImgUploader::print_image("", 100, 100) }}--}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="formrow">
                                                    <label class="btn btn-default"> {{__('Select Profile Image')}}
                                                        <input type="file" name="image" id="image"
                                                               style="display: none;">
                                                    </label>
                                                    <span class="help-block"> <strong>{{ $errors->first('image') }}</strong> </span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row page-sec">
                                            <div class="col-md-12">
                                                <h6 class="am-sub-title green-color">{{__('Personal Information')}}</h6>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'name') !!}">
                                                    <label class="am-label"><span class="red-color">*</span> {{__('Name')}}:</label>
                                                    {!! Form::text('name', null, array('class'=>'form-control', 'id'=>'name', 'placeholder'=>__('Name'))) !!}
                                                    <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'name') !!}</span>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'national_id_card_number') !!}">
                                                    <label class="am-label"><span class="red-color">*</span> {{__('National ID Card No.')}}:</label>
                                                    {!! Form::text('national_id_card_number', null, array('class'=>'form-control', 'id'=>'national_id_card_number', 'placeholder'=>__('National ID Card No.'))) !!}
                                                    <span class="help-block">  {!! APFrmErrHelp::showErrors($errors, 'national_id_card_number') !!} </span>
                                                </div>
                                            </div>
                                            {{--    <div class="col-md-6">--}}
                                            {{ Form::hidden('country_id', 191, array('id' => 'country_id')) }}
                                            {{--    </div>--}}
                                            <div class="col-md-6">
                                                <input type="hidden" value="{{old('state_id')}}" id="old_states">
                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}">
                                                    <label class="am-label"><span class="red-color">*</span> {{__('State')}}:</label>
                                                    <span id="state_dd">{!! Form::select('state_id', [''=>__('Select State')], null, array('class'=>'form-control', 'id'=>'state_id')) !!}</span>
                                                    <span class="help-block">  {!! APFrmErrHelp::showErrors($errors, 'state_id') !!} </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'city_id') !!}">
                                                    <label class="am-label"><span class="red-color">*</span> {{__('City')}}:</label>
                                                    <span id="city_dd"> {!! Form::select('city_id', [''=>__('Select City')], null, array('class'=>'form-control', 'id'=>'city_id')) !!} </span>
                                                    <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_employer') !!}">
                                                    <label class="am-label"><span class="red-color">*</span> {{__('Job Employer')}}:</label>
                                                    {!! Form::text('job_employer', null, array('class'=>'form-control', 'id'=>'job_employer', 'placeholder'=>__('Job Employer'))) !!}
                                                    {!! APFrmErrHelp::showErrors($errors, 'job_employer') !!} </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_title') !!}">
                                                    <label class="am-label"><span class="red-color">*</span> {{__('Job Title')}}:</label>
                                                    {!! Form::text('job_title', null, array('class'=>'form-control', 'id'=>'job_title', 'placeholder'=>__('Job Title'))) !!}
                                                    <span class="help-block">  {!! APFrmErrHelp::showErrors($errors, 'job_title') !!} </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'email') !!}">
                                                    <label class="am-label"><span class="red-color">*</span> {{__('Email')}}:</label>
                                                    {!! Form::text('email', null, array('class'=>'form-control', 'id'=>'email', 'placeholder'=>__('Email'))) !!}
                                                    <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'email') !!} </span>
                                                </div>
                                            </div>
                                            {{--                                            <div class="col-md-6">--}}
                                            {{--                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'password') !!}"> {!! Form::password('password', array('class'=>'form-control', 'id'=>'password', 'placeholder'=>__('Password'))) !!}--}}
                                            {{--                                                    {!! APFrmErrHelp::showErrors($errors, 'password') !!} </div>--}}
                                            {{--                                            </div>--}}


                                            {{--    <div class="col-md-6">--}}
                                            {{ Form::hidden('nationality_id', 191, array('id' => 'nationality_id')) }}
                                            {{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'nationality_id') !!}"> {!! Form::select('nationality_id', [''=>__('Select Nationality')]+$nationalities, null, array('class'=>'form-control', 'id'=>'nationality_id')) !!}--}}
                                            {{--            {!! APFrmErrHelp::showErrors($errors, 'nationality_id') !!} </div>--}}
                                            {{--    </div>--}}
                                            {{--    <div class="col-md-6">--}}
                                            {{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'date_of_birth') !!}"> {!! Form::text('date_of_birth', null, array('class'=>'form-control datepicker', 'id'=>'date_of_birth', 'placeholder'=>__('Date of Birth'), 'autocomplete'=>'off')) !!}--}}
                                            {{--            {!! APFrmErrHelp::showErrors($errors, 'date_of_birth') !!} </div>--}}
                                            {{--    </div>--}}

                                            <div class="col-md-6">
                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'phone') !!}">
                                                    <label class="am-label"><span class="red-color">*</span> {{__('Phone')}}:</label>
                                                    {!! Form::text('phone', null, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>__('Phone'))) !!}
                                                    <span class="help-block">  {!! APFrmErrHelp::showErrors($errors, 'phone') !!}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'mobile_num') !!}"> {!! Form::text('mobile_num', null, array('class'=>'form-control', 'id'=>'mobile_num', 'placeholder'=>__('Mobile Number'))) !!}--}}
                                                {{--            {!! APFrmErrHelp::showErrors($errors, 'mobile_num') !!} </div>--}}
                                            </div>


                                            {{--                                    <div class="col-md-12">--}}
                                            {{--                                        --}}{{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'street_address') !!}"> {!! Form::textarea('street_address', null, array('class'=>'form-control', 'id'=>'street_address', 'placeholder'=>__('Street Address'))) !!}--}}
                                            {{--                                        --}}{{--            {!! APFrmErrHelp::showErrors($errors, 'street_address') !!} </div>--}}
                                            {{--                                    </div>--}}
                                        </div>
                                        <!-- End personal Information -->

                                        <div class="row page-sec">
                                            <div class="col-md-12 {!! APFrmErrHelp::hasError($errors, 'date_completion.0') !!}">
                                                <h6 class="am-sub-title green-color">{{__('Education / Training')}}</h6>
                                                <table class="table table-bordered table-condensed text-center"
                                                       style="margin-top: 15px">

                                                    <tr class="data-row">
                                                        <td><input type="text" name="degree_title[]"
                                                                   class="form-control"
                                                                   placeholder="{{__('Degree Title')}}"
                                                                   value="{{old('degree_title.0')}}"></td>
                                                        <td><input type="text" name="date_completion[]"
                                                                   class="form-control"
                                                                   placeholder="{{__('Year')}}"
                                                                   value="{{old('date_completion.0')}}"></td>
                                                        <td>
                                                            <button type="button"
                                                                    class="btn btn-secondary add_more"><span
                                                                        class="fa fa-plus"></span></button>
                                                        </td>
                                                    </tr>

                                                    <tbody id="adding_area">
                                                    </tbody>
                                                </table>
                                                <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'date_completion.0') !!} </span>

                                            </div>
                                        </div>

                                        <div class="row page-sec">
                                            <div class="col-md-12">
                                                <div class="formrow{{ $errors->has('uploads[]') ? ' has-error' : '' }}">
                                                    <h6 class="am-sub-title green-color">{{__('Attachments')}}</h6>
                                                    <input type="file" class="form-control-file form-control"
                                                           id="exampleFormControlFile1" name="uploads[]"
                                                           multiple="multiple">
                                                    <small class="hint red-color">{{__('Only .png and .jpg are allowed (max size: 2M)')}}</small>
                                                    <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'uploads[]') !!} </span>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-md-4 pull-left">
                                                <button type="submit" class="btn"><i class="fa fa-arrow-circle-right"
                                                                                     aria-hidden="true"></i> {{__('Save')}}
                                                </button>
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
@push('styles')
    <style type="text/css">
        .employeeccount p {
            text-align: left !important;
        }

        .datepicker > div {
            display: block;
        }
    </style>
@endpush
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            var check = true;
            var totalfilesizes = 0;
            $('#register_form').submit(function () {
                var files = $("#exampleFormControlFile1").get(0).files;

                for (i = 0; i < files.length; i++) {
                    var ext = files[i].name.substr((files[i].name.lastIndexOf('.') + 1));
                    if (ext == 'jpg' || ext == 'png' || ext == 'jpge') {
                    } else {
                        check = false;

                    }
                    totalfilesizes += files[i].size;

                }
                if (totalfilesizes > 2097152) {
                    check = false;
                }
                if (!check) {
                    alert('{{__('Invalid Files')}}');
                }
                return check;


            });
            initdatepicker();
            $('#salary_currency').typeahead({
                source: function (query, process) {
                    return $.get("{{ route('typeahead.currency_codes') }}", {query: query}, function (data) {
                        console.log(data);
                        data = $.parseJSON(data);
                        return process(data);
                    });
                }
            });

            // $('#country_id').on('change', function (e) {
            //     e.preventDefault();
            //     filterStates(0);
            // });
            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterCities(0);
            });
            filterStates($('#old_states').val());

            /*******************************/
            var fileInput = document.getElementById("image");
            fileInput.addEventListener("change", function (e) {
                var files = this.files
                showThumbnail(files)
            }, false)

            function showThumbnail(files) {
                $('#thumbnail').html('');
                for (var i = 0; i < files.length; i++) {
                    var file = files[i]
                    var imageType = /image.*/
                    if (!file.type.match(imageType)) {
                        console.log("Not an Image");
                        continue;
                    }
                    var reader = new FileReader()
                    reader.onload = (function (theFile) {
                        return function (e) {
                            $('#thumbnail').append('<div class="fileattached"><img height="100px" src="' + e.target.result + '" > <div>' + theFile.name + '</div><div class="clearfix"></div></div>');
                        };
                    }(file))
                    var ret = reader.readAsDataURL(file);
                }
            }

            //////////////////////////////add more eductaion field//////////////////
            $(".add_more").click(function () {
                $("#adding_area").append('<tr id="data-row">' +
                    '<td><input type="text" name="degree_title[]" class="form-control" placeholder="{{__('Degree Title')}}"></td>' +
                    '<td><input type="text" name="date_completion[]" class="form-control"placeholder="{{__('Year')}}"></td>' +
                    '<td><button type="button" class="btn btn-danger remove"><span class="glyphicon glyphicon-remove"></span></button></td>' +
                    '</tr>');

                $(".remove").click(function () {
                    $(this).parent().parent().remove();
                });

            });


        });

        function filterStates(state_id) {
            var country_id = $('#country_id').val();
            if (country_id != '') {
                $.post("{{ route('filter.lang.statesAmen.dropdown') }}", {
                    country_id: country_id,
                    state_id: state_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        $('#state_dd').html(response);
                        filterCities(<?php //echo old('city_id', $user->city_id); ?>);
                    });
            }
        }

        function filterCities(city_id) {
            var state_id = $('#state_id').val();
            if (state_id != '') {
                $.post("{{ route('filter.lang.cities.dropdown') }}", {
                    state_id: state_id,
                    city_id: city_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        $('#city_dd').html(response);
                    });
            }
        }

        function initdatepicker() {
            $(".datepicker").datepicker({
                autoclose: true,
                format: 'yyyy-m-d'
            });
        }


    </script>
@endpush
