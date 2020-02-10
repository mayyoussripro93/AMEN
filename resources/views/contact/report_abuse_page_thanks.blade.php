{{--@extends('layouts.app')--}}
{{--@section('content')--}}
{{--<!-- Header start -->--}}
{{--@include('includes.header')--}}
{{--<!-- Header end -->--}}
{{--<!-- Inner Page Title start -->--}}
{{--@include('includes.inner_page_title', ['page_title'=>__('Report Problem')])--}}
{{--<!-- Inner Page Title end -->--}}
{{--<div class="listpgWraper">--}}
{{--    <div class="container">--}}
{{--        @include('flash::message')--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-6 col-md-offset-3">--}}
{{--                <div class="userccount">--}}
{{--                    <h5>{{__('Thanks')}}!</h5>--}}
{{--                    <p>{{__('We will check this job')}},<br /><br />{{ $siteSetting->site_name }}</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@include('includes.footer')--}}
{{--@endsection--}}







@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Report a Problem')])
    <!-- Inner Page Title end -->
    <div class="about-wraper">
        <!-- About -->
        <div class="container">
            @include('flash::message')
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="userccount">
                        <div class="text-center">
                            {{--<img src="sitesetting_images/{{ $siteSetting->site_logo }}" >--}}
                            <img src="{{ asset('/') }}images/logo.jpg" alt="{{ $siteSetting->site_name }}">
                        </div>

                        <div class="formpanel text-center">
                            <h4 class="green-color"><i class="fa fa-info-circle" aria-hidden="true"></i> {{__('Report a Problem')}}</h4>
                            <p class="green-color">{{__('Successfully! Your problem has been sent and our team will check it and get back to you as soon as possible.')}}</p>
                        </div>

                        <!-- sign up form -->
                        <div class="newuser"><a href="/"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{__('Home')}}</a></div>
                        <!-- sign up form end-->

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection