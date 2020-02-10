@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Project Violations')])

    <style>
        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            border: 1px dotted #ddd;
        }

        .card:last-of-type {
            margin-bottom: 15px;
        }

        th {
            text-align: center;
        }

        .tab-pane.fade.show.active {
            opacity: 1;
        }

        .tab-pane {
            line-height: 1.5;
        }

        .nav-tabs > li {
            float: right;
        }

        .job-header .contentbox ul li {
            padding: 7px 0 0 0;
        }

        .job-header .contentbox ul li:before {
            content: none;
        }

        .nav-tabs > li > a.active {
            border-color: #ddd;
            border-bottom-color: transparent !important;
            background: #fff;
        }

        h6.mb-0 {
            cursor: pointer;
        }
    </style>
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid vio-details">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    @include('flash::message')

                    <div class="row">
                        @if ($errors->any()&& !$errors->has('body'))
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="panel panel-danger">

                                    <div class="panel-heading">
                                        @foreach ($errors->all() as $error)
                                            <p>{{$error}}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                    @endif
<div id="results_id"></div>
                    @include('includes.employee_dashboard_menu')

                    <!-- Violations List -->
                            <div class="col-md-9 col-sm-9 col-xs-12">
                            @include('projects.inc.project_header')
                            <div class="job-header">
                                <div class="contentbox" style="overflow: auto;">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">

                                            <div class="formrow trial-hidden">
                                                @if ($violation->payment_status)
                                                    @php $checked="checked"; $payment=__('Yes')@endphp
                                                @else
                                                    @php $checked=""; $payment=__('No')@endphp
                                                @endif

                                                <strong style="font-size: 14px;"><i class="fa fa-question-circle red-color"
                                                           aria-hidden="true"></i> {{__('Invoice has been paid?')}}
                                                </strong>
                                                <label class="chk-lbl" style="display: inline-block;">
                                                    @can('safety-consultant')
                                                        <input type="checkbox" name="payment_status" id="payment" value="1" {{$checked}}> <strong>{{__('Paid')}}</strong>
                                                        <span class="checkmark"></span>
                                                    @else
                                                     {{$payment}}
                                                    @endcan

                                                    <input type="hidden" id="violation_id" value="{{$violation->id}}">

                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <ul class="am-links vio-links pull-left">
                                                <li><a class="violation_print" href="#" title="{{__('Print')}}"><i
                                                                class="fa fa-print" aria-hidden="true"></i></a></li>
                                                <li>
                                                    <form action="{{route('generate.pdf.violation')}}" method="post"
                                                          id="pdf-form1">
                                                        <input type="hidden" value="{{$violation->id}}" id="pdf-data"
                                                               name="pdf-data">
                                                        @csrf
                                                        <button class="btn-link" type="submit"
                                                                title="{{__('Download')}}"><i
                                                                    class="fa fa-download down-pdf"
                                                                    aria-hidden="true"></i></button>
                                                    </form>
                                                </li>

                                                <li><a href="#" title="{{__('Invoice')}}" data-toggle="modal"
                                                       data-target="#invoiceModal{{$violation->id}}" class="trial-hidden"><i
                                                                class="fa fa-dollar"
                                                                aria-hidden="true"></i></a>
                                                </li>
                                                <!-- Invoice Modal -->
                                                <div class="modal fade" id="invoiceModal{{$violation->id}}"
                                                     tabindex="-1"
                                                     role="dialog" aria-labelledby="invoiceModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title green-color"
                                                                    id="invoiceModalLabel">{{__('Invoice')}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close"><span
                                                                            aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div style="border: 1px solid #dadada;border-radius: 2px; padding: 10px; margin-bottom: 15px;">
                                                                    <table width="100%" dir="rtl">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td colspan="2" style="text-align: right;">
                                                                                <strong>{{__('Date')}}:</strong> {{\Arabic\Arabic::adate(' j F Y ', strtotime(date('y-m-d')))}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: right;">
                                                                                <strong>{{__('Project Name')}}:</strong> {{$project->name}}
                                                                            </td>
                                                                            <td style="text-align: right;">
                                                                                <strong>{{__('Owner')}}:</strong> {{$project->owner}}
                                                                                / {{__($project->project_type)}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" style="text-align: right;">
                                                                                <strong>{{__('Danger Category')}}:</strong>{{$violation->danger_cat->country}}
                                                                                / {{$violation->sub_cat->state}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" style="text-align: right;">
                                                                                <strong>{{__('Violation Code')}}:</strong> {{$project->code }} - {{$violation->code}}
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div style="border: 1px solid #dadada; border-radius: 2px; padding: 10px;">
                                                                    <h6>{{__('Invoice Details')}}</h6>
                                                                    <table class="table table-striped table-hover">
                                                                        <tbody>
                                                                        <tr>
                                                                            <th style="text-align: right;">{{__('Main Fine')}}
                                                                                ({{__('SAR')}})
                                                                            </th>
                                                                            <td style="text-align: right;">{{\Arabic\Arabic::adate(' j F Y ', strtotime($violation->gregorian_date))}}</td>
                                                                            <td style="text-align: right;">{{$violation->cost}}</td>
                                                                        </tr>
                                                                        @foreach($violation->history as $trial)
                                                                            <tr>
                                                                                <th style="text-align: right;">{{__('Violation Follow Up')}}
                                                                                    ({{__('SAR')}})
                                                                                </th>
                                                                                <td style="text-align: right;">{{\Arabic\Arabic::adate(' j F Y ', strtotime($trial->created_at))}}</td>
                                                                                <td style="text-align: right;">{{$trial->cost}}</td>
                                                                            </tr>
                                                                        @endforeach

                                                                        <tr>
                                                                            <th style="text-align: right;"><strong>{{__('Total')}}
                                                                                    ({{__('SAR')}})</strong></th>
                                                                            <td colspan="2" style="text-align: right;">
                                                                                <strong id="net_amount_span">{{$violation->current_cost}}</strong>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-default print-btn"
                                                                        data-dismiss="modal"><i
                                                                            class="fa fa-print"></i> {{__('Print')}}
                                                                </button>

                                                                <form action="{{route('generate.pdf.Invoice')}}"
                                                                      method="post" style="display: inline-block;">
                                                                    <input type="hidden" value="{{$violation->id}}"
                                                                           id="pdf-data" name="pdf-data">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-default-focus">
                                                                        <i class="fa fa-download"></i> {{__('Download')}}
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @can('safety-consultant') <li><a href="" class="btn btn-danger white-color confirm-vio" data-toggle="modal" data-target="#confirmSafetyModal"><i class="fa fa-undo" aria-hidden="true"></i> {{__('Confirm')}}</a></li> @endcan
                                                <!-- Confirm Safety Modal -->
                                                <div class="modal fade" id="confirmSafetyModal"
                                                     tabindex="-1" role="dialog"
                                                     aria-labelledby="confirmSafetyModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form class="form-horizontal " id="violation_form" method="POST"
                                                              action="{{route('project.violation.confirm.post')}}"
                                                              enctype="multipart/form-data">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title green-color"
                                                                        id="confirmSafetyModalLabel">{{__('Confirm')}}</h5>
                                                                    <button type="button"
                                                                            class="close"
                                                                            data-dismiss="modal"
                                                                            aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    @csrf
                                                                    <input type="hidden" value="{{$project->id}}" name="project_id">
                                                                    <input type="hidden" value="{{$violation->id}}" name="violation_id">
                                                                    <div class="row page-sec">
                                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                                            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'area_status_last') !!}">
                                                                                <label class="am-label"><span class="red-color">*</span> {{__('Area Status')}}:</label>
                                                                                {!! Form::select('area_status_last', ['opened'=>__('opened'),'closed'=>__('closed')],null, array('class'=>'form-control','data-validation'=>'required', 'id'=>'danger_status_last','placeholder'=>__('Area Status'))) !!}
                                                                                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'area_status_last') !!}</strong></span>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                                            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'danger_status_last') !!}">
                                                                                {{--                                    {{Form::select('employee_role_id',[''=>__('Select Position').' *','3'=>__('Safety_consultant'),'4'=>__('Project_consultant'),'5'=>__('Contractor')],old('employee_role_id'),array('class'=>'form-control', 'id'=>'exampleFormControlSelect1')) }}--}}
                                                                                <label class="am-label"><span
                                                                                            class="red-color">*</span> {{__('Danger Status')}}
                                                                                    :</label>
                                                                                {!! Form::select('danger_status_last', ['removed'=>__('removed'),'exist'=>__('exist'),'work on'=>__('work on')],null, array('class'=>'form-control','data-validation'=>'required', 'id'=>'danger_status_last','placeholder'=>__('Danger Status'))) !!}
                                                                                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'danger_status_last') !!}</strong></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                                            <div class="formrow{{ $errors->has('uploads') ? ' has-error' : '' }}">
                                                                                <label class="am-label"
                                                                                       for="exampleFormControlFile1">{{__('Attachments')}}
                                                                                    :</label>
                                                                                <input type="file" class="form-control-file form-control" id="exampleFormControlFile1" name="uploads[]" multiple data-validation="size" data-validation-max-size="10M">
                                                                                <small class="hint red-color">{{__('Allowed (max size:10M)')}}</small>
                                                                                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'uploads') !!}</strong> </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                                            <div class="formrow">
                                                                                <label class="am-label">{{__('Notes')}}
                                                                                    :</label>
                                                                                <textarea
                                                                                        name="notes"
                                                                                        class="form-control"
                                                                                        placeholder="{{__('Notes')}}"></textarea>
                                                                                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'Notes') !!}</strong> </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                            class="btn btn-default-focus">{{__('Submit')}}</button>
                                                                    <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">{{__('Cancel')}}</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>


                                    <div class="row" style="margin-top: 25px;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="accordion" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne" data-toggle="collapse"
                                                         data-target="#collapseOne" aria-expanded="true"
                                                         aria-controls="collapseOne">
                                                        <h6 class="mb-0 am-sub-title green-color">
                                                            {{__('Main Violation Details')}} <i
                                                                    class="fa fa-chevron-down"
                                                                    aria-hidden="true"></i>
                                                        </h6>
                                                    </div>

                                                    <div id="collapseOne" class="collapse in"
                                                         aria-labelledby="headingOne"
                                                         data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <table class="table table-hover table-striped">
                                                                        <tr class="trial-hidden">
                                                                            <td width="30%">{{__('Cost')}}</td>
                                                                            <td >
                                                                            @if(Auth::guard('employee')->user()->employee_role_id==2)
                                                                                <form method="post" action="{{route('project.violation.CostValue')}}">
                                                                                    @csrf
                                                                                    <input type="hidden" name="type" value="violation">
                                                                                    <input type="hidden" name="violation_id" value="{{$violation->id}}">
                                                                                    <input type="hidden" name="id" value="{{$violation->id}}">
                                                                                <input style="width:50%; float: right;" type="number" step="0.25" class="cost-value form-control" name="cost" value="{{$violation->cost}}"><button type="submit"  class="btn btn-success-sm add-cost" style="margin-right: 10px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                                                </form>
                                                                                @else
                                                                                {{$violation->cost}}
                                                                            @endif
                                                                            </td>

                                                                        </tr>
                                                                        <tr>
                                                                            <td width="30%">{{__('Created By')}}</td>
                                                                            <td>{{__($violation->employee->name)}}</td>

                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('Date')}}</td>
                                                                            <td>{{\Arabic\Arabic::adate(' j F Y ', strtotime(__($violation->gregorian_date)))}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('Time')}}</td>
                                                                            <td>{{__($violation->violation_time)}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('Violation Code')}}</td>
                                                                            <td>{{$project->code }}
                                                                                - {{$violation->code}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('Danger Category')}}</td>
                                                                            <td>
                                                                                {{$violation->danger_cat->country}}
                                                                                / {{$violation->sub_cat->state}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('axles')}}</td>
                                                                            <td>{{__($violation->axles)}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('floor')}}</td>
                                                                            <td>{{__($violation->floor)}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('area')}}</td>
                                                                            <td>{{__($violation->area)}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{__('Special Marque')}}</td>
                                                                            <td>{{__($violation->special_marque)}}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>{{__('Danger Description')}}</td>
                                                                            <td class="text-display">{{__($violation->description)}}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>{{__('Removement Duration Date')}}</td>
                                                                            <td>{{\Arabic\Arabic::adate(' j F Y ', strtotime($violation->removement_duration))}} </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>
                                                                                <span>{{__('Attachments')}}</span>

                                                                            </td>
                                                                            <td>
                                                                                <div class="row">

                                                                                    @foreach ($uploads as $upload)

                                                                                            {{-- {{ImgUploader::print_doc("amen_project/violation/$upload->upload_file", $upload->title, $upload->title)}}--}}

                                                                                        @if($upload->title == $violation->id)
                                                                                            <div class="col-md-2">
                                                                                            <a href="{{route('download_s3',['path'=>'amen_project/violation','name'=>$upload->upload_file])}}" alt="" title="{{__('Click to download')}}" download=""> <img src="{{ asset('/') }}images/file.png" width="40px"></a>
                                                                                            </div>
                                                                                            @endif

                                                                                            </a>

                                                                                    @endforeach
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @foreach($violation->history as $trial)

                                                    <div class="card">
                                                        <div class="card-header collapsed" id="headingTwo" data-toggle="collapse"
                                                             data-target="#collapseTwo{{$trial->id}} "
                                                             aria-expanded="false" aria-controls="collapseTwo">
                                                            <h6 class="mb-0 am-sub-title green-color">
                                                                {{__('Confirm')}} ({{\Arabic\Arabic::adate(' j F Y ', strtotime($trial->created_at))}})<i
                                                                        class="fa fa-chevron-left"
                                                                        aria-hidden="true"></i>
                                                            </h6>
                                                        </div>
                                                        <div id="collapseTwo{{$trial->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <table class="table table-hover table-striped">
                                                                            <tr>
                                                                                <td>{{__('Area Status')}}</td>
                                                                                <td>{{__($trial->area_status)}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>{{__('Danger Status')}}</td>
                                                                                <td width="70%">{{__($trial->danger_status)}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>{{__('Removement Duration Date')}}</td>
                                                                                <td>{{\Arabic\Arabic::adate(' j F Y ', strtotime($trial->removement_duration))}} </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>{{__('Notes')}}</td>
                                                                                <td>{{$trial->notes}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>{{__('Created By')}}</td>
                                                                                <td>{{$trial->employee->name}}</td>
                                                                            </tr>
                                                                            <tr class="trial-hidden">
                                                                                <td width="30%">{{__('Cost')}}</td>
                                                                                <td>
                                                                                    @if(Auth::guard('employee')->user()->employee_role_id==2)
                                                                                        <form method="post" action="{{route('project.violation.CostValue')}}">
                                                                                            @csrf
                                                                                            <input type="hidden" name="type" value="confirmation">
                                                                                            <input type="hidden" name="violation_id" value="{{$violation->id}}">
                                                                                            <input type="hidden" name="id" value="{{$trial->id}}">
                                                                                        <input style="width:50%" type="number" step="0.25" name="cost" class="cost-value" value="{{$trial->cost}}"><button type="submit"  class="btn btn-success-sm add-cost"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                                                    @else
                                                                                        {{$trial->cost}}
                                                                                    @endif
                                                                                </td>

                                                                            </tr>
                                                                            <tr>
                                                                                <td>{{__('Attachments')}}</td>
                                                                                <td>
                                                                                    @foreach ($uploads as $upload)

                                                                                        {{-- {{ImgUploader::print_doc("amen_project/violation/$upload->upload_file", $upload->title, $upload->title)}}--}}
                                                                                        @if($upload->title===$violation->id."-".$trial->id)
                                                                                            <div class="col-md-2">
                                                                                                <a href="{{route('download_s3',['path'=>'amen_project/violation','name'=>$upload->upload_file])}}"
                                                                                                   alt=""
                                                                                                   title="{{__('Click to download')}}"
                                                                                                   download=""> <img
                                                                                                            src="{{ asset('/') }}images/file.png"
                                                                                                            width="40px"></a>
                                                                                            </div>
                                                                                            @endif

                                                                                            </a>

                                                                                            @endforeach
                                                                                </td>

                                                                            </tr>
                                                                        </table>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 25px;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="objection-container">

                                                @php
                                                    $can_object=true;
                                                    $color1='green-color';
                                                    $color2='green-color';
                                                    $color3='green-color';
                                                        if($violation_pass_days>30)
                                                          {
                                                           $can_object=false;
                                                           $color1='red-color';
                                                          }
                                                        if($violation->payment_status==1)
                                                          {
                                                           $can_object=false;
                                                           $color2='red-color';
                                                          }
                                                        if($violation->history_count)
                                                          {
                                                           $can_object=false;
                                                           $color3='red-color';
                                                          }
                                                        if($violation->objection_count)
                                                          {
                                                           $can_object=false;
                                                          }
                                                        if(Auth::guard('employee')->user()->employee_role_id!=5)
                                                          {
                                                          $can_object=false;
                                                        }
                                                @endphp

                                                <strong>{{__('Objection Conditions')}}:</strong>
                                                <ul>
                                                    <li class="{{$color1}}"><i class="fa fa-check " aria-hidden="true"></i> {{__('You can object to the violation within 30 days from its date.')}}
                                                    </li>
                                                    <li class="{{$color2}}"><i class="fa fa-check "
                                                           aria-hidden="true"></i> {{__("You can't object to the violation after payment has been made.")}}
                                                    </li>
                                                    <li class="{{$color3}}"><i class="fa fa-check "
                                                           aria-hidden="true"></i> {{__("You can't object to the violation after a follow-up action (safety assurance) has been taken.")}}
                                                    </li>
                                                </ul>

                                                <div id="objection-body" class="formpanel">
                                                    @if($can_object)
                                                        <div id="objection_employee_request">
                                                            <strong>
                                                                <i class="fa fa-question-circle red-color"
                                                                   aria-hidden="true"></i> {{__('Do you want to object to the violation?')}}
                                                                <label class="chk-lbl" style="display: inline-block;">
                                                                    <input type="checkbox"
                                                                           id="objection_check"
                                                                           name="objection"
                                                                           value=""> <strong>{{__('Yes')}}</strong>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </strong>

                                                            <form id="objection_check_form"
                                                                  name="objection_form"
                                                                  method="post"
                                                                  style="display: none"
                                                                  action="{{route('project.violation.object.post')}}">
                                                                @csrf
                                                                <input type="hidden"
                                                                       value="{{$violation->id}}"
                                                                       name="id">
                                                                <input type="hidden"
                                                                       value="{{$project->id}}"
                                                                       name="project_id">
                                                                <div class="form-group">
                                                                                            <textarea
                                                                                                    class="form-control"
                                                                                                    required
                                                                                                    id="objectionTextarea1"
                                                                                                    name="objection_txt"
                                                                                                    rows="3"
                                                                                                    placeholder="{{__('Please enter your objection here...')}}"></textarea>
                                                                    <button type="submit"
                                                                            class="btn btn-default">{{__('Submit')}}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endif
                                                    @if($violation->objection_count)
                                                        <div id="objection_reply">
                                                            <strong class="green-color">{{__('Contractor Objection')}}:</strong>
                                                            <p>{{$violation->objection->objection_txt}}</p>
                                                            <small>{{__('Date')}}: {{$violation->objection->created_at}}</small>
                                                        </div>
                                                    @endif

                                                </div>

                                                <div id="objection-reply" class="formpanel">

                                                    @if(Auth::guard('employee')->user()->employee_role_id==2 && $violation->objection_count)
                                                        <strong>
                                                            <i class="fa fa-reply red-color"
                                                               aria-hidden="true"></i> {{__('Civil defence reply to the objection')}}
                                                            :
                                                        </strong>
                                                        <form id="objection_reply_form"
                                                              name="objection_reply_form"
                                                              method="post"
                                                              action="{{route('project.violation.object_reply.post')}}">
                                                            @csrf
                                                            <input type="hidden"
                                                                   value="{{$violation->objection->id}}"
                                                                   name="id">
                                                            <div class="form-group">
                                                                                        <textarea class="form-control"
                                                                                                  name="objection_reply"
                                                                                                  id="objectionTextarea2"
                                                                                                  rows="3"
                                                                                                  placeholder="{{__('Please enter your reply to this objection here...')}}">{{$violation->objection->objection_reply}}</textarea>
                                                            </div>
                                                            <div id="objection-status">
                                                                <strong>
                                                                    <i class="fa fa-toggle-on red-color"
                                                                       aria-hidden="true"></i> {{__('Objection Status')}}
                                                                    :
                                                                </strong>

                                                                <div class="form-group">
                                                                    @php
                                                                     $checked_accepted=$violation->objection->is_accepted ==1 ? "checked":'';
                                                                     $checked_rejected=$violation->objection->is_accepted ==0 ? "checked":'';

                                                                     @endphp

                                                                    <label class="rdo-lbl">{{__('Accepted')}}
                                                                        <input type="radio" value="1" name="is_accepted" {{$checked_accepted}}>
                                                                        <span class="rdomark"></span>
                                                                    </label>

                                                                    <label class="rdo-lbl">{{__('Rejected')}}
                                                                        <input type="radio" value="0" name="is_accepted"{{$checked_rejected}}>
                                                                        <span class="rdomark"></span>
                                                                    </label>
                                                                </div>

                                                            </div>
                                                            <button type="submit"
                                                                    class="btn btn-default">{{__('Submit')}}</button>
                                                        </form>
                                                    @endif
                                                    @if(Auth::guard('employee')->user()->employee_role_id!=2 && $violation->objection_count )
                                                        @if($violation->objection->objection_reply!='')
                                                        <div id="objection_reply">
                                                            <strong class="green-color">{{__('Civil defence reply')}}:</strong>
                                                            <p>{{$violation->objection->objection_reply}}</p>
                                                            <small>{{__('Date')}}: {{$violation->objection->updated_at}}</small>
                                                        </div>
                                                            @endif
                                                    @endif
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="am-comments">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <h6 class="am-sub-title green-color"><i class="fa fa-comments" aria-hidden="true"></i> {{__('Comments')}}
                                                </h6>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-10 col-xs-12" style="float: none; margin: 20px auto 0; float: none !important;">
                                                <form id="comment_form" name="comment_form" method="post"
                                                      action="{{route('project.violation.comment.post')}}">
                                                    @csrf
                                                    <input type="hidden" value="{{$violation->id}}" name="id">
                                                    <input type="hidden" value="{{$violation->project_id}}" name="project_id">
                                                    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'body') !!}">
                                                        <textarea class="form-control" id="commentTextarea1" name="body" rows="3"></textarea>
                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'body') !!}</strong></span>
                                                        <button type="submit" class="btn btn-default-focus green-bg pull-left">{{__('Submit')}}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @foreach($comments as $comment)
                                            <div class="row comment">
                                                <div class="col-md-3 col-sm-12 col-xs-12 comment-info" style="text-align: center;">
                                                    {{$comment->employee->printUserImage()}}
                                                    <p class="green-color">{{$comment->employee->name}}</p>
                                                    <p>{{__($comment->employee->role->role_name)}}</p>
                                                </div>
                                                <div class="col-md-9 col-sm-12 col-xs-12 comment-text">
                                                    <span class="green-color comment-time"><i
                                                                class="fa fa-clock-o" aria-hidden="true"></i> {{$comment->created_at}}</span>
                                                    <p>{{$comment->body}}</p>
                                                </div>
                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div id="print_section" style="display: none;">
        <div class="container">
            <div class="row">

                <img src="{{ asset('/') }}images/print-header.png">
                <hr>
                <table id="project-table" class="header-table">
                    <tr>
                        <td width="25%">{{__('State')}}:</td>
                        <td width="25%">{{$project->state->state}}</td>
                        <td width="25%">{{__('City')}}:</td>
                        <td width="25%">{{$project->city->city}}</td>
                    </tr>
                    <tr>
                        <td width="25%">{{__('Project Name')}}:</td>
                        <td width="25%">{{$project->name}}</td>
                        <td width="25%">{{__('Owner')}}:</td>
                        <td width="25%">{{$project->owner}}</td>
                    </tr>
                </table>

                <span class="am-label">{{__('Violation Details')}}</span>
                <table id="print_table" class="table table-hover table-striped print-vio">
                    <tr>
                        <td width="35%">{{__('Created By')}}</td>
                        <td>{{__($violation->employee->name)}}</td>
                    </tr>
                    <tr>
                        <td width="35%">{{__('Date')}}</td>
                        <td>{{__($violation->gregorian_date)}}</td>
                    </tr>
                    <tr>
                        <td width="35%">{{__('Time')}}</td>
                        <td>{{__($violation->violation_time)}}</td>
                    </tr>
                    <tr>
                        <td width="35%">{{__('Violation Code')}}</td>
                        <td>{{$project->code }} - {{$violation->code}}</td>
                    </tr>
                    <tr>
                        <td width="35%">{{__('Danger Category')}}</td>
                        <td>{{$violation->danger_cat->country}}
                            / {{$violation->sub_cat->state}}</td>
                    </tr>
                    <tr>
                        <td width="35%">{{__('axles')}}</td>
                        <td>{{__($violation->axles)}}</td>
                    </tr>
                    <tr>
                        <td width="35%">{{__('floor')}}</td>
                        <td>{{__($violation->floor)}}</td>
                    </tr>
                    <tr>
                        <td width="35%">{{__('area')}}</td>
                        <td>{{__($violation->area)}}</td>
                    </tr>
                    <tr>
                        <td width="35%">{{__('Special Marque')}}</td>
                        <td>{{__($violation->special_marque)}}</td>
                    </tr>

                    <tr>
                        <td width="35%">{{__('Danger Description')}}</td>
                        <td><p class="text-display">{{__($violation->description)}}</p></td>
                    </tr>

                    <tr class="trial-hidden">
                        <td width="35%">{{__('Main Fine')}} ({{__('SAR')}})</td>
                        <td>{{$violation->cost}} </td>
                    </tr>
                    <tr>
                        <td width="35%">{{__('Danger Status')}}</td>
                        <td>{{__($violation->danger_status_last)}} </td>
                    </tr>
                    <tr>
                        <td width="35%">{{__('Area Status')}}</td>
                        <td>{{__($violation->area_status_last)}} </td>
                    </tr>
                    <tr class="trial-hidden">
                        <td width="35%"><strong>{{__('Total Cost')}} ({{__('SAR')}})</strong></td>
                        <td><strong>{{$violation->current_cost}}</strong></td>
                    </tr>
                    <tr class="trial-hidden">
                        <td width="35%">{{__('Payment Status')}}</td>
                        <td>{{__($payment)}} </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
