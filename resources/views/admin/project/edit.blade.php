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
                    <li> <a href="{{ route('list.projects') }}">{{__('Projects')}}</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>{{__('Edit Project')}}</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- END PAGE HEADER-->
            <br />
            @include('flash::message')
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">{{__('Edit Project')}}</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <ul class="nav nav-tabs">
                                <li class="active"> <a href="#Details" data-toggle="tab" aria-expanded="false"> {{__('Details')}} </a> </li>
                            </ul>
                            {!! Form::model($project, array('method' => 'post', 'route' => array('update.project'), 'class' => 'form', 'files'=>true)) !!}

                            {!! Form::hidden('id', $project->id) !!}
                            <div class="tab-content">
                                @include('admin.project.forms.form')
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT BODY -->
        </div>
    </div>
        @endsection
