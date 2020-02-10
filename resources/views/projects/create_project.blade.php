@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Add New Project')])
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
                                <!-- START CREATE PROJECT FILE-->
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h5 class="green-color am-title"><i class="fa fa-folder-open"
                                                                                aria-hidden="true"></i> {{__('Add New Project')}}
                                            </h5>
                                        </div>
                                    </div>

                                {!! Form::open( array('method' => 'post', 'route' => array('create.project.add'), 'class' => 'form', 'files'=>true)) !!}

                                @include('projects.inc.form')
                                {!! Form::close() !!}
                                <!-- END CREATE PROJECT FILE -->
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

