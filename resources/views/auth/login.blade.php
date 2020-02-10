@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Login')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            @include('flash::message')
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="userccount">

                        <div class="tab-content">
                            <div id="candidate" class="formpanel tab-pane fade ">

                            </div>
                            <div id="employer" class="formpanel tab-pane fade active in">

                                <div class="text-center">
                                    {{--<img src="sitesetting_images/{{ $siteSetting->site_logo }}" >--}}
                                    <img src="{{ asset('/') }}images/amen_logo.png" alt="{{ $siteSetting->site_name }}" height="120">
                                    <h4 class="green-color" style="margin: 10px auto;"><i class="fa fa-sign-in" aria-hidden="true"></i> {{__('Login')}}</h4>
                                </div>
                                <form class="form-horizontal" method="POST" action="/employee/login">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="candidate_or_employer" value="employer" />
                                    <div class="formpanel">
                                        <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="am-label"><span class="red-color">*</span> {{__('Email')}}:</label>
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="{{__('Email')}}">
                                                <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        </div>
                                        <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label class="am-label"><span class="red-color">*</span> {{__('Password')}}:</label>
                                            <input id="password" type="password" class="form-control" name="password" value="" required placeholder="{{__('Password')}}">
                                                <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        </div>
                                        <input type="submit" class="btn" value="{{__('Login')}}">
                                    </div>
                                    <!-- login form  end-->
                                </form>
                                <!-- sign up form -->
                                <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> {{__('New User?')}} <a href="{{route('register')}}"><small>{{__('Register Here')}}</small></a></div>
                                <div class="newuser"><i class="fa fa-lock" aria-hidden="true"></i> {{__('Forgot Your Password?')}} <a href="{{ route('employee.password.request') }}"><small>{{__('Click here')}}</small></a></div>
                                <!-- sign up form end-->
                            </div>
                        </div>
                        <!-- login form -->



                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
