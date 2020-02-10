@extends('admin.layouts.admin_layout')
@section('content')
    <style>
        .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
            margin-left: 0;
        }
    </style>
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="{{ route('admin.home') }}">{{__('Home')}}</a> <i class="fa fa-circle"></i> </li>
                    <li> <a href="{{ route('list.projects') }}">{{__('Projects')}}</a> <i class="fa fa-circle"></i> </li>
                    <li> <a href="{{route('edit.project',['id'=> $project->id])}}">{{$project->name}}</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>{{__('Add Violation')}}</span> </li>
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
                            <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">{{__('Add Violation')}}</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <ul class="nav nav-tabs">
                                <li class="active"> <a href="#Details" data-toggle="tab" aria-expanded="false"> {{__('Details')}} </a> </li>
                            </ul>
                            {!! Form::open(array('method' => 'post', 'route' => 'store.violation', 'class' => 'form', 'files'=>true)) !!}
                            <input type="hidden" value="{{$project_id}}" name="project_id">
                            <div class="tab-content">
                                @include('admin.project.forms.violation-form')
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection
