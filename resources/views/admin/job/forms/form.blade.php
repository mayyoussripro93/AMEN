{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')

<div class="form-body">

    <div class="row">
        <div class="col-md-6">
            <div class="formrow">

                <div id="thumbnail_e">
                    @if(isset($job->logo))
                        {{--                <img src="{{ asset('/') }}company_logos/{!! $job->logo !!}" class="thumbimg">--}}
                        <div class="jobimg thumbimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>
                    @else
                        <img src="{{ asset('/') }}admin_assets/no_image.jpg" class="thumbimg" width="150px" height="150px">
                    @endif

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow">
                <label class="btn btn-default">{{__('Upload Job Logo')}}
                    <input type="file" name="logo" id="logo" style="display: none;">
                </label>
                {!! APFrmErrHelp::showErrors($errors, 'logo') !!}
            </div>
        </div>
    </div>
    {!! Form::hidden("Initiatives_type", '0') !!}
    {!! Form::hidden('id', null) !!}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'title') !!}">
        {!! Form::label('title', __('Job title'), ['class' => 'bold']) !!}
        {!! Form::text('title', null, array('class'=>'form-control', 'id'=>'title', 'placeholder'=> __('Job title'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'title') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'description') !!}">
        {!! Form::label('description',  __('Job Requirements'), ['class' => 'bold']) !!}
        {!! Form::textarea('description', null, array('class'=>'form-control', 'id'=>'description', 'placeholder'=>__('Job Requirements'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'description') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'project_id') !!}" id="project_id_div">
        {!! Form::label('project_id', __('Project Name'), ['class' => 'bold']) !!}
        {!! Form::select('project_id', ['' => __('Select Project')]+$projects, old('project_id'), array('class'=>'form-control', 'id'=>'project_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'project_id') !!}
    </div>

        <div class="form-group  {!! APFrmErrHelp::hasError($errors, 'employee_id') !!}" id="employee_id_div">
            <label class="am-label bold">{{__('Employee Name')}} <span class="red-color">*</span></label>
            <span id="default_employee_dd">
           {!! Form::select('employee_id', ['' => __('Select Employee')],  null, array('class'=>'form-control ', 'id'=>'employee_id')) !!}
           </span>
            <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'employee_id') !!}</span>
        </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_id') !!}" style="display: none" id="country_id_div">
        {!! Form::label('country_id', 'Country', ['class' => 'bold']) !!}
        {!! Form::select('country_id', ['' => 'Select Country']+$countries, old('country_id', (isset($job))? $job->country_id:$siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'country_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'state_id') !!}"  style="display: none"  id="state_id_div">
        {!! Form::label('state_id', 'State', ['class' => 'bold']) !!}
        <span id="default_state_dd">
            {!! Form::select('state_id', ['' => 'Select State'], null, array('class'=>'form-control', 'id'=>'state_id')) !!}
        </span>
        {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'city_id') !!}" id="city_id_div">
        {!! Form::label('city_id', __('City'), ['class' => 'bold']) !!}
        <span id="default_city_dd">
            {!! Form::select('city_id', ['' => __('Select City')], null, array('class'=>'form-control', 'id'=>'city_id')) !!}
        </span>
        {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'salary_from') !!}" id="salary_from_div">
        {!! Form::label('salary_from', __('Salary from'), ['class' => 'bold']) !!}
        {!! Form::number('salary_from', null, array('class'=>'form-control', 'id'=>'salary_from')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'salary_from') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'salary_to') !!}" id="salary_to_div">
        {!! Form::label('salary_to', __('Salary to'), ['class' => 'bold']) !!}
        {!! Form::number('salary_to', null, array('class'=>'form-control', 'id'=>'salary_to')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'salary_to') !!}
    </div>


    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}" id="functional_area_id_div">
        {!! Form::label('functional_area_id', __('Functional Area'), ['class' => 'bold']) !!}
        {!! Form::select('functional_area_id', ['' => __('Select Functional Area')]+$functionalAreas, null, array('class'=>'form-control', 'id'=>'functional_area_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'degree_level_id') !!}" id="degree_level_id_div">
        {!! Form::label('degree_level_id', __('Degree Level'), ['class' => 'bold']) !!}
        {!! Form::select('degree_level_id', ['' => __('Select Degree Level')]+$degreeLevels, null, array('class'=>'form-control', 'id'=>'degree_level_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'degree_level_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}" id="job_experience_id_div">
        {!! Form::label('job_experience_id', __('Job Experience'), ['class' => 'bold']) !!}
        {!! Form::select('job_experience_id', ['' => __('Select Job Experience')]+$jobExperiences, null, array('class'=>'form-control', 'id'=>'job_experience_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'job_experience_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'skills') !!}">
        {!! Form::label('skills', __('Job Skills'), ['class' => 'bold']) !!}
        <?php
        $skills = old('skills', $jobSkillIds);
        ?>
        {!! Form::select('skills[]', $jobSkills, $skills, array('class'=>'form-control select2-multiple', 'id'=>'skills', 'multiple'=>'multiple')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'skills') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'expiry_date') !!}">
        {!! Form::label('expiry_date', __('Initiative expiry date'), ['class' => 'bold']) !!}
        {!! Form::text('expiry_date', null, array('class'=>'form-control ', 'id'=>'expiry_date', 'placeholder'=> __('Initiative expiry date'), 'autocomplete'=>'off')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'expiry_date') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', __('Initiative Is Active?'), ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_active_1 = 'checked="checked"';
            $is_active_2 = '';
            if (old('is_active', ((isset($job)) ? $job->is_active : 1)) == 0) {
                $is_active_1 = '';
                $is_active_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="active" name="is_active" type="radio" value="1" {{$is_active_1}}>
                {{__('Yes')}} </label>
            <label class="radio-inline">
                <input id="not_active" name="is_active" type="radio" value="0" {{$is_active_2}}>
                {{__('No')}} </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_active') !!}
    </div>

    <div class="form-actions">
        {!! Form::button('حفظ <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary',  'id'=>"signupBtn_no1",'type'=>'submit')) !!}
    </div>
</div>
@push('css')
    <style type="text/css">
        .datepicker>div {
            display: block;
        }
        .btn.btn-large.btn-primary {
            width: 100%;
        }
        .jobimg.thumbimg img {
            width: 150px;
            height: 150px;
        }
    </style>
@endpush

@push('scripts')
    @include('admin.shared.tinyMCEFront')
    {{--<script src="{{asset('/')}}js/jquery.calendars.islamic.js"></script>--}}



    <script type="text/javascript">
        var fileInput = document.getElementById("logo");
        fileInput.addEventListener("change", function (e) {
            var files = this.files
            showThumbnail(files)
        }, false)

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
        $('.select2-multiple').select2({
            placeholder: "{{__('Select Required Skills')}}",
            allowClear: true
        });
        var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();
        $(document).ready(function () {
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

            $('#country_id').on('change', function (e) {

                e.preventDefault();
                filterLangStates(0);
            });
            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterLangCities(0);

            });

            filterLangStates(<?php echo old('state_id', (isset($job)) ? $job->state_id : 0); ?>);

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

            $(document).on('change', '#project_id', function (e) {

                e.preventDefault();
                filterLangStates(0);
                filterProjectEmployee(0);
                var project_id= $(this).val();
                if (project_id != '') {
                    var oldValue = "<?php echo old('state_id', (isset($job)) ? $job->state_id : 0); ?>";
                    if(oldValue == 0){
                        $.post("{{ route('project.states') }}", {project_id: project_id,_method: 'POST', _token: '{{ csrf_token() }}'})
                            .done(function (response) {
                                $('#default_state_dd').html(response);
                                if(oldValue == 0){
                                    oldValue =  response
                                }
                                filterLangStates(oldValue);
                            });
                    }else{
                        filterLangStates(oldValue);
                    }

                }
        });

        filterProjectEmployee(<?php echo old('employee_id', (isset($job)) ? $job->employee_id : 0); ?>);

        function filterProjectEmployee(employee_id) {
            var project_id = $('#project_id').val();
            var inputId = 't_employee_id';
            if (project_id != '') {
                $.post("{{ route('filter.project.employee.dropdown') }}", {
                    project_id: project_id,
                    employee_id: employee_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {

                        $('#default_employee_dd').html(response);

                    });
            }
        }










            const _MS_PER_DAY = 1000 * 60 * 60 * 24;

// a and b are javascript Date objects
            function dateDiffInDays(a, b) {
                // Discard the time and time-zone information.
                const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
                const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

                return Math.floor((utc2 - utc1) / _MS_PER_DAY);
            }




            var date = new Date();
            var currentMonth = date.getMonth();
            var currentDate = date.getDate();
            var currentYear = date.getFullYear();

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
            // console.log(picker.startDate.format('YYYY-DD'));
            // console.log(picker.endDate.format('YYYY-MM-DD'));
        });

    </script>
@endpush