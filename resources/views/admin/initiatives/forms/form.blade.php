{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    {!! Form::hidden('id', null) !!}
    @if(urldecode($_GET['Initiatives_type']) == 'Learning')
        {!! Form::hidden("Initiatives_type", '1') !!}

    @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
        {!! Form::hidden("Initiatives_type", '2') !!}
    @endif


    <div class="row">
        <div class="col-md-6">
            <div class="formrow">

                <div id="thumbnail_e">
                    @if(isset($job->logo))
                        {{--                <img src="{{ asset('/') }}company_logos/{!! $job->logo !!}" class="thumbimg">--}}
                        <div class="jobimg thumbimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>
                    @else
                        <img src="{{ asset('/') }}admin_assets/no_image.jpg" class="thumbimg" width="150" height="150">
                    @endif

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow">
                <label class="btn btn-default">{{__('Upload Organizing Company Logo')}}
                    <input type="file" name="logo" id="logo" style="display: none;">
                </label>
                {!! APFrmErrHelp::showErrors($errors, 'logo') !!}
            </div>
        </div>
    </div>
{{--    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'company_id') !!}" id="company_id_div">--}}
{{--        {!! Form::label('company_id', 'Company', ['class' => 'bold']) !!}                    --}}
{{--        {!! Form::select('company_id', ['' => 'Select Company']+$companies, null, array('class'=>'form-control', 'id'=>'company_id')) !!}--}}
{{--        {!! APFrmErrHelp::showErrors($errors, 'company_id') !!}                                       --}}
{{--    </div>--}}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'company_organize_name') !!}">
        {!! Form::label('company_organize_name', __('Name of the organizing company'), ['class' => 'bold']) !!}
        {!! Form::text('company_organize_name', null, array('class'=>'form-control', 'id'=>'company_organize_name', 'placeholder'=>__('Name of the organizing company'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'company_organize_name') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'title') !!}">
        {!! Form::label('title', __('Initiatives Title'), ['class' => 'bold']) !!}
        {!! Form::text('title', null, array('class'=>'form-control', 'id'=>'title', 'placeholder'=>__('Initiatives Title'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'title') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'description') !!}">
        {!! Form::label('description', __('Initiative Details'), ['class' => 'bold']) !!}
        {!! Form::textarea('description', null, array('class'=>'form-control', 'id'=>'description', 'placeholder'=>__('Initiative Details'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'description') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_id') !!}"  style="display: none;" id="country_id_div">
        {!! Form::label('country_id', 'Country', ['class' => 'bold']) !!}                    
        {!! Form::select('country_id', ['' => 'Select Country']+$countries, old('country_id', (isset($job))? $job->country_id:$siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'country_id') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'state_id') !!}" id="state_id_div">
        {!! Form::label('state_id', __('State'), ['class' => 'bold']) !!}
        <span id="default_state_dd">
            {!! Form::select('state_id', ['' => __('Select State')], null, array('class'=>'form-control', 'id'=>'state_id')) !!}
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

        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'employee_id') !!}" id="employee_id_div">
            <label class="am-label bold">{{__('Employee Name')}} <span class="red-color">*</span></label>
            <span id="default_employee_dd">

                {!! Form::select('employee_id', ['' => __('Select Employee')],  old('employee_id'), array('class'=>'form-control ', 'id'=>'employee_id')) !!}
        </span>
            <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'employee_id') !!}</strong></span>
        </div>

{{--        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'islamic_data_detail') !!}">--}}
{{--            {!! Form::label('islamic_data_detail', 'The date of the Education Initiative began', ['class' => 'bold']) !!}--}}
{{--            {!! Form::text('islamic_data_detail', null, array('class'=>'form-control', 'id'=>'islamic_data_detail', 'placeholder'=>'The date of the Education Initiative began', 'autocomplete'=>'off')) !!}--}}
{{--            {!! APFrmErrHelp::showErrors($errors, 'islamic_data_detail') !!}--}}
{{--        </div>--}}
{{--    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'islamic_data') !!}">--}}
{{--        {!! Form::label('islamic_data', 'islamic date start', ['class' => 'bold']) !!}--}}
{{--        {!! Form::hidden('islamic_data', null, array('class'=>'form-control', 'id'=>'islamic_data', 'placeholder'=>'islamic date start', 'autocomplete'=>'off')) !!}--}}
{{--        {!! APFrmErrHelp::showErrors($errors, 'islamic_data') !!}--}}
{{--    </div>--}}
{{--    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'gregorian_data_detail') !!}">--}}
{{--        {!! Form::label('gregorian_data_detail', 'Gregorian date start', ['class' => 'bold']) !!}--}}
{{--        {!! Form::text('gregorian_data_detail', null, array('class'=>'form-control', 'id'=>'gregorian_data_detail', 'placeholder'=>'Gregorian date start', 'autocomplete'=>'off')) !!}--}}
{{--        {!! APFrmErrHelp::showErrors($errors, 'gregorian_data_detail') !!}--}}
{{--    </div>--}}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'gregorian_data') !!}">
        {!! Form::label('gregorian_data', __('Initiative Gregorian Start Date'), ['class' => 'bold']) !!}
        {!! Form::text('gregorian_data', null, array('class'=>'form-control', 'id'=>'gregorian_data', 'placeholder'=>__('Initiative Gregorian Start Date'), 'autocomplete'=>'off')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'gregorian_data') !!}
    </div>
{{--    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'islamic_data_detail_to') !!}">--}}
{{--        {!! Form::label('islamic_data_detail_to', 'The date of the Education Initiative End', ['class' => 'bold']) !!}--}}
{{--        {!! Form::text('islamic_data_detail_to', null, array('class'=>'form-control', 'id'=>'islamic_data_detail_to', 'placeholder'=>'The date of the Education Initiative End', 'autocomplete'=>'off')) !!}--}}
{{--        {!! APFrmErrHelp::showErrors($errors, 'islamic_data_detail_to') !!}--}}
{{--    </div>--}}
{{--    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'islamic_data_to') !!}">--}}
{{--        {!! Form::label('islamic_data_to', 'Islamic date End', ['class' => 'bold']) !!}--}}
{{--        {!! Form::hidden('islamic_data_to', null, array('class'=>'form-control', 'id'=>'islamic_data_to', 'placeholder'=>'Islamic date End', 'autocomplete'=>'off')) !!}--}}
{{--        {!! APFrmErrHelp::showErrors($errors, 'islamic_data_to') !!}--}}
{{--    </div>--}}
{{--    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'gregorian_data_detail_to') !!}">--}}
{{--        {!! Form::label('gregorian_data_detail_to', 'Gregorian date End', ['class' => 'bold']) !!}--}}
{{--        {!! Form::text('gregorian_data_detail_to', null, array('class'=>'form-control', 'id'=>'gregorian_data_detail_to', 'placeholder'=>'Gregorian date End', 'autocomplete'=>'off')) !!}--}}
{{--        {!! APFrmErrHelp::showErrors($errors, 'gregorian_data_detail_to') !!}--}}
{{--    </div>--}}
<div class="form-group {!! APFrmErrHelp::hasError($errors, 'gregorian_data_to') !!}">
    {!! Form::label('gregorian_data_to', __('Initiative Gregorian End Date'), ['class' => 'bold']) !!}
    {!! Form::text('gregorian_data_to', null, array('class'=>'form-control', 'id'=>'gregorian_data_to', 'placeholder'=>__('Initiative Gregorian End Date'), 'autocomplete'=>'off')) !!}
    {!! APFrmErrHelp::showErrors($errors, 'gregorian_data_to') !!}
