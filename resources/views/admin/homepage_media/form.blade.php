
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<style>
    .btn.btn-large.btn-primary {
        width: 100%;
    }
</style>
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'media_type') !!}">
        {!! Form::label('media_type', __('Type'), ['class' => 'bold']) !!}
        {{Form::select('media_type',['video'=>__('Video'),'paper'=>__('Paper'),'image'=>__('Image')],old('media_type'),array('class'=>'form-control','data-validation'=>'required','id'=>'media_type')) }}
        {!! APFrmErrHelp::showErrors($errors, 'media_type') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'youtube_link') !!}" id="type_change">
        {!! Form::label('youtube_link', __('YouTube Link'), ['class' => 'bold']) !!}
        {!! Form::text('youtube_link', null, array('class'=>'form-control', 'id'=>'youtube_link', 'placeholder'=>__('YouTube Link'),'required'=>'required')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'youtube_link') !!}
    </div>

{{--    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'title') !!}">--}}
{{--        {!! Form::label('title', 'Title', ['class' => 'bold']) !!}--}}
{{--        {!! Form::text('title', null, array('class'=>'form-control', 'id'=>'title', 'placeholder'=>'Title')) !!}--}}
{{--        {!! APFrmErrHelp::showErrors($errors, 'title') !!}--}}
{{--    </div>--}}

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Is Active?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_active_1 = 'checked="checked"';
            $is_active_2 = '';
            if (old('is_active', ((isset($video)) ? $video->is_active : 1)) == 0) {
                $is_active_1 = '';
                $is_active_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="active" name="is_active" type="radio" value="1" {{$is_active_1}}>
                Active </label>
            <label class="radio-inline">
                <input id="not_active" name="is_active" type="radio" value="0" {{$is_active_2}}>
                In-Active </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_active') !!}
    </div>
    <div class="form-actions">
        {!! Form::button('حفظ <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}
    </div>
</div>
@push('scripts')
    <script src="{{asset('/')}}plugins/formvaliadtor/jquery.form-validator.min.js"></script>
    <script type="text/javascript">

        $('#media_type').change(function(){
          if($(this).val()=='video')
          {
           $('#type_change').html('<label for="youtube_link" class="bold">{{__("YouTube Link")}}</label><input class="form-control" id="YouTube Link" placeholder="YouTube Link" required="required" name="youtube_link" type="text">\n')
          }
          else{
              $('#type_change').html('<label for="file_path" class="bold">{{__("File")}}</label><input class="form-control" id="file_path" data-validation="size" data-validation-max-size="10M" data-validation-allowing="jpg, png,gif,pdf" required="required" name="file_path" type="file">');
          }
        });
        $.validate({
            modules : 'file',
            addValidClassOnAll : true,
            errorMessagePosition : 'top' // Instead of 'inline' which is default
        });
    </script>
@endpush