@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Register')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            @include('flash::message')
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="userccount">

                        <div class="text-center">
                            {{--<img src="sitesetting_images/{{ $siteSetting->site_logo }}" >--}}
                            <img src="{{ asset('/') }}images/amen_logo.png" alt="{{ $siteSetting->site_name }}" height="120" >
                            <h4 class="green-color" style="margin: 10px auto;"><i class="fa fa-user-plus" aria-hidden="true"></i> {{__('New User')}}</h4>
                        </div>
                        <div id="candidate" class="formpanel">
                            @include('flash::message')

                            <form class="form-horizontal " id="register_form" method="POST" action="/register" enctype="multipart/form-data" >
                                {{ Form::hidden('country_id', 191, array('id' => 'country_id')) }}
                                {{ Form::hidden('nationality_id', 191, array('id' => 'nationality_id')) }}
                                {{ csrf_field() }}

                                <div class="formrow{{ $errors->has('employee_role_id') ? ' has-error' : '' }}">
                                    <label class="am-label"><span class="red-color">*</span> {{__('Position')}}:</label>
                                    {{Form::select('employee_role_id',[''=>__('Select Position'),'3'=>__('Safety_consultant'),'4'=>__('Project_consultant'),'5'=>__('Contractor')],old('employee_role_id'),array('class'=>'form-control', 'id'=>'exampleFormControlSelect1','data-validation'=>'required')) }}
                                   <span class="help-block"> <strong>{{ $errors->first('employee_role_id') }}</strong> </span>
                                </div>

                              <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}">
                                  <input type="hidden" value="{{old('state_id')}}" id="old_states">
                                  <label class="am-label"><span class="red-color">*</span> {{__('State')}}:</label>
                               <span id="state_dd"> {!! Form::select('state_id', [''=>__('Select State')], null, array('class'=>'form-control', 'id'=>'state_id','data-validation'=>'required')) !!} </span>
                               <span class="help-block"> <strong>{{ $errors->first('state_id') }}</strong> </span>
                             </div>

                                <div class="formrow{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="am-label"><span class="red-color">*</span> {{__('Name According to National ID')}}:</label>

                                    {!! Form::text('name', null, array('class'=>'form-control', 'id'=>'name', 'placeholder'=>__('Name According to National ID'),'data-validation'=>'required' )) !!}

                                    <span class="help-block"> <strong>{{ $errors->first('name') }}</strong> </span>
                                </div>

{{--                                <div class="formrow{{ $errors->has('national_id_card_number') ? ' has-error' : '' }}">--}}
{{--                                    <label class="am-label"><span class="red-color">*</span> {{__('National ID Card No.')}}:</label>--}}
{{--                                    {!! Form::text('national_id_card_number', old('national_id_card_number'), array('class'=>'form-control', 'id'=>'national_id_card_number','data-validation'=>'number','data-validation'=>'length','data-validation-length'=>'10', 'placeholder'=>__('National ID Card No.'))) !!}--}}
{{--                                    <span class="help-block"> <strong>{{ $errors->first('national_id_card_number') }}</strong> </span>--}}
{{--                                </div>--}}

                                <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="am-label"><span class="red-color">*</span> {{__('Email')}}:</label>
                                    {!! Form::text('email', old('email'), array('class'=>'form-control', 'id'=>'email', 'placeholder'=>__('Email'),'data-validation'=>'email')) !!}

                                    <span class="help-block"> <strong>{{ $errors->first('email') }}</strong> </span>  </div>

                                <div class="formrow{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label class="am-label"><span class="red-color">*</span> {{__('Phone Number')}}:</label>
                                    {!! Form::text('phone', old('phone'), array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>__('Phone Number'),'data-validation'=>'number','data-validation'=>'length','data-validation-length'=>'10','data-validation-optional'=>'true')) !!}

                                    <span class="help-block"> <strong>{{ $errors->first('phone') }}</strong> </span>
                                </div>


                                <div class="formrow{{ $errors->has('uploads[]') ? ' has-error' : '' }}">
                                    <label class="am-label" for="exampleFormControlFile1">{{__('Attachments')}}:</label>
                                    <input type="file" class="form-control-file form-control" name="uploads[]" id="exampleFormControlFile1" multiple="multiple" data-validation="size" data-validation-max-size="10M">
                                    <small class="hint red-color">{{__('Allowed (max size:10M)')}}</small>
                                </div>


                                <div class="formrow" style="margin-top: 15px;">
                                <input type="submit" class="btn" value="{{__('Register')}}" id="button_submit">
                                </div>
                            </form>
                        </div>
                        <!-- sign up form -->
                        <div class="newuser"><i class="fa fa-sign-in" aria-hidden="true"></i> {{__('Have Account?')}} <a href="{{route('login')}}"><small>{{__('Sign in')}}</small></a></div>
                        <!-- sign up form end-->

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

        <script type="text/javascript">
            $(document).ready(function ()
            {


                filterStates($('#old_states').val());

    function filterStates(state_id)
    {
    var country_id = $('#country_id').val();
    if (country_id != '') {
    $.post("{{ route('filter.lang.statesAmen.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
    .done(function (response) {
    $('#state_dd').html(response);

    $('#state_id').attr("data-validation","required");

    filterCities(<?php //echo old('city_id', $user->city_id); ?>);
    });
    }
    }
    function filterCities(city_id)
    {
    var state_id = $('#state_id').val();
    var city_id=$('city_id').val();
    if (state_id != '') {
    $.post("{{ route('filter.lang.cities.dropdown') }}", {state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
    .done(function (response) {
    $('#city_dd').html(response);
    });
    }
    }
            });
        </script>
    @endpush
    @include('includes.footer')
@endsection