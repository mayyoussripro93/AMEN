{{--@if ($errors->any())--}}
{{--                @foreach ($errors->all() as $error)--}}
{{--                    <p>{{$error}}</p>--}}
{{--                @endforeach--}}
{{--@endif--}}
@csrf
<div class="row page-sec">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="formrow">
            <h6 class="am-sub-title green-color">{{__('Profile Image')}}</h6>
            <div id="thumbnail">
                @if(isset($employee))
                    {{Auth::guard('employee')->user()->printUserImage()}}
                @else
                    <img src="{{ asset('/') }}admin_assets/no_image.jpg">
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="formrow">
            <label class="btn btn-default"> {{__('Select Profile Image')}}
                <input type="file" name="image" id="image"
                       style="display: none;">
            </label>
            <span class="help-block"> <strong>{{ $errors->first('image') }}</strong> </span>

        </div>
    </div>
</div>
<div class="row page-sec">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h6 class="am-sub-title green-color">{{__('Personal Information')}}</h6>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'name') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Name')}}:</label>
            {!! Form::text('name', null, array('class'=>'form-control', 'id'=>'name', 'placeholder'=>__('Name'),'data-validation'=>'required' )) !!}
            <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'name') !!}</span>

        </div>
    </div>
{{--    <div class="col-md-6 col-sm-6 col-xs-12">--}}
{{--        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'national_id_card_number') !!}">--}}
{{--            <label class="am-label"><span class="red-color">*</span> {{__('National ID Card No.')}}:</label>--}}
{{--            {!! Form::text('national_id_card_number', null, array('class'=>'form-control', 'id'=>'national_id_card_number','data-validation'=>'number','data-validation'=>'length','data-validation-length'=>'10', 'placeholder'=>__('National ID Card No.'))) !!}--}}
{{--            <span class="help-block">  {!! APFrmErrHelp::showErrors($errors, 'national_id_card_number') !!} </span>--}}
{{--        </div>--}}
{{--    </div>--}}
    {{--    <div class="col-md-6 col-sm-6 col-xs-12">--}}
    {{ Form::hidden('country_id', 191, array('id' => 'country_id')) }}
    {{--    </div>--}}

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'city_id') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('City')}}:</label>
            <span id="city_dd"> {!! Form::select('city_id', [''=>__('Select City')]+$cities, null, array('class'=>'form-control','data-validation'=>'required', 'id'=>'city_id')) !!} </span>
            <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}</span>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_employer') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Job Employer')}}:</label>
            {!! Form::text('job_employer', null, array('class'=>'form-control', 'id'=>'job_employer', 'placeholder'=>__('Job Employer'),'data-validation'=>'required')) !!}
            <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'job_employer') !!} </span>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_title') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Job Title')}}:</label>
            {!! Form::text('job_title', null, array('class'=>'form-control', 'id'=>'job_title', 'placeholder'=>__('Job Title'),'data-validation'=>'required')) !!}
            <span class="help-block">  {!! APFrmErrHelp::showErrors($errors, 'job_title') !!} </span>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'email') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Email')}}:</label>
            {!! Form::text('email', null, array('class'=>'form-control', 'id'=>'email', 'placeholder'=>__('Email'),'data-validation'=>'email')) !!}
            <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'email') !!} </span>
        </div>
    </div>

    {{ Form::hidden('nationality_id', 191, array('id' => 'nationality_id')) }}

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'phone') !!}">
            <label class="am-label"><span class="red-color">*</span> {{__('Phone')}}:</label>
            {!! Form::text('phone', null, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>__('Phone'),'data-validation'=>'number','data-validation'=>'length','data-validation-length'=>'10' ,'data-validation-optional'=>'true')) !!}
            <span class="help-block">  {!! APFrmErrHelp::showErrors($errors, 'phone') !!}</span>
        </div>
    </div>

</div>
<!-- End personal Information -->

