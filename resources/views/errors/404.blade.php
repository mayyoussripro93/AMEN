@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Page Not Found')])
    <!-- Inner Page Title end -->
    <div class="about-wraper">
        <!-- About -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="userccount">
                        <div class="text-center">
                            {{--<img src="sitesetting_images/{{ $siteSetting->site_logo }}" >--}}
                            <img src="{{ asset('/') }}images/logo.jpg" alt="{{ $siteSetting->site_name }}">
                        </div>

                        <div class="formpanel text-center">
                            <h4 class="green-color"><i class="fa fa-warning" aria-hidden="true"></i> {{__('Page Not Found')}}</h4>
                            <p class="green-color">{{__('If you feel something is missing that should be here,')}} <a
                                        href="{{ route('contact.us') }}">{{__('Contact us')}}</a>.</p>
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