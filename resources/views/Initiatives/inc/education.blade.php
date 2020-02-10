@if(isset($job))
    {!! Form::model($job, array('method' => 'put', 'route' => array('update.front.Initiatives', $job->id), 'class' => 'form','files'=>true)) !!}
    {!! Form::hidden('id', $job->id) !!}
@else
    {!! Form::open(array('method' => 'post', 'route' => array('store.front.Initiatives'), 'class' => 'form','files'=>true)) !!}
@endif

{{--store-front-initiatives--}}
{{--update-front-initiatives/{id}--}}
<div class="formrow">
    {!! Form::hidden("Initiatives_type", '1') !!}
    <input type="hidden" name="Educations_or_Training_or_Recruiting" value="Educations" />
</div>

<div class="row page-sec">
    <div class="col-md-6 col-xs-6">
        <div class="formrow no-margin-btm">
            <h6 class="am-sub-title green-color">{{__('Company Logo')}}</h6>
            <div id="thumbnail_e">
                @if(isset($job->logo))
{{--                <img src="{{ asset('/') }}company_logos/{!! $job->logo !!}" class="thumbimg">--}}
                    <div class="jobimg thumbimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>
                @else
                    <img src="{{ asset('/') }}admin_assets/no_image.jpg" class="thumbimg">
                @endif

            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-6">
        <div class="formrow  {!! APFrmErrHelp::hasError($errors, 'logo') !!}">
            <label class="btn btn-default">{{__('Upload Organizing Company Logo')}}
                <input type="file" name="logo" id="logo" style="display: none;" >
            </label>
            {!! APFrmErrHelp::showErrors($errors, 'logo') !!}
        </div>
    </div>
</div>

<div class="row page-sec">
    <div class="col-md-12 col-xs-12">
        <h6 class="am-sub-title green-color">{{__('Initiative Details')}}</h6>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'company_organize_name') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Name of the organizing company')}}:</label>
            {!! Form::text('company_organize_name', null, array('class'=>'form-control', 'id'=>'company_organize_name', 'placeholder'=>__('Name of the organizing company'),'data-validation'=>'required' )) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'company_organize_name') !!} </span>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'title') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Initiatives Title')}}:</label>
            {!! Form::text('title', null, array('class'=>'form-control', 'id'=>'title', 'placeholder'=>__('Initiatives Title'),'data-validation'=>'required' )) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'title') !!} </span>
        </div>
    </div>
    <div class="col-md-6 col-xs-12" style="display: none;">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'country_id') !!}"
             id="country_id_div"> {!! Form::select('country_id', ['' => __('Select Country')]+$countries, old('country_id', (isset($job))? $job->country_id:$siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'country_id') !!} </span>
        </div>
    </div>

    <div class="col-md-6 col-xs-12" style="display: none;">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}" id="state_id_div">
            <label class="am-label"><span class="red-color">*</span> {{__('State')}}:</label>
            <span id="default_state_dd"> {!! Form::select('state_id', ['' => __('Select State')], null, array('class'=>'form-control', 'id'=>'state_id')) !!} </span>
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'state_id') !!}</span>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'city_id') !!}" id="city_id_div">
            <label class="am-label"><span class="red-color">*</span> {{__('City')}}:</label>
            <span id="default_city_dd"> {!! Form::select('city_id', ['' => __('Select City')], null, array('class'=>'form-control', 'id'=>'city_id','data-validation'=>'required' )) !!} </span>
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'city_id') !!}</span>
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <p id="datespan_red" class="datespan_red">{{__('Enter valid Date for began and End of Initiative')}} </p>
    </div>
{{--    <div class="col-md-6">--}}
{{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'islamic_data_detail') !!}">--}}
{{--            <label class="am-label"><span class="red-color">*</span> {{__('Initiative Hijri Start Date')}}:</label>--}}
{{--            {!! Form::text('islamic_data_detail',  old('islamic_data_detail'), array('class'=>'form-control ', 'id'=>'islamic_data_detail','placeholder'=>__('Initiative Hijri Start Date'),'autocomplete'=>'off')) !!}--}}
{{--            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'islamic_data_detail') !!} </span>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="formrow ">--}}
{{--        {!! Form::hidden('islamic_data', old('islamic_data'), array('class'=>'form-control', 'id'=>'islamic_data', 'placeholder'=>__('Islamic date'),'autocomplete'=>'off')) !!}--}}
{{--    </div>--}}

    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'gregorian_data') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Initiative Gregorian Start Date')}}:</label>
            {!! Form::text('gregorian_data',old('gregorian_data'), array('class'=>'form-control', 'id'=>'gregorian_data', 'placeholder'=>__('Initiative Gregorian Start Date'),'autocomplete'=>'off','data-validation'=>'required'  )) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'gregorian_data') !!} </span>
        </div>
    </div>


