@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Dashboard')])
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
                                <div class="formpanel">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h5 class="green-color am-title">
                                                <i class="fa fa-tachometer" aria-hidden="true"></i> {{__('Dashboard')}}
                                                <ul class="am-links pull-left">
                                                    <li><a href="{{route('events.user.index')}}" title="{{__('Calendar')}}"><i class="fa fa-calendar"
                                                                                                  aria-hidden="true"></i></a>
                                                    </li>
                                                    <li><a href="{{route('employee.messages')}}" title="{{__('Messages')}}"><i
                                                                    class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                                    </li>
                                                    <li><a href="{{route('report.abuse.company')}}" title="{{__('Report a Problem')}}"><i
                                                                    class="fa fa-wrench" aria-hidden="true"></i></a>
                                                    </li>
                                                    <li><a href="{{route('delete.account')}}" title="{{__('Delete')}}"><i
                                                                    class="fa fa-trash-o red-color"
                                                                    aria-hidden="true"></i></a></li>
                                                </ul>
                                            </h5>
                                        </div>
                                    </div>

                                    @include('includes.employee_dashboard_stats')
                                    @include('includes.employee_projects')

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
@push('scripts')
    @include('includes.immediate_available_btn')
@endpush