<div class="row page-sec">
    <div class="col-md-12 {!! APFrmErrHelp::hasError($errors, 'date_completion.0') !!}">
        <h6 class="am-sub-title green-color">{{__('Education / Training')}}</h6>
        <table class="table table-bordered table-condensed text-center"
               style="margin-top: 15px">
            @if(isset($educations))
                @foreach ($educations as $education)
                    <tr class="data-row">
                        <td>{{$education->degree_title}}</td>
                        <td>{{$education->date_completion}}</td>
                    </tr>
                @endforeach
            @endif
            <tr class="data-row">
                <td><input type="text" name="degree_title[]"
                           class="form-control"
                           placeholder="{{__('Degree Title')}}"
                           value="{{old('degree_title.0')}}"></td>
                <td><input type="text" name="date_completion[]"
                           class="form-control"
                           placeholder="{{__('Year')}}"
                           value="{{old('date_completion.0')}}"></td>
                <td>
                    <button type="button"
                            class="btn btn-secondary add_more"><span
                                class="fa fa-plus"></span></button>
                </td>
            </tr>

            <tbody id="adding_area">
            </tbody>
        </table>
        <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'date_completion.0') !!} </span>

    </div>
</div>

<div class="row page-sec">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="formrow{{ $errors->has('uploads[]') ? ' has-error' : '' }}">
            <h6 class="am-sub-title green-color">{{__('Attachments')}}</h6>
            @if(isset($uploads))
                @foreach ($uploads as $upload)
                    <div class="col-md-1" style="margin-bottom: 5px;">
                        {{--									{{ImgUploader::print_doc("employee_uploads/$upload->upload_file", $upload->title, $upload->title)}}--}}
                        <a href="\download_s3?path=employee_uploads&&name={{$upload->upload_file}}" alt=""
                           title="{{__('Click to download')}}" download=""> <img src="{{ asset('/') }}images/file.png"
                                                                                 width="40"></a>

                    </div>
                @endforeach
            @endif

            <input type="file" class="form-control-file form-control" id="exampleFormControlFile1" name="uploads[]" multiple="multiple"
                   data-validation="size" data-validation-max-size="10M">
            <small class="hint red-color">{{__('Allowed (max size:10M)')}}</small>
            <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'uploads[]') !!} </span>

        </div>
    </div>
</div>

<div class="row" style="margin-top: 30px;">
    <div class="col-md-4 pull-left">
        <button type="submit" class="btn"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{__('Save')}}
        </button>
    </div>
</div>
@push('styles')
    <style type="text/css">
        .employeeccount p {
            text-align: left !important;
        }

        .datepicker > div {
            display: block;
        }
    </style>
@endpush
@push('scripts')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#salary_currency').typeahead({
                source: function (query, process) {
                    return $.get("{{ route('typeahead.currency_codes') }}", {query: query}, function (data) {
                        console.log(data);
                        data = $.parseJSON(data);
                        return process(data);
                    });
                }
            });

            /*******************************/
            var fileInput = document.getElementById("image");
            fileInput.addEventListener("change", function (e) {
                var files = this.files
                showThumbnail(files)
            }, false)

            function showThumbnail(files) {
                $('#thumbnail').html('');
                for (var i = 0; i < files.length; i++) {
                    var file = files[i]
                    var imageType = /image.*/
                    if (!file.type.match(imageType)) {
                        console.log("Not an Image");
                        continue;
                    }
                    var reader = new FileReader()
                    reader.onload = (function (theFile) {
                        return function (e) {
                            $('#thumbnail').append('<div class="fileattached"><img height="100px" src="' + e.target.result + '" > <div>' + theFile.name + '</div><div class="clearfix"></div></div>');
                        };
                    }(file))
                    var ret = reader.readAsDataURL(file);
                }
            }

            //////////////////////////////add more eductaion field//////////////////
            $(".add_more").click(function () {
                $("#adding_area").append('<tr id="data-row">' +
                    '<td><input type="text" name="degree_title[]" class="form-control" placeholder="{{__('Degree Title')}}"></td>' +
                    '<td><input type="text" name="date_completion[]" class="form-control"placeholder="{{__('Year')}}"></td>' +
                    '<td><button type="button" class="btn btn-danger remove"><span class="glyphicon glyphicon-remove"></span></button></td>' +
                    '</tr>');

                $(".remove").click(function () {
                    $(this).parent().parent().remove();
                });

            });



        });


    </script>
@endpush
