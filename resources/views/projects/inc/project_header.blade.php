<!-- Project Header start -->
<div class="job-header">
    <div class="jobinfo">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <!-- Project Info -->
                @php
                    $violations_count=\App\Violation::where('objection_status','!=','1')->where('project_id','=',$project->id)->count();
                @endphp
                <div class="candidateinfo">
                    <div class="userPic"><a href="{{route('project.detail',['id'=>Crypt::encryptString($project->id)])}}">{{$project->printProjectImage()}}</a>
                    </div>
                    <div class="title">{{$project->name}}</div>
                    <div class="loctext"><i class="fa fa-id-card-o" aria-hidden="true"></i> {{$project->owner}} - {{ __($project->project_type)}}</div>
                    <div class="loctext"><i class="fa fa-map-marker" aria-hidden="true"></i> {{$project->state->state}} - {{$project->city->city}}</div>

                    <div class="loctext"><i class="fa fa-map-marker" aria-hidden="true"></i> {{$project->address}}</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <!-- Project Contact -->
                <div class="candidateinfo">
                    <div class="loctext"><i class="fa fa-clock-o" aria-hidden="true"></i> {{__('Project Start Date')}}:
                        <span id="hijri_date">{{\Arabic\Arabic::adate(' j F Y ', strtotime($project->date_gregorian))}}</span></div>
                    <div class="clearfix"></div>
                    <div class="loctext"><i class="fa fa-hashtag" aria-hidden="true"></i> {{__('Project Code')}}:
                        <span>{{ $project->code}}</span></div>
                    <div class="loctext"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{__('Violations No.')}}:
                        <span>{{$violations_count}}</span></div>
{{--                    <div class="loctext"><i class="fa fa-users" aria-hidden="true"></i> {{__('Number of Employees')}}:--}}
{{--                        <span>{{$project->assignees_count}}</span></div>--}}
                    <div class="loctext"><i class="fa fa-book" aria-hidden="true"></i> {{__('Number of studies')}}:
                        <span>{{$project->uploads_count}}</span></div>
                    <div class="cadsocial"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="jobButtons">
        <a href="{{route('project.detail',['id'=>Crypt::encryptString($project->id)])}}" class="btn btn-success green-color back-to-project"><i class="fa fa-reply" aria-hidden="true"></i> {{__('Back to project')}}</a>
        <a href="{{route('project.project_violations',[Crypt::encryptString($project->id)])}}" class="btn btn-success green-color"><i class="fa fa-file" aria-hidden="true"></i> {{__('Safety Report')}}</a>

    @can('amen-state-admin')<a href="{{route('project.edit',[Crypt::encryptString($project->id)])}}" class="btn btn-success green-color"><i class="fa fa-pencil" aria-hidden="true"></i> {{__('Edit Project')}}</a>@endcan
        @can('safety-consultant')<a href="{{route('project.add_violation',[Crypt::encryptString($project->id)])}}" class="btn btn-danger white-color"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{__('Add Violation')}}</a>@endcan
        @canany(['project-consultant','safety-consultant'])<a href="" class="btn btn-success green-color" data-toggle="modal" data-target="#studyModal"><i class="fa fa-upload" aria-hidden="true"></i> {{__('Add Study')}}</a>@endcan

        <a href="{{url('employee-messages'."?id=".Crypt::encryptString($project->id))}}" class="btn btn-default pull-left"><i class="fa fa-envelope" aria-hidden="true"></i> {{__('Send Message')}}</a>
    </div>
</div>
<div class="modal fade" id="studyModal" tabindex="-1" role="dialog" aria-labelledby="studyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" enctype="multipart/form-data" action="{{route('project.upload.study')}}" id="studyModalForm" >
            @csrf
            <input type="hidden" value="{{$project->id}}" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title green-color" id="studyModalLabel">{{__('Project Studies')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="page-sec" style="padding: 15px;">
                        <div class="formrow{{ $errors->has('fire') ? ' has-error' : '' }}">
                            <label for="studyFormControlFile1">{{__('Fire and Alarm')}}</label>
                            <input type="file" class="form-control-file form-control" id="studyFormControlFile1" name="fire" data-validation="mime size" data-validation-max-size="10M" data-validation-allowing="pdf" >
                            <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'fire') !!} </span>
                        </div>
                        <div class="formrow{{ $errors->has('evacuation') ? ' has-error' : '' }}">
                            <label for="studyFormControlFile2">{{__('Evacuation and Rescue')}}</label>
                            <input type="file" class="form-control-file form-control" id="studyFormControlFile2" name="evacuation" data-validation="mime size" data-validation-max-size="10M" data-validation-allowing="pdf" >
                            <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'evacuation') !!} </span>
                        </div>
                        <div class="formrow{{ $errors->has('dangerous_areas') ? ' has-error' : '' }}">
                            <label for="studyFormControlFile3">{{__('Dangerous Areas')}}</label>
                            <input type="file" class="form-control-file form-control" id="studyFormControlFile3" name="dangerous_areas" data-validation="mime size" data-validation-max-size="10M" data-validation-allowing="pdf" >
                            <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'dangerous_areas') !!} </span>
                        </div>
                        <div class="formrow{{ $errors->has('surrounding') ? ' has-error' : '' }}">
                            <label for="studyFormControlFile4">{{__('Surrounding Environment')}}</label>
                            <input type="file" class="form-control-file form-control" id="studyFormControlFile4" name="surrounding" data-validation="mime size" data-validation-max-size="10M" data-validation-allowing="pdf" >
                            <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'surrounding') !!} </span>
                        </div>

                        <small class="hint red-color">{{__('Allowed (max size:10M)')}}</small>
                        <small class="hint red-color">{{__('Allowed (pdf)')}}</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-default" ><i class="fa fa-upload"></i> {{__('Add Study')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
