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
                <li> <a href="{{ route('list.employees') }}">حسابات المستخدمين</a> <i class="fa fa-circle"></i> </li>
                <li> <span>إنشاء حساب جديد</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <!--<h3 class="page-title">Edit User <small>Employees</small> </h3>-->
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <br />
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">مستخدم جديد</span> </div>
                    </div>
                    <div class="portlet-body form">
                        <ul class="nav nav-tabs">
                            <li class="active"> <a href="#Details" data-toggle="tab" aria-expanded="false"> التفاصيل </a> </li>
{{--                            <li><a href="#CV" data-toggle="tab" aria-expanded="false">Uploads</a></li>--}}
{{--                            <li><a href="#Education" data-toggle="tab" aria-expanded="false">Education</a></li>--}}
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="Details"> @include('admin.employee.forms.form') </div>
{{--                            @if(isset($user))--}}
{{--                            <div class="tab-pane fade" id="CV"> @include('admin.employee.forms.cv.cvs') </div>--}}
{{--                            <div class="tab-pane fade" id="Education"> @include('admin.employee.forms.education.education') </div>--}}
{{--                            @endif--}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
@endsection