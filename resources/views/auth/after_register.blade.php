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
                            <img src="{{ asset('/') }}images/amen_logo.png" alt="{{ $siteSetting->site_name }}" height="120">
                        </div>
                        <div id="candidate" class="formpanel text-center">
                            <h4 class="green-color"><i class="fa fa-check-circle-o" aria-hidden="true"></i> {{__('Successful Registration!!')}}</h4>
                            <p>{{__('Your registration process has been completed successfully, Amen will review your sent data and send you another mail later.')}}</p>
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