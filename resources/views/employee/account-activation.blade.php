@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Account Activation')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <div class="userccount">
                        <div class="text-center">
                            {{--<img src="sitesetting_images/{{ $siteSetting->site_logo }}" >--}}
                            <img src="{{ asset('/') }}images/amen_logo.png" alt="{{ $siteSetting->site_name }}" height="120">
                        </div>
                        <div id="candidate" class="formpanel text-center" style="margin-top: 20px !important;">
                            <h4 class="green-color"><i class="fa fa-check-square-o" aria-hidden="true"></i> {{__('Account Activation')}}</h4>
                            <p>{{__("Please click on the following link to activate your account on Amen platform, then you'll be redirected to your dashboard.")}}</p>

                            @include('flash::message')
                            <form class="form-horizontal" method="POST" action="{{ route('post.account-activation') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('verify_token') ? ' has-error' : '' }}">
                                    {{--                                    <label for="email" class="col-md-4 control-label">{{__('Activation Code')}}</label>--}}
                                    <div class="col-md-6">
                                        <input id="verify_token" type="hidden" class="form-control" name="verify_token" value="{{ $verify_token }}" >
                                        @if ($errors->has('verify_token'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('verify_token') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-default">
                                            {{__('Activate Account')}}
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