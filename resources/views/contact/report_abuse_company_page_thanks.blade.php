@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Report a Problem')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    @include('flash::message')

                    <div class="row">
                        @include('includes.employee_dashboard_menu')
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="userccount">
                                <div class="row page-sec">
                                    <div class="text-center">
                                        <img src="{{ asset('/') }}images/amen_logo.png"
                                             alt="{{ $siteSetting->site_name }}"
                                             height="120">
                                    </div>

                                    <div id="candidate" class="formpanel text-center">
                                        <h4 class="green-color">{{__('Thank you for contacting us!!')}}</h4>
                                        <p>{{__('Our technical team will check this problem as soon as possible.')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection