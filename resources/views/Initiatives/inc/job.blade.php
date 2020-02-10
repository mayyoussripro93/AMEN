@if(isset($job))
    {!! Form::model($job, array('method' => 'put', 'route' => array('update.front.job', $job->id), 'class' => 'form','files'=>true)) !!}
    {!! Form::hidden('id', $job->id) !!}
@else
    {!! Form::open(array('method' => 'post', 'route' => array('store.front.job'), 'class' => 'form','files'=>true)) !!}
@endif

<div class="col-md-12 col-xs-12">
    <div class="formrow"> {!! Form::hidden("Initiatives_type", '0') !!}</div>
    <input type="hidden" name="Educations_or_Training_or_Recruiting" value="Recruiting"/>
</div>

<div class="row page-sec">
    <div class="col-md-6 col-xs-6">
        <div class="formrow no-margin-btm">
            <h6 class="am-sub-title green-color">{{__('Job Logo')}}</h6>
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
            <label class="btn btn-default">{{__('Upload Job Logo')}}
                <input type="file" name="logo" id="logo" style="display: none;">
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
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'project_id') !!}" id="country_id_div">
            <label class="am-label"><span class="red-color">*</span> {{__('Project Name')}}:</label>
            {!! Form::select('project_id', ['' => __('Select Project')]+$projects, null, array('class'=>'form-control', 'id'=>'project_id','data-validation'=>'required')) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'project_id') !!}</span>
        </div>
    </div>
    <div class="col-md-6 col-xs-12" style="display: none;">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'country_id') !!}"
             id="country_id_div"> {!! Form::select('country_id', ['' => __('Select Country')]+$countries, old('country_id', (isset($job))? 191:191), array('class'=>'form-control', 'id'=>'country_id',)) !!}
            {!! APFrmErrHelp::showErrors($errors, 'country_id') !!} </div>
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
            <span id="default_city_dd"> {!! Form::select('city_id', ['' => __('Select City')], null, array('class'=>'form-control', 'id'=>'city_id','data-validation'=>'required')) !!} </span>
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'city_id') !!}</span>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'title') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Job title')}}:</label>
            {!! Form::text('title', null, array('class'=>'form-control', 'id'=>'title', 'value'=>"fdgf",'placeholder'=>__('Job title'),'data-validation'=>'required')) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'title') !!}</span>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}" id="functional_area_id_div">
            <label class="am-label"><span class="red-color">*</span> {{__('Functional Area')}}:</label>
            {!! Form::select('functional_area_id', ['' => __('Select Functional Area')]+$functionalAreas, null, array('class'=>'form-control', 'id'=>'functional_area_id','data-validation'=>'required')) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!}</span>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'degree_level_id') !!}" id="degree_level_id_div">
            <label class="am-label"><span class="red-color">*</span> {{__('Degree Level')}}:</label>
            {!! Form::select('degree_level_id', ['' =>__('Select Required Degree Level')]+$degreeLevels, null, array('class'=>'form-control', 'id'=>'degree_level_id','data-validation'=>'required')) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'degree_level_id') !!}</span>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}" id="job_experience_id_div">
            <label class="am-label"><span class="red-color">*</span> {{__('Job Experience')}}:</label>
            {!! Form::select('job_experience_id', ['' => __('Select Required job experience')]+$jobExperiences, null, array('class'=>'form-control', 'id'=>'job_experience_id','data-validation'=>'required')) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'job_experience_id') !!}</span>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_from') !!}" id="salary_from_div">
            <label class="am-label">{{__('Salary from (SAR)')}}:</label>
            {!! Form::number('salary_from', null, array('class'=>'form-control', 'id'=>'salary_from','min'=>'1','placeholder'=>__('Salary from (SAR)'),'data-validation'=>'required')) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'salary_from') !!}</span>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_to') !!}" id="salary_to_div">
            <label class="am-label">{{__('Salary to (SAR)')}}:</label>
            {!! Form::number('salary_to', null, array('class'=>'form-control', 'id'=>'salary_to','min'=>'1','placeholder'=>__('Salary to (SAR)'),'data-validation'=>'required')) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'salary_to') !!}</span>
        </div>

    </div>

        <div id="price-feedback" style="color: red" >يجب ان يكون (الراتب إلى) اكبر من (الراتب من)</div>