</div>
    <div class="form-group" style="margin-bottom: 10px;color: red">
        <small id="datespan_red" class="datespan_red">{{__('Enter valid Date for began and End of Initiative')}}</small>
    </div>
{{--    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'duration_course') !!}">--}}
{{--        {!! Form::label('duration_course', 'Duration of the education Initiative', ['class' => 'bold']) !!}--}}
        {!! Form::hidden('duration_course', null, array('class'=>'form-control', 'id'=>'duration_course', 'placeholder'=>'Duration of the education Initiative', 'autocomplete'=>'off')) !!}
{{--        {!! APFrmErrHelp::showErrors($errors, 'duration_course') !!}--}}
{{--    </div>--}}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'expiry_date') !!}">
        {!! Form::label('expiry_date', __('Initiative expiry date'), ['class' => 'bold']) !!}
        {!! Form::text('expiry_date', null, array('class'=>'form-control', 'id'=>'expiry_date', 'placeholder'=>__('Initiative expiry date'), 'autocomplete'=>'off')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'expiry_date') !!}
    </div>
    <div class="form-group" style="margin-bottom: 10px;color: red">
        <small id="datespan_red_2" class="datespan_red">{{__('Please enter the registration deadline before the began of the initiative')}}</small>
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
        {!! Form::button('حفظ <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'id'=>'signupBtn_no1','type'=>'submit')) !!}
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
            filterEmployeeStates(0);
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
                    filterEmployeeStates(<?php echo old('employee_id', (isset($job)) ? $job->employee_id : 0); ?>);
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





        function filterEmployeeStates(employee_id) {
            var state_id = $('#state_id').val();
            var inputId = 't_employee_id';
            if (state_id != '') {
                $.post("{{ route('employee.states') }}", {
                    state_id: state_id,
                    employee_id: employee_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {

                        $('#default_employee_dd').html(response);

                        {{--$('.select2-multiple').select2({--}}
                        {{--    placeholder: "{{ __('Select Employee')}}",--}}
                        {{--    allowClear: true--}}
                        {{--})--}}

                    });
            }
        }





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
                }else if( a<=b ){
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
                }else if( a>=c){
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
                }else if( a<=b ){
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
                }else if( a>=b ){
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
                        $('#thumbnail_e').append('<div class="fileattached"><img height="150" width="150" src="' + e.target.result + '" > <div>' + theFile.name + '</div><div class="clearfix"></div></div>');
                    };
                }(file))
                var ret = reader.readAsDataURL(file);
            }
        }


    });


</script>
@endpush