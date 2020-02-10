@extends('admin.layouts.admin_layout')
@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">{{__('Home')}}</a> <i class="fa fa-circle"></i> </li>
                <li> <a href="{{ route('list.employees') }}">{{__('Management Accounts')}}</a> <i class="fa fa-circle"></i> </li>
                <li> <span>{{__('Edit User')}}</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <!--<h3 class="page-title">Edit User <small>Users</small> </h3>-->
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <br />
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">{{__('Edit User')}}</span> </div>
                    </div>
                    <div class="portlet-body form">
                        <ul class="nav nav-tabs">
                            <li class="active"> <a href="#Details" data-toggle="tab" aria-expanded="false"> {{__('Details')}} </a> </li>

{{--                            <li><a href="#CV" data-toggle="tab" aria-expanded="false">C.V</a></li>--}}
{{--                            <li><a href="#Education" data-toggle="tab" aria-expanded="false">Education</a></li>--}}
                              </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="Details"> @include('admin.employee.forms.form') </div>
{{--                            <div class="tab-pane fade" id="CV"> @include('admin.employee.forms.cv.cvs') </div>--}}
{{--                            <div class="tab-pane fade" id="Education"> @include('admin.employee.forms.education.education') </div>--}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    @endsection