{{--  <div class="col-md-6">--}}
{{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_currency') !!}" id="salary_currency_div">--}}
{{--            @php--}}
{{--                $salary_currency = Request::get('salary_currency', (isset($job))? $job->salary_currency:$siteSetting->default_currency_code);--}}
{{--            @endphp--}}

{{--            {!! Form::select('salary_currency', ['' => __('Select Salary Currency')]+$currencies, $salary_currency, array('class'=>'form-control', 'id'=>'salary_currency')) !!}--}}
{{--            {!! APFrmErrHelp::showErrors($errors, 'salary_currency') !!} </div>--}}
{{--    </div>--}}
{{--    <div class="col-md-4">--}}
{{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_period_id') !!}"--}}
{{--             id="salary_period_id_div"> {!! Form::select('salary_period_id', ['' => __('Select Salary Period')]+$salaryPeriods, null, array('class'=>'form-control', 'id'=>'salary_period_id')) !!}--}}
{{--            {!! APFrmErrHelp::showErrors($errors, 'salary_period_id') !!} </div>--}}
{{--    </div>--}}
<!--<div class="col-md-4">
{{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'hide_salary') !!}"> {!! Form::label('hide_salary', __('Hide Salary?'), ['class' => 'bold']) !!}--}}
        <div class="radio-list">
<?php
//                $hide_salary_1 = '';
//                $hide_salary_2 = 'checked="checked"';
//                if (old('hide_salary', ((isset($job)) ? $job->hide_salary : 0)) == 1) {
//                    $hide_salary_1 = 'checked="checked"';
//                    $hide_salary_2 = '';
//                }
//                ?>
        <label class="radio-inline">
{{--                    <input id="hide_salary_yes" name="hide_salary" type="radio" value="1" {{$hide_salary_1}}>--}}
{{--                    {{__('Yes')}} </label>--}}
{{--                <label class="radio-inline">--}}
{{--                    <input id="hide_salary_no" name="hide_salary" type="radio" value="0" {{$hide_salary_2}}>--}}
{{--                    {{__('No')}} </label>--}}
        </div>
{{--            {!! APFrmErrHelp::showErrors($errors, 'hide_salary') !!} </div>--}}
        </div>-->

    {{--    <div class="col-md-6">--}}
    {{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'career_level_id') !!}"--}}
    {{--             id="career_level_id_div"> {!! Form::select('career_level_id', ['' => __('Select Career level')]+$careerLevels, null, array('class'=>'form-control', 'id'=>'career_level_id')) !!}--}}
    {{--            {!! APFrmErrHelp::showErrors($errors, 'career_level_id') !!} </div>--}}
    {{--    </div>--}}

    {{--    <div class="col-md-6">--}}
    {{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_type_id') !!}"--}}
    {{--             id="job_type_id_div"> {!! Form::select('job_type_id', ['' => __('Select Job Type')]+$jobTypes, null, array('class'=>'form-control', 'id'=>'job_type_id')) !!}--}}
    {{--            {!! APFrmErrHelp::showErrors($errors, 'job_type_id') !!} </div>--}}
    {{--    </div>--}}
    {{--    <div class="col-md-6">--}}
    {{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_shift_id') !!}"--}}
    {{--             id="job_shift_id_div"> {!! Form::select('job_shift_id', ['' => __('Select Job Shift')]+$jobShifts, null, array('class'=>'form-control', 'id'=>'job_shift_id')) !!}--}}
    {{--            {!! APFrmErrHelp::showErrors($errors, 'job_shift_id') !!} </div>--}}
    {{--    </div>--}}
    {{--    <div class="col-md-6">--}}
    {{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'num_of_positions') !!}"--}}
    {{--             id="num_of_positions_div"> {!! Form::select('num_of_positions', ['' => __('Select number of Positions')]+MiscHelper::getNumPositions(), null, array('class'=>'form-control', 'id'=>'num_of_positions')) !!}--}}
    {{--            {!! APFrmErrHelp::showErrors($errors, 'num_of_positions') !!} </div>--}}
    {{--    </div>--}}
    {{--    <div class="col-md-6">--}}
    {{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'gender_id') !!}"--}}
    {{--             id="gender_id_div"> {!! Form::select('gender_id', ['' => __('No preference')]+$genders, null, array('class'=>'form-control', 'id'=>'gender_id')) !!}--}}
    {{--            {!! APFrmErrHelp::showErrors($errors, 'gender_id') !!} </div>--}}
    {{--    </div>--}}


    <div class="col-md-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'expiry_date') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Initiative expiry date')}}:</label>
            {!! Form::text('expiry_date', null, array('class'=>'form-control', 'id'=>'expiry_date', 'placeholder'=>__('Initiative expiry date'), 'autocomplete'=>'off','data-validation'=>'required')) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'expiry_date') !!}</span>
        </div>
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'skills') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Select Required Skills')}}:</label>
            <?php
            $skills = old('skills', $jobSkillIds);
            ?>
            {!! Form::select('skills[]', $jobSkills, $skills, array('class'=>'form-control select2-multiple', 'id'=>'skills', 'multiple'=>'multiple','data-validation'=>'required')) !!}
            <span class="help-block">{!! APFrmErrHelp::showErrors($errors, 'skills') !!} </span>
        </div>
        <div class="invalid-feedback" style="color: red"> {{__('Please Select Required Skills')}}</div>
    </div>

<!--<div class="col-md-6">
{{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'is_freelance') !!}"> {!! Form::label('is_freelance', __('Is Freelance?'), ['class' => 'bold']) !!}--}}
        <div class="radio-list">
<?php
//                $is_freelance_1 = '';
//                $is_freelance_2 = 'checked="checked"';
//                if (old('is_freelance', ((isset($job)) ? $job->is_freelance : 0)) == 1) {
//                    $is_freelance_1 = 'checked="checked"';
//                    $is_freelance_2 = '';
//                }
?>
{{--                <label class="radio-inline">--}}
{{--                    <input id="is_freelance_yes" name="is_freelance" type="radio" value="1" {{$is_freelance_1}}>--}}
{{--                    {{__('Yes')}} </label>--}}
{{--                <label class="radio-inline">--}}
{{--                    <input id="is_freelance_no" name="is_freelance" type="radio" value="0" {{$is_freelance_2}}>--}}
{{--                    {{__('No')}} </label>--}}
{{--            </div>--}}
{{--            {!! APFrmErrHelp::showErrors($errors, 'is_freelance') !!} </div>--}}
        </div>-->
</div>

<div class="row page-sec">
    <div class="col-md-12 col-xs-12">
        <h6 class="am-sub-title green-color">{{__('Job Requirements')}} <small class="red-color">*</small></h6>
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'description') !!}"> {!! Form::textarea('description', null, array('class'=>'form-control', 'id'=>'description', 'placeholder'=>__('Job Description'),'data-validation'=>'required')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'description') !!} </div>
        <div class="invalid-feedback" style="color: red"> {{__('Please Job Requirements')}}</div>
    </div>
</div>
<div class="row" style="margin-top: 30px;">
    <div class="col-md-4 pull-left">
        @if(isset($job))
            <button type="submit" class="btn " id="signupBtn_no1" ><i class="fa fa-cube" aria-hidden="true"></i> {{__('Edit')}}</button>
        @else
            <button type="submit" class="btn " id="signupBtn_no1" ><i class="fa fa-cube" aria-hidden="true"></i> {{__('Add New Initiative')}}
            </button>
        @endif

    </div>
</div>

<input type="file" name="image" id="image" style="display:none;" accept="image/*"/>
{!! Form::close() !!}
@push('styles')
    <style type="text/css">
        .datepicker > div {
            display: block;
        }
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-search--inline .select2-search__field,
        .select2-container .select2-search--inline {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--multiple {
            border-color: #ddd !important;
        }
        .rtl .radio-inline {
            padding-left: 0;
            padding-right: 20px;
        }
        .radio-inline {
            margin-top: 5px;
        }
        .rtl .radio-inline input[type=radio] {
            margin-left: 0;
            margin-right: -20px;
        }
        .formpanel label {
            margin-bottom: 0;
            margin-left: 10px;
            display: inline-block;
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
        $(document).ready(function () {
            // document.getElementById("salary_to").min = document.getElementById("salary_from").value;

            $('#salary_from').keyup( function (e) {
                var afrom = parseInt(document.getElementById("salary_from").value) ;
                var bto = parseInt( document.getElementById("salary_to").value ) ;


                if( afrom >=  bto){

                    $('#price-feedback').css('color', 'red');
                    signupBtn_no1.disabled = true;

                } else{
                    signupBtn_no1.disabled =false ;


                }});

            $('#salary_to').keyup(function (e) {
                var afrom = parseInt(document.getElementById("salary_from").value) ;
                var bto = parseInt( document.getElementById("salary_to").value ) ;

                if( afrom >=  bto){

                    $('#price-feedback').css('color', 'red');
                    signupBtn_no1.disabled = true;

                } else{
                    signupBtn_no1.disabled =false ;


                }});

            var fileInput = document.getElementById("logo");
            fileInput.addEventListener("change", function (e) {
                var files = this.files
                showThumbnail(files)
            }, false)
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
        });
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
        var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();
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
            // console.log(picker.startDate.format('YYYY-DD'));
            // console.log(picker.endDate.format('YYYY-MM-DD'));
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