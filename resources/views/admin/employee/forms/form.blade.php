{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
@if(isset($user))
{!! Form::model($user, array('method' => 'put', 'route' => array('update.employee', $user->id), 'class' => 'form', 'files'=>true)) !!}
{!! Form::hidden('id', $user->id) !!}
@else
{!! Form::open(array('method' => 'post', 'route' => 'store.employee', 'class' => 'form', 'files'=>true)) !!}
@endif
<div class="form-body">
    <input type="hidden" name="front_or_admin" value="admin" />
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'image') !!}">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="border: none; padding: 0;"> <img src="{{ asset('/') }}admin_assets/no_image.jpg" alt="" width="150" height="150"/> </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                    <div> <span class="btn default btn-file"> <span class="fileinput-new"> اختر صورة البروفايل </span> <span class="fileinput-exists"> تعديل </span> {!! Form::file('image', null, array('id'=>'image')) !!} </span> <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> حذف </a> </div>
                </div>
                {!! APFrmErrHelp::showErrors($errors, 'image') !!} </div>
        </div>
        @if(isset($user))
        <div class=" col-md-2 thumbnail" style="border: none;">
            {{ ImgUploader::print_image("employee_images/$user->image") }}
        </div>
        @endif
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'name') !!}">
        {!! Form::label('name', __('Name'), ['class' => 'bold']) !!}
        {!! Form::text('name', null, array('class'=>'form-control', 'id'=>'name', 'placeholder'=>__('Name'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'name') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'email') !!}">
        {!! Form::label('email', __('Email'), ['class' => 'bold']) !!}
        {!! Form::text('email', null, array('class'=>'form-control', 'id'=>'email', 'placeholder'=>__('Email'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'email') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'password') !!}">
        {!! Form::label('password', __('Password'), ['class' => 'bold']) !!}
        {!! Form::password('password', array('class'=>'form-control', 'id'=>'password', 'placeholder'=>__('Password'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'password') !!}
    </div>

{{--    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'date_of_birth') !!}">--}}
{{--        {!! Form::label('date_of_birth', 'Date of Birth', ['class' => 'bold']) !!}--}}
{{--        {!! Form::text('date_of_birth', null, array('class'=>'form-control', 'id'=>'date_of_birth', 'placeholder'=>'Date of Birth', 'autocomplete'=>'off')) !!}--}}
{{--        {!! APFrmErrHelp::showErrors($errors, 'date_of_birth') !!}--}}
{{--    </div>--}}

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'nationality_id') !!}">
        {!! Form::label('nationality_id', __('Nationality'), ['class' => 'bold']) !!}
        {!! Form::select('nationality_id', [''=>__('Select Nationality')]+$nationalities, 191, array('class'=>'form-control', 'id'=>'nationality_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'nationality_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'national_id_card_number') !!}">
        {!! Form::label('national_id_card_number', __('National ID Card No.'), ['class' => 'bold']) !!}
        {!! Form::text('national_id_card_number', null, array('class'=>'form-control', 'id'=>'national_id_card_number', 'placeholder'=>__('National ID Card No.'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'national_id_card_number') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_id') !!}">
        {!! Form::label('country_id', __('Select Country'), ['class' => 'bold']) !!}
        {!! Form::select('country_id', [''=>__('Select Country')]+$countries, old('country_id', 191), array('class'=>'form-control', 'id'=>'country_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'country_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'state_id') !!}">
        {!! Form::label('state_id', __('State'), ['class' => 'bold']) !!}
        <span id="default_state_dd">
            {!! Form::select('state_id', [''=>__('Select State')], null, array('class'=>'form-control', 'id'=>'state_id')) !!}
        </span>
        {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'city_id') !!}">
        {!! Form::label('city_id', __('City'), ['class' => 'bold']) !!}
        <span id="default_city_dd">
            {!! Form::select('city_id', [''=>__('Select City')], null, array('class'=>'form-control', 'id'=>'city_id')) !!}
        </span>
        {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'phone') !!}">
        {!! Form::label('phone', __('Phone'), ['class' => 'bold']) !!}
        {!! Form::text('phone', null, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>__('Phone'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mobile_num') !!}">
        {!! Form::label('mobile_num', __('Mobile Number'), ['class' => 'bold']) !!}
        {!! Form::text('mobile_num', null, array('class'=>'form-control', 'id'=>'mobile_num', 'placeholder'=>__('Mobile Number'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mobile_num') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'street_address') !!}">
        {!! Form::label('street_address', __('Street Address'), ['class' => 'bold']) !!}
        {!! Form::textarea('street_address', null, array('class'=>'form-control', 'id'=>'street_address', 'placeholder'=>__('Street Address'))) !!}
        {!! APFrmErrHelp::showErrors($errors, 'street_address') !!}
    </div>
    @php
        $dimmed='';

    @endphp
    @if($is_have_project>0 || $is_have_employee>0)
        @php
            $dimmed='pointer-events:none';
        @endphp
        <small class="hint red-color">لايمكن تغيير هذه البيانات في حالة لديه موظفين او مشاريع</small>
    @endif

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'employee_role_id') !!}">
            {!! Form::label('role', 'الجهة التي ينتمي إليها', ['class' => 'bold']) !!}
{{--$roles--}}
{{--            {!! Form::select('employee_role_id',['1'=>__('Amen_super_admin'),'2'=>__('Amen-admin'),'3'=>__('Contractor'),'4'=>__('Project_consultant'),'5'=>__('Safety_consultant')], null, array('class' => 'form-control','id'=>'employee_role_id')) !!}--}}
            {!! Form::select('employee_role_id',$roles, null, array('class' => 'form-control','id'=>'employee_role_id','style'=>$dimmed)) !!}
            {!! APFrmErrHelp::showErrors($errors, 'employee_role_id') !!}
        </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_manager') !!}">
        {!! Form::label('is_manager', 'الصلاحيات', ['class' => 'bold' ,'id'=>'is_manager']) !!}
        <div class="radio-list">
            <?php

            $is_manger_1 = '';
            $is_manger_2 = 'checked="checked"';
//            if(old('is_manager', ((isset($user)) ? $user->is_manager : 1)) == 0)
                if( isset($user) && $user->is_manager )
            {

                $is_manger_1 = 'checked="checked"';
                $is_manger_2 = '';
            }
            ?>
                مدير
                <input  name="is_manager" type="radio" value="1" {{$is_manger_1}} style="{{$dimmed}}" onclick="manager_change()">
<br>
                ليس مدير
                <input  name="is_manager" type="radio" value="0" {{$is_manger_2}} style="{{$dimmed}}" onclick="manager_change()">


        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_manager') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'report_to') !!}">
        {!! Form::label('report to', 'الجهة العليا', ['class' => 'bold']) !!}
        @php $report2=isset($employee_report_to[0]) ?$employee_report_to[0] :'' @endphp
        <input type="hidden" name="old_report_to" value="<?php echo old('report_to',$report2); ?>" id="old_report_to">
<span id="report_to_dd">
  {!! Form::select('report_to', ['' =>'الجهة العليا'] , $employee_report_to, array('class' => 'form-control','id'=>'report_to','style'=>$dimmed,'disabled'=>'disabled')) !!}
</span>

        {!! APFrmErrHelp::showErrors($errors, 'report_to') !!}
    </div>


    {!! Form::button('حفظ <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}
</div>
{!! Form::close() !!}
@push('css')
<style type="text/css">
    .datepicker>div {
        display: block;
    }
    .btn.btn-large.btn-primary {
        width: 100%;
    }
    .thumbnail img {
        width: 150px;
        height: 150px;
    }
    .radio input[type=radio] {
        margin-right: -20px;
        margin-left: 0;
    }
</style>
@endpush
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#country_id').on('change', function (e) {
            e.preventDefault();
            filterDefaultStates(0);
        });
        $(document).on('change', '#state_id', function (e) {
            e.preventDefault();
            filterDefaultCities(0);
        });

        filterDefaultStates(<?php echo old('state_id', (isset($user)) ? $user->state_id : 0); ?>);
        filterRole();
        manager_change();
    });
    function filterDefaultStates(state_id)
    {
        var country_id = $('#country_id').val();
        if (country_id != '') {
            $.post("{{ route('filter.lang.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                        filterDefaultCities(<?php echo old('city_id', (isset($user)) ? $user->city_id : 0); ?>);
                    });
        }
    }
    function filterDefaultCities(city_id)
    {
        var state_id = $('#state_id').val();
        if (state_id != '') {
            $.post("{{ route('filter.lang.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
        }
    }



    $(document).on('change', '#employee_role_id', function (e) {
        filterRole();
        manager_change();
    });

      function manager_change()
      {
          var selected=$('input:radio[name=is_manager]:checked').val();
          if( selected==0)
          {
              $('#report_to').css('pointer-events','');
          }
          else{

              $('#report_to').val('') ;
              $('#report_to').css('pointer-events','none') ;
          }
      }

     function filterRole() {

       $('#report_to').attr('disabled',true);

        var role_id = $('#employee_role_id').val();
console.log(role_id);
        if (role_id != '') {
            $.post("{{ route('filter.role.dropdown') }}", {
                role_id: role_id,
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            })
                .done(function (response) {
                    $('#report_to').removeAttr('disabled');
                    $('#report_to_dd').html(response);

                    manager_change();

                    var report_to=  $('#old_report_to').val();

                    if(report_to!=0)
                      {
                         $('#report_to').val(report_to) ;
                      }
                });
        }
    }

</script>
@endpush