@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Add New Employee')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    @include('flash::message')

                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="employeeccount userccount">
                                <div class="formpanel">
                                <!-- Personal Information -->
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h5 class="am-title green-color"><i class="fa fa-user-plus"
                                                                                aria-hidden="true"></i> {{__('Add New Employee')}}
                                            </h5>
                                        </div>
                                    </div>

                                    {!! Form::model( array('method' => 'post', 'route' => array('employee.add'), 'class' => 'form','id'=>'register_form', 'files'=>true)) !!}

                                        {{ Form::hidden('employee_role_id',Auth::guard('employee')->user()->employee_role_id) }}
                                        {{ Form::hidden('report_to',Auth::guard('employee')->user()->id) }}
                                       @include('employee.inc.form')
                                    {!! Form::close() !!}

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

