@extends('admin.layouts.admin_layout')
@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li><a href="{{ route('admin.home') }}">{{__('Home')}}</a> <i class="fa fa-circle"></i></li>
                    <li><a href="{{ route('list.projects') }}">{{__('Projects')}}</a> <i class="fa fa-circle"></i></li>
                    <li> <a href="{{route('edit.project',['id'=> $project->id])}}">{{$project->name}}</a> <i class="fa fa-circle"></i> </li>
                    <li><span>{{__('Add Study')}}</span></li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- END PAGE HEADER-->
            <br/>
            @include('flash::message')
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered" style="overflow: auto;">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo"><i class="icon-settings font-red-sunglo"></i> <span
                                        class="caption-subject bold uppercase">{{__('Add Study')}}</span></div>
                        </div>
                        <div class="portlet-body form">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#Details" data-toggle="tab"
                                                      aria-expanded="false"> {{__('Details')}} </a></li>
                            </ul>
                            {!! Form::open(array('method' => 'post', 'route' => 'store.studies', 'id'=>'studyModalForm','class' => 'form', 'files'=>true)) !!}
                            <input type="hidden" value="{{$project_id}}" name="id">
                            @csrf

                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('fire') ? ' has-error' : '' }}">
                                    <label for="studyFormControlFile1">{{__('Fire and Alarm')}}</label>
                                    <input type="file" class="form-control-file form-control" id="studyFormControlFile1"
                                           name="fire"data-validation="mime size" data-validation-max-size="10M" data-validation-allowing="pdf">
                                    <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'fire') !!} </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('evacuation') ? ' has-error' : '' }}">
                                    <label for="studyFormControlFile2">{{__('Evacuation and Rescue')}}</label>
                                    <input type="file" class="form-control-file form-control" id="studyFormControlFile2"
                                           name="evacuation" data-validation="mime size" data-validation-max-size="10M" data-validation-allowing="pdf">
                                    <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'evacuation') !!} </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('dangerous_areas') ? ' has-error' : '' }}">
                                    <label for="studyFormControlFile3">{{__('Dangerous Areas')}}</label>
                                    <input type="file" class="form-control-file form-control" id="studyFormControlFile3"
                                           name="dangerous_areas" data-validation="mime size" data-validation-max-size="10M" data-validation-allowing="pdf">
                                    <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'dangerous_areas') !!} </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('surrounding') ? ' has-error' : '' }}">
                                    <label for="studyFormControlFile4">{{__('Surrounding Environment')}}</label>
                                    <input type="file" class="form-control-file form-control" id="studyFormControlFile4"
                                           name="surrounding" data-validation="mime size" data-validation-max-size="10M" data-validation-allowing="pdf">
                                    <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'surrounding') !!} </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p><small class="hint red-color">{{__('Allowed (pdf)')}}</small><br><small class="hint red-color">{{__('Allowed (max size:10M)')}}</small></p>

                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn" style="width: 100%;"><i
                                            class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{__('Save')}}
                                </button>
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
@push('scripts')

    <script type="text/javascript">
        $.validate({
            form: '#studyModalForm',
            modules: 'file',
            addValidClassOnAll: true,
            errorMessagePosition: 'top' // Instead of 'inline' which is default
        });
        $('#studyModalForm').submit(function(){
         if($("#studyFormControlFile1").val()=='' && $("#studyFormControlFile2").val()=='' && $("#studyFormControlFile3").val()=='' && $("#studyFormControlFile4").val()=='')
         {
             alert('Set Inputs');
             return false;
         }
        });
    </script>
@endpush