{{--    <div class="col-md-6">--}}
{{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'islamic_data_detail_to') !!}">--}}
{{--            <label class="am-label"><span class="red-color">*</span> {{__('Initiative Hijri End Date')}}:</label>--}}
{{--            {!! Form::text('islamic_data_detail_to',   old('islamic_data_detail_to'), array('class'=>'form-control', 'id'=>'islamic_data_detail_to', 'value'=>'islamic_data_to','placeholder'=>__('Initiative Hijri End Date'),'autocomplete'=>'off')) !!}--}}
{{--            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'islamic_data_detail_to') !!} </span>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="formrow "> {!! Form::hidden('islamic_data_to',   old('islamic_data_to'), array('class'=>'form-control', 'id'=>'islamic_data_to','value'=>'islamic_data_to', 'placeholder'=>__('Islamic date'),'autocomplete'=>'off')) !!}--}}
{{--    </div>--}}
    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'gregorian_data_to') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Initiative Gregorian End Date')}}:</label>
            {!! Form::text('gregorian_data_to',old('gregorian_data_to'), array('class'=>'form-control', 'id'=>'gregorian_data_to', 'placeholder'=>__('Initiative Gregorian End Date'),'autocomplete'=>'off','data-validation'=>'required'  )) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'gregorian_data_to') !!} </span></div>
    </div>
{{--    <div >--}}
{{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'gregorian_data_to') !!}"> {!! Form::hidden('gregorian_data_to',   old('gregorian_data_to'), array('class'=>'form-control', 'id'=>'gregorian_data_to', 'placeholder'=>__('Initiative Gregorian End Date').' *','autocomplete'=>'off')) !!}--}}
{{--            {!! APFrmErrHelp::showErrors($errors, 'gregorian_data_to') !!} </div>--}}
{{--    </div>--}}

    <div >
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'duration_course') !!}" id="duration_course_div">
            {!! Form::hidden('duration_course',old('duration_course') , array('class'=>'form-control', 'id'=>'duration_course', 'placeholder'=>__('Duration of the education Initiative'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'duration_course') !!}
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'expiry_date') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Initiative expiry date')}}:</label>
            {!! Form::text('expiry_date', null, array('class'=>'form-control ', old('expiry_date'),'id'=>'expiry_date', 'placeholder'=>__('Initiative expiry date'), 'autocomplete'=>'off','data-validation'=>'required'  )) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'expiry_date') !!} </span>
        </div>
    </div>
    <div class="col-md-12 col-xs-12" style="margin-bottom: 10px;">
        <p id="datespan_red_2" class="datespan_red">{{__('Please enter the registration deadline before the began of the initiative')}} </p>
    </div>
</div>

<div class="row page-sec">
    <div class="col-md-12 col-xs-12">
        <h6 class="am-sub-title green-color"><small class="red-color">*</small> {{__('required for education Initiative')}}</h6>
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'description') !!}"> {!! Form::textarea('description', null, array('class'=>'form-control', 'id'=>'description' )) !!}
            {!! APFrmErrHelp::showErrors($errors, 'description') !!} </div>
    </div>
</div>

<div class="row" style="margin-top: 30px;">
    <div class="col-md-4 pull-left">
        @if(isset($job))
            <button type="submit"  id="signupBtn_no1"  class="btn"><i class="fa fa-cube" aria-hidden="true"></i> {{__('Edit')}}</button>
        @else
            <button type="submit"  id="signupBtn_no1"  class="btn"><i class="fa fa-cube" aria-hidden="true"></i> {{__('Add New Initiative')}}</button>
        @endif

    </div>