@push('scripts')
    <script type="text/javascript">

        ////////////////////////////////////////
        $('#payment').click(function () {
            if ($(this).is(':checked'))
                var payment = 1;
            else var payment = 0;
            var violation = $("#violation_id").val();
            $.post("{{ route('project.violation.payment') }}", {
                payment: payment,
                violation_id: violation,
                _method: 'POST',
                _token: '{{ csrf_token() }}'
            }).done(function (response) {
                $('#results_id').html(response);
            });
        });
        /////////////////////////////
        {{--$('.add-cost').click(function(){--}}
            {{--var cost = $(this).parent().children('.cost-value').val();--}}
            {{--var id = $(this).attr('data-id');--}}
            {{--var type = $(this).attr('data-type');--}}
            {{--var violation_id=$(this).attr('data-violation-id');--}}
            {{--console.log($(this).parent());--}}
            {{--$.post("{{ route('project.violation.CostValue') }}", {--}}
                {{--cost: cost,--}}
                {{--id: id,--}}
                {{--type: type,--}}
                {{--violation_id:violation_id,--}}
                {{--_method: 'POST',--}}
                {{--_token: '{{ csrf_token() }}'--}}
            {{--}).done(function (response) {--}}
                {{--console.log(response);--}}
                {{--$('#results_id').html(response);--}}
            {{--});--}}
        {{--});--}}
        /////////////////////////////////////////////////////////////////////////////////
        $("#objection_check").click(function () {
            if ($(this).is(':checked')) $("#objection_check_form").css("display", "");
            else $("#objection_check_form").css("display", "none");
        });
        //////////////////////////////////////////////////////////////////////////////////////////
        $(".print-btn").click(function () {
            var divToPrint = $(this).parent().parent().children('.modal-body')[0];
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html lang="ar" class="rtl" dir="rtl"><head><link rel="stylesheet" href="{{asset('/')}}css/main.css" type="text/css" /> <link rel="stylesheet" href="{{asset('/')}}css/rtl-style.css" type="text/css" /><link rel="stylesheet" href="{{asset('/')}}css/print.css" type="text/css" /></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
            newWin.document.close();
        });
        $(".violation_print").click(function () {
            var divToPrint1 = $('#print_section').html();
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html lang="ar" class="rtl" dir="rtl"><head><link rel="stylesheet" href="{{asset('/')}}css/main.css" type="text/css" /> <link rel="stylesheet" href="{{asset('/')}}css/rtl-style.css" type="text/css" /><link rel="stylesheet" href="{{asset('/')}}css/print.css" type="text/css" /></head><body onload="window.print()">' + divToPrint1 + '</body></html>');
            newWin.document.close();
        });


        // Chevron left and down with collapse card header
        $(".card-header.collapsed").click(function () {
            $(this).children('h6').children('.fa').toggleClass("fa fa-chevron-left fa fa-chevron-down");
        });

        $("#headingOne").click(function () {
            $(this).children('h6').children('.fa').toggleClass("fa fa-chevron-down fa fa-chevron-left");
        });
    </script>
@endpush