{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'employee_id') !!}"  id="employee_id_div">
        {!! Form::label('employee_id', __('Employee Name'), ['class' => 'bold']) !!}
        {!! Form::select('employee_id', ['' => __('Select Employee')]+$employees, old('employee_id'), array('class'=>'form-control', 'id'=>'employee_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'employee_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'event_name') !!}">
        {!! Form::label('event_name', __('Meeting Title'), ['class' => 'bold']) !!}
        {!! Form::text('event_name', null, array('class'=>'form-control', 'id'=>'event_name', 'placeholder'=>__('Meeting Title'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'event_name') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'consultant') !!}">
        {!! Form::label('consultant', __('Project Name'), ['class' => 'bold']) !!}
        {!! Form::select('consultant', ['' => __('Select Project')]+$projects, old('consultant'), array('class'=>'form-control', 'id'=>'consultant')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'consultant') !!}
    </div>



    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'start_date') !!}" id="start_date_div">
        {!! Form::label('salary_from', __('Start Date'), ['class' => 'bold']) !!}
        {!! Form::input('text','start_date', null, ['id'=>'start_date','class' => 'form-control','autocomplete'=>"off"]) !!}
        {!! APFrmErrHelp::showErrors($errors, 'start_date') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'end_date') !!}" id="end_date_div">
        {!! Form::label('end_date', __('End Date'), ['class' => 'bold']) !!}
        {!! Form::input('text','end_date',null, ['id'=>'end_date','class' => 'form-control','min'=> date('Y-m-d\TH:i',strtotime(Carbon\Carbon::now())),'autocomplete'=>"off"]) !!}
        {!! APFrmErrHelp::showErrors($errors, 'end_date') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'description') !!}" id="description_div">
        {!! Form::label('description', __('Meating Detail'), ['class' => 'bold']) !!}
        {!! Form::input('text','description',null, ['id'=>'description','class' => 'form-control','autocomplete'=>"off"]) !!}
        {!! APFrmErrHelp::showErrors($errors, 'description') !!}
    </div>
    <span id="datespan_red_2"
          class="datespan_red" style="display: none;">{{__('Please enter valid end for event')}} </span>


    <div class="form-actions">
        {!! Form::button('حفظ <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary','id'=>'sub_1', 'type'=>'submit')) !!}
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
</style>
@endpush
@push('scripts')
@include('admin.shared.tinyMCEFront')
<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('change', '#employee_id', function (e) {
            e.preventDefault();
            filterEmployeeProject(0);
        });

        function filterEmployeeProject(consultant) {
            var employee_id = $('#employee_id').val();
            var inputId = 't_employee_id';
            if (employee_id != '') {
                $.post("{{ route('employee.Project.admin') }}", {
                    project_id: consultant,
                    employee_id: employee_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {

                        $('#consultant').html(response);



                    });
            }
        }


        $('.select2-multiple').select2({
            placeholder: "{{__('Select Required Skills')}}",
            allowClear: true
        });
        // $(".datepicker").datepicker({
        //     autoclose: true,
        //     format: 'yyyy-m-d'
        // });

        var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();


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
            }).on('apply.daterangepicker', function(ev, picker) {

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
            }).on('apply.daterangepicker', function(ev, picker) {

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
    });




</script>
@endpush