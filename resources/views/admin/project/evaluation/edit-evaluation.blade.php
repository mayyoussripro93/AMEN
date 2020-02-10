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
                    <li> <a href="{{route('edit.project',['id'=> $project->id])}}">{{$project->name}}</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>{{__('Edit Evaluation')}}</span> </li>
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
                            <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">{{__('Edit Evaluation')}}</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <ul class="nav nav-tabs">
                                <li class="active"> <a href="#Details" data-toggle="tab" aria-expanded="false"> Details </a> </li>
                            </ul>
                            {!! Form::model($evaluation,array('method' => 'put', 'route' => 'update.evaluation', 'class' => 'form', 'files'=>true)) !!}
                            {!! Form::hidden('id', $evaluation->id) !!}
                            <div class="tab-content">
                                <table width="100%" class="table table-bordered table-hover">
                                    <tr align="center" style="background-color: #f9f9f9;">
                                        <th width="20%">{{__('Name')}}</th>
                                        <th width="16%">{{__('Performance And Achievement')}}</th>
                                        <th width="16%">{{__('Initiative And Invention')}}</th>
                                        <th width="16%">{{__('Collaboration And Career Commitment')}}</th>
                                        <th width="16%">{{__('Participation And Responsibility')}}</th>
                                        <th width="16%">{{__('Supervisory Skills')}}</th>
                                    </tr>

                                        <tr style="background-color: #f9f9f9;">
                                            <td nowrap="">{{$evaluation->employee->name}}</td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="performance" value="{{$evaluation->performance or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="initiative"value="{{$evaluation->initiative or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="collaboration"value="{{$evaluation->collaboration or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="participation"value="{{$evaluation->participation or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="supervisory"value="{{$evaluation->supervisory or ''}}"></td>
                                        </tr>


                                </table>
                                <div class="row" style="margin-top: 30px;">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn" style="width: 100%;"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{__('Save')}}
                                        </button>
                                    </div>
                                </div>
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
