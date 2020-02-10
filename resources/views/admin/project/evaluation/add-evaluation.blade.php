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
                    <li> <span>{{__('Add Evaluation')}}</span> </li>
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
                            <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">{{__('Add Evaluation')}}</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <ul class="nav nav-tabs"><li class="active"> <a href="#Details" data-toggle="tab" aria-expanded="false"> Details </a> </li> </ul>

                            {!! Form::open(array('method' => 'post', 'route' => 'store.evaluation', 'class' => 'form', 'files'=>true)) !!}
                            <input type="hidden" value="{{$project_id}}" name="project_id">
                            <div class="row page-sec">
                            <div class="col-md-4">
                                <div class="formrow no-margin-btm">
                                    <label class="am-label"><span
                                                class="red-color">*</span> {{__('Date')}} :</label>
                                    <input type="text" name="year_month"
                                           value="" class="form-control "
                                           id="year_gregoian">
                                    <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'year_month') !!}</strong> </span>
                                </div>
                            </div>
                            </div>
                            <div class="tab-content">
                                <table width="100%" class="table table-bordered table-hover">
                                    <tr align="center" style="background-color: #f9f9f9;">
                                        <th width="10%">{{__('Name')}}</th>
                                        <th width="16%">{{__('Performance And Achievement')}}</th>
                                        <th width="16%">{{__('Initiative And Invention')}}</th>
                                        <th width="16%">{{__('Collaboration And Career Commitment')}}</th>
                                        <th width="16%">{{__('Participation And Responsibility')}}</th>
                                        <th width="16%">{{__('Supervisory Skills')}}</th>
                                    </tr>
                                    <tr><td align="center" colspan="6"><strong>{{__('Contractor')}}</strong></td></tr>
                                    @foreach($contractor_managers as $contractor_manager)
                                        <tr style="background-color: #f9f9f9;">
                                            <td nowrap="">{{$contractor_manager->name}} <input type="hidden" value="{{$contractor_manager->id}}" name="ids[]"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="performance{{$contractor_manager->id}}" value="{{$evaluation[$contractor_manager->id]->performance or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="initiative{{$contractor_manager->id}}"value="{{$evaluation[$contractor_manager->id]->initiative or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="collaboration{{$contractor_manager->id}}"value="{{$evaluation[$contractor_manager->id]->collaboration or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="participation{{$contractor_manager->id}}"value="{{$evaluation[$contractor_manager->id]->participation or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="supervisory{{$contractor_manager->id}}"value="{{$evaluation[$contractor_manager->id]->supervisory or ''}}"></td>
                                        </tr>
                                    @endforeach
                                    <tr><td  align="center" colspan="6"><strong>{{__('Safety_consultant')}}</strong></td></tr>
                                    @foreach( $safety_managers as  $safety_manager)
                                        <tr style="background-color: #f9f9f9;">
                                            <td nowrap="">{{$safety_manager->name}} <input type="hidden" value="{{$safety_manager->id}}" name="ids[]"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="performance{{$safety_manager->id}}" value="{{$evaluation[$safety_manager->id]->performance or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="initiative{{$safety_manager->id}}"value="{{$evaluation[$safety_manager->id]->initiative or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="collaboration{{$safety_manager->id}}"value="{{$evaluation[$safety_manager->id]->collaboration or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="participation{{$safety_manager->id}}"value="{{$evaluation[$safety_manager->id]->participation or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="supervisory{{$safety_manager->id}}"value="{{$evaluation[$safety_manager->id]->supervisory or ''}}"></td>
                                        </tr>
                                    @endforeach
                                    <tr><td  align="center" colspan="6"><strong>{{__('Project_consultant')}}</strong></td></tr>
                                    @foreach($project_managers as $project_manager)
                                        <tr style="background-color: #f9f9f9;">
                                            <td nowrap="">{{$project_manager->name}} <input type="hidden" value="{{$project_manager->id}}" name="ids[]"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="performance{{$project_manager->id}}"value="{{$evaluation[$project_manager->id]->performance or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="initiative{{$project_manager->id}}"value="{{$evaluation[$project_manager->id]->initiative or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="collaboration{{$project_manager->id}}"value="{{$evaluation[$project_manager->id]->collaboration or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="participation{{$project_manager->id}}"value="{{$evaluation[$project_manager->id]->participation or ''}}"></td>
                                            <td><input type="number" min="0" max="10" class="form-control" name="supervisory{{$project_manager->id}}"value="{{$evaluation[$project_manager->id]->supervisory or ''}}"></td>
                                        </tr>
                                    @endforeach
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
@push('scripts')
    <script type="text/javascript">
$('#year_gregoian').daterangepicker({
"singleDatePicker": true,
"showDropdowns": true,
// "timePicker": true,
// "timePicker24Hour": true,
    "startDate":"{{$project->date_gregorian}}",
    "endDate":"{{$date=($project->end_date)!='' ?$project->end_date : date('Y-m-d')}}",
"minDate": "{{$project->date_gregorian}}",
 "maxDate":"{{$date=($project->end_date)!='' ?$project->end_date : date('Y-m-d')}}",
"locale": {
"format": "YYYY-MM-DD ",
"applyLabel": "Apply",
"cancelLabel": "Cancel",
"fromLabel": "From",
"toLabel": "To",
"customRangeLabel": "Custom",
"weekLabel": "W",
"daysOfWeek": [
"Su",
"Mo",
"Tu",
"We",
"Th",
"Fr",
"Sa"
],
"monthNames": [
"January",
"February",
"March",
"April",
"May",
"June",
"July",
"August",
"September",
"October",
"November",
"December"
],
"firstDay": 1
},
});
    </script>
@endpush