</div>

<input type="file" name="image" id="image" style="display:none;" accept="image/*"/>
<?php
//function HijriToJD($m, $d, $y){
//    return (int)((11 * $y + 3) / 30) + 354 * $y +
//        30 * $m - (int)(($m - 1) / 2) + $d + 1948440 - 385;
//}
//
//
//$date = HijriToJD(10, 14, 1440);//today
//echo jdtogregorian($date);
//
//;?>
{!! Form::close() !!}
@push('styles')
    <style type="text/css">
        .datepicker>div {
            display: block;
        }
    </style>
@endpush
@push('scripts')
    @include('includes.tinyMCEFront')
    <script type="text/javascript">
        $("form").submit(function () {
            $(this).find(":button").filter(function () {
                return !this.value;
            }).attr("disabled", "disabled");
            return true;
        });
        $("form").find(":button").prop("disabled", false);


        function filterLangStates(state_id)
        {
            var country_id = $('#country_id').val();
            var inputId = 't_state_id';
            if (country_id != '') {
                $.post("{{ route('filter.lang.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {

                        $('#default_state_dd').html(response);
                        filterLangCities(<?php echo old('city_id', (isset($job)) ? $job->city_id : 0); ?>);
                    });
            }
        }
        function filterLangCities(city_id)
        {
            var state_id = $('#state_id').val();
            var inputId = 't_city_id';
            if (state_id != '') {
                $.post("{{ route('filter.lang.cities.dropdown') }}", {state_id: state_id, city_id: city_id, new_city_id: inputId, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
            }
        }
        var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();
        $(document).ready(function () {
            $('#country_id').on('change', function (e) {

                e.preventDefault();
                filterLangStates(0);
            });
            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterLangCities(0);
            });
            filterLangStates(<?php

                $state_emp_id=Auth::guard('employee')->user()->state_id;
                echo old('state_id', (isset($job)) ? $job->state_id : $state_emp_id); ?>);
            var fileInput = document.getElementById("logo");
            fileInput.addEventListener("change", function (e) {
                var files = this.files
                showThumbnail(files)
            }, false)

            $('#gregorian_data').daterangepicker({

                minDate: new Date(currentYear, currentMonth, currentDate)
                ,  dateFormat: 'yy-mm-dd'
                    // altField: '#gregorian_data',
                    // altFormat: 'yyyy-mm-dd'
                , startDate: moment(date).add(0, 'days'),

                "singleDatePicker": true,
                // "timePicker": true,
                // "timePicker24Hour": true,
                "autoUpdateInput": false,
                "locale": {
                    "format": "YYYY-MM-DD",
                    // "format": "DD, d MM, yyyy",
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
            }).on('hide.daterangepicker', function(ev, picker) {

                $(this).val(picker.startDate.format('YYYY-MM-DD'));
                event.preventDefault();
                var a = new Date( $('#gregorian_data').val());
                var  b = new Date( $('#expiry_date').val());
                var  c = new Date( $('#gregorian_data_to').val());
                if(a =='' || b==''){
                    $('#datespan_red_2').css('color', 'red');
                    signupBtn_no1.disabled = true;
                }else if( a<b ){
                    $('#datespan_red_2').css('color', 'red');
                    signupBtn_no1.disabled = true;
                }
                // else if(a>b){
                //     $('#datespan_red_2').css('color', 'black');
                //     signupBtn_no1.disabled = false;
                // }
                else  if(a =='' || c==''){
                    document.getElementById("duration_course").value  = 'Date not valid';
                    $('#datespan_red').css('color', 'red');
                    signupBtn_no1.disabled = true;
                }else if( a>c){
                    document.getElementById("duration_course").value  = 'Date not valid';
                    $('#datespan_red').css('color', 'red');
                    signupBtn_no1.disabled = true;
                }else if( a<c && a>b){
                    document.getElementById("duration_course").value  = dateDiffInDays(a, b);
                    $('#datespan_red').css('color', 'black');
                    $('#datespan_red_2').css('color', 'black');
                    signupBtn_no1.disabled = false;
                }
                // console.log(picker.startDate.format('YYYY-DD'));
                // console.log(picker.endDate.format('YYYY-MM-DD'));
            });


            $('#expiry_date').daterangepicker({

                minDate: new Date(currentYear, currentMonth, currentDate)
                , dateFormat:  'yy-mm-dd'
                , startDate: moment(date).add(0, 'days'),

                "singleDatePicker": true,
                // "timePicker": true,
                // "timePicker24Hour": true,
                "autoUpdateInput": false,
                "locale": {
                    // "format": "DD, d MM, yyyy",
                    "format": "YYYY-MM-DD",
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
            }).on('hide.daterangepicker', function(ev, picker) {

                $(this).val(picker.startDate.format('YYYY-MM-DD'));
                event.preventDefault();
                var a = new Date( $('#gregorian_data').val());
                var  b = new Date( $('#expiry_date').val());
                var  c = new Date( $('#gregorian_data_to').val());
                if(a =='' || b==''){
                    $('#datespan_red_2').css('color', 'red');
                    signupBtn_no1.disabled = true;
                }else if( a<b ){
                    $('#datespan_red_2').css('color', 'red');
                    signupBtn_no1.disabled = true;
                }else if(a>b  && a<c){
                    $('#datespan_red_2').css('color', 'black');
                    signupBtn_no1.disabled = false;
                }
                // console.log(picker.startDate.format('YYYY-DD'));
                // console.log(picker.endDate.format('YYYY-MM-DD'));
            });


            $('#gregorian_data_to').daterangepicker({

                minDate: new Date(currentYear, currentMonth, currentDate)
                , dateFormat:  'yy-mm-dd'
                , startDate: moment(date).add(0, 'days'),
               //  altField: '#gregorian_data_to',
               // altFormat: 'DD, d MM, yyyy',
                "singleDatePicker": true,
                // "timePicker": true,
                // "timePicker24Hour": true,
                "autoUpdateInput": false,
                "locale": {
                    "format": "YYYY-MM-DD",
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
            }).on('hide.daterangepicker', function(ev, picker) {

                $(this).val(picker.startDate.format('YYYY-MM-DD'));
                event.preventDefault();
                var a = new Date( $('#gregorian_data').val());
                var  b = new Date( $('#gregorian_data_to').val());
                var  c = new Date( $('#expiry_date').val());
                if(a =='' || b==''){
                    document.getElementById("duration_course").value  = 'Date not valid';
                    $('#datespan_red').css('color', 'red');
                    signupBtn_no1.disabled = true;
                }else if( a>b ){
                    document.getElementById("duration_course").value  = 'Date not valid';
                    $('#datespan_red').css('color', 'red');
                    signupBtn_no1.disabled = true;
                }else if(a<b && a>c){
                    document.getElementById("duration_course").value  = dateDiffInDays(a, b);
                    signupBtn_no1.disabled = false;
                }
                // console.log(picker.startDate.format('YYYY-DD'));
                // console.log(picker.endDate.format('YYYY-MM-DD'));
            });


            const _MS_PER_DAY = 1000 * 60 * 60 * 24;

// a and b are javascript Date objects
            function dateDiffInDays(a, b) {
                // Discard the time and time-zone information.
                const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
                const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

                return Math.floor((utc2 - utc1) / _MS_PER_DAY);
            }



            $('.select2-multiple').select2({
                placeholder: "{{__('Select Required Skills')}}",
                allowClear: true
            });
            // $(".datepicker").datepicker({
            //     autoclose: true,
            //     format: 'yyyy-m-d'
            // });

            function showThumbnail(files) {
                $('#thumbnail_e').html('');
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
                            $('#thumbnail_e').append('<div class="fileattached"><img height="100px" src="' + e.target.result + '" > <div>' + theFile.name + '</div><div class="clearfix"></div></div>');
                        };
                    }(file))
                    var ret = reader.readAsDataURL(file);
                }
            }
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