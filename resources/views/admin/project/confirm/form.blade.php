{!! APFrmErrHelp::showOnlyErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">

    <div class="row page-sec">
        <div class="col-md-12">
            <h6 class="am-sub-title green-color">{{__('Confirmation Details')}}</h6>
        </div>


        <div class="row page-sec">
            <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'area_status') !!}">
                    <label class="am-label"><span
                                class="red-color">*</span> {{__('Area Status')}}
                        :</label>
                    {!! Form::select('area_status', ['opened'=>__('opened'),'closed'=>__('closed')],null, array('class'=>'form-control', 'id'=>'danger_status_last','placeholder'=>__('Area Status'))) !!}
                    <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'area_status_last') !!}</strong></span>
                </div>

            </div>
            <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'danger_status') !!}">
                    {{--                                    {{Form::select('employee_role_id',[''=>__('Select Position').' *','3'=>__('Safety_consultant'),'4'=>__('Project_consultant'),'5'=>__('Contractor')],old('employee_role_id'),array('class'=>'form-control', 'id'=>'exampleFormControlSelect1')) }}--}}
                    <label class="am-label"><span
                                class="red-color">*</span> {{__('Danger Status')}}
                        :</label>
                    {!! Form::select('danger_status', ['removed'=>__('removed'),'exist'=>__('exist'),'work on'=>__('work on')],null, array('class'=>'form-control', 'id'=>'danger_status_last','placeholder'=>__('Danger Status'))) !!}
                    <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'danger_status_last') !!}</strong></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="formrow {{ $errors->has('cost') ? ' has-error' : '' }} no-margin-btm">
                    <label class="am-label"><span class="red-color">*</span> {{__('Violation Cost')}}:</label>
                    {!! Form::text('cost',  old('cost'), array('class'=>'form-control', 'placeholder'=>__('Violation Cost'))) !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="formrow{{ $errors->has('uploads') ? ' has-error' : '' }}">
                    <label class="am-label"
                           for="exampleFormControlFile1">{{__('Attachments')}}
                        :</label>
                    <input type="file"
                           class="form-control-file form-control"
                           id="exampleFormControlFile1"
                           name="uploads[]"
                           multiple>
                    <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'uploads') !!}</strong> </span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="formrow">
                    <label class="am-label">{{__('Notes')}}
                        :</label>
                    {!! Form::textarea('notes',null, array('class'=>'form-control','placeholder'=>__('Notes'))) !!}

                    <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'Notes') !!}</strong> </span>
                </div>
            </div>
        </div>

    </div>



    <div class="row" style="margin-top: 30px;">
        <div class="col-md-4 pull-left">
            <button type="submit" class="btn"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{__('Save')}}
            </button>
        </div>
    </div>
</div>
@push('scripts')
@endpush
