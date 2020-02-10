@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Page Expired')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <!-- About -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="userccount">

                        <div class="text-center">
                            <img src="{{ asset('/') }}images/amen_logo.png" alt="{{ $siteSetting->site_name }}"
                                 height="120">
                        </div>
                        <div id="candidate" class="formpanel text-center">
                            <h4 class="green-color"><i class="fa fa-warning"
                                                       aria-hidden="true"></i> {{__('Page Expired')}}</h4>
                            <p>{{__('The page has expired due to inactivity. Please refresh and try again.')}}</p>
                        </div>

                        <div class="newuser"><a href="{{route('login')}}"><i class="fa fa-sign-in" aria-hidden="true"></i> {{__('Sign in')}}</a></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
