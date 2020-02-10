@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>'Reset Password'])
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
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form class="form-horizontal" method="POST" action="{{ route('employee.password.email') }}">
                                {{ csrf_field() }}
                                <div class="formpanel">
                                    <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="am-label"><span
                                                    class="red-color">*</span> {{__('Email')}}:</label>
                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ old('email') }}" required>
                                        <span class="help-block"> <strong>{{ $errors->first('email') }}</strong></span>
                                    </div>
                                    <div class="formrow">
                                        <button type="submit" class="btn">{{__('Send Password Reset Link')}}</button>
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