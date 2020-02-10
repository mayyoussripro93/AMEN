<div class="form-body">
{{--    <h4 class="am-sub-title" style="margin-bottom: 15px;"><span class="green-color">{{__('Project Name')}}:</span> {{$project->name}}</h4>--}}
    <div class="row page-sec">
        <div class="col-md-12">
            <h6 class="am-sub-title green-color">{{__('Violation Details')}}</h6>
        </div>

        <div class="col-md-6">
            <div class="formrow {{ $errors->has('description') ? ' has-error' : '' }} no-margin-btm">
                <label class="am-label"><span class="red-color">*</span> {{__('Violation Date')}}:</label>
                @php $gregorian_date_str=isset($violation->gregorian_date) ? $violation->gregorian_date .''. $violation->violation_time : old('gregorian_date_str') @endphp
                {!! Form::text('gregorian_date_str',$gregorian_date_str!=''? $gregorian_date_str :null, array('class'=>'form-control', 'id'=>'gregorian_date', 'placeholder'=>__('Violation Date'))) !!}
                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'gregorian_date_str') !!}</strong> </span>
            </div>
        </div>


        <div class="col-md-6">
            <div class="formrow {{ $errors->has('axles') ? ' has-error' : '' }} no-margin-btm">
                <label class="am-label"><span class="red-color">*</span> {{__('axles')}}:</label>
                {!! Form::text('axles',  old('axles'), array('class'=>'form-control', 'placeholder'=>__('axles'))) !!}
                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'axles') !!}</strong> </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow {{ $errors->has('floor') ? ' has-error' : '' }} no-margin-btm">
                <label class="am-label"><span class="red-color">*</span> {{__('floor')}}:</label>
                {!! Form::text('floor',  old('floor'), array('class'=>'form-control', 'placeholder'=>__('floor'))) !!}
                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'floor') !!}</strong> </span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="formrow {{ $errors->has('area') ? ' has-error' : '' }} no-margin-btm">
                <label class="am-label"><span class="red-color">*</span> {{__('area')}}:</label>
                {!! Form::text('area',  old('area'), array('class'=>'form-control', 'placeholder'=>__('area'))) !!}
                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'area') !!}</strong> </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow {{ $errors->has('special_marque') ? ' has-error' : '' }} no-margin-btm">
                <label class="am-label"><span class="red-color">*</span> {{__('Special Marque')}}:</label>
                {!! Form::text('special_marque',  old('special_marque'), array('class'=>'form-control', 'placeholder'=>__('Special Marque'))) !!}
                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'special_marque') !!}</strong> </span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="formrow {{ $errors->has('danger_cat_id') ? ' has-error' : '' }} no-margin-btm">
                <label class="am-label"><span class="red-color">*</span> {{__('Danger Category')}}:</label>
                {!! Form::select('danger_cat_id', [''=>__('Select Danger')]+$danger_cat,null , array('class'=>'form-control', 'id'=>'danger_cat_id')) !!}
                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'danger_cat_id') !!}</strong> </span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="formrow {{ $errors->has('danger_sub_cat_id') ? ' has-error' : '' }} no-margin-btm">
                <label class="am-label"><span class="red-color">*</span> {{__('Danger Subcategory')}}
                    :</label>
                <span id="danger_dd">
                    {!! Form::select('danger_sub_cat_id', [''=>__('Select Danger Subcategory')],null , array('class'=>'form-control', 'id'=>'danger_sub_cat_id')) !!}
                </span>
                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'danger_sub_cat_id') !!}</strong>
            </div>
        </div>

        <div class="col-md-6">
            <div class="formrow {{ $errors->has('description') ? ' has-error' : '' }} no-margin-btm">
                <label class="am-label"><span class="red-color">*</span> {{__('Danger Description')}}:</label>
                {!! Form::textarea('description',old('description'), array('class'=>'form-control', 'placeholder'=>__('Danger Description'))) !!}
                <p id="remaining_letters"></p>
                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'description') !!}</strong> </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow {{ $errors->has('danger_status') ? ' has-error' : '' }} no-margin-btm">
                <label class="am-label"><span class="red-color">*</span> {{__('Danger Level')}}:</label>
                {{Form::select('danger_status',['High'=>__('High'),'Medium'=>__('Medium'),'Low'=>__('Low')],old('danger_status'),array('class'=>'form-control','data-validation'=>'required')) }}

            </div>
        </div>
        <div class="col-md-6">
         <div class="formrow {{ $errors->has('danger_status') ? ' has-error' : '' }} no-margin-btm">
             <label class="am-label"><span class="red-color">*</span> {{__('Violation Cost')}}:</label>
             {!! Form::text('cost',  old('cost'), array('class'=>'form-control', 'placeholder'=>__('Violation Cost'))) !!}
         </div>
        </div>
    </div>

    <div class="row page-sec">
        <div class="col-md-12">
            <div class="formrow {{ $errors->has('uploads') ? ' has-error' : '' }}{{ $errors->has('uploads') ? ' has-error' : '' }}">
                <h6 class="am-sub-title green-color">{{__('Attachments')}}</h6>
                <input type="file" class="form-control-file form-control"
                       id="exampleFormControlFile1" name="uploads[]" multiple>
                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'uploads') !!}</strong> </span>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12">
            <button type="submit" class="btn" style="width: 100%;"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{__('Save')}}
            </button>
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
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
        filterSubCat(<?php if (isset($violation)) echo old('danger_cat_id', $violation->danger_cat_id); ?>);
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
                        $('#state_id').val(<?php  echo old('danger_sub_cat_id', $violation->danger_sub_cat_id); ?>);
                    });
            }
        }

    </script>
@endpush
