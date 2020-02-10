@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Reset Password')])

    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="userccount">
                        <div>
                            <div class="text-center">
                                {{--<img src="sitesetting_images/{{ $siteSetting->site_logo }}" >--}}
                                <img src="{{ asset('/') }}images/amen_logo.png" alt="{{ $siteSetting->site_name }}"
                                     height="120">
                                <h4 class="green-color" style="margin: 10px auto;"><i class="fa fa-lock"
                                                                                      aria-hidden="true"></i> {{__('Reset Password')}}
                                </h4>
                            </div>

                            <form class="form-horizontal" method="POST"
                                  action="{{ route('employee.password.request') }}">
                                {{ csrf_field() }}
                                <div class="formpanel">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="am-label"><span
                                                    class="red-color">*</span> {{__('Email Address')}}</label>

                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ $email or old('email') }}" required autofocus>
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    </div>

                                    <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="am-label"><span
                                                    class="red-color">*</span> {{__('Password')}}</label>
                                        <input id="password" type="password" class="form-control" name="password"
                                               required>
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    </div>
                                    <div class="formrow{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        <label for="password-confirm" class="am-label"><span
                                                    class="red-color">*</span> {{__('Confirm Password')}}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required>
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    </div>
                                    <div class="formrow">
                                        <button type="submit" class="btn">
                                            {{__('Reset Password')}}
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
    @include('includes.footer')
@endsection