{!! APFrmErrHelp::showOnlyErrorsNotice($errors) !!}
@include('flash::message')
@csrf
<div class="form-body">
    <!-- START CREATE PROJECT FILE-->
    <div class="row page-sec">

        <div class="col-md-6">
            <div class="formrow no-margin-btm">
                <h6 class="am-sub-title green-color">{{__('Project Logo')}}</h6>
                <div id="thumbnail">
                    @if(isset($project))
                        {{$project->printProjectImage()}}
                    @else
                        <img src="{{ asset('/') }}admin_assets/no_image.jpg" width="150">
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow no-margin-btm">
                <label class="btn btn-default">{{__('Upload Project Logo')}}
                    <input type="file" name="logo" id="logo" style="display: none;">
                </label>
                {!! APFrmErrHelp::showErrors($errors, 'logo') !!}
            </div>

                <div class="formrow no-margin-btm">
                    <label class="am-label" style="display: inline-block;">{{__('Has the project been completed?')}}</label>
                    @php
                        if(isset($project))
                            $checked=$project->is_active==0? 'checked':'' ;
                      else $checked='';

                    @endphp



                    <label class="chk-lbl" style="display: inline-block;">
                        <input type="checkbox" value="1" name="is_active" {{$checked}}> {{__('Yes')}}
                        <span class="checkmark"></span>
                    </label>

                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::text('end_date',null, array('class'=>'form-control input-dates', 'placeholder'=>__('Project End Date'))) !!}

                        </div>
                    </div>
                </div>

        </div>
    </div>

    <div class="row page-sec">
        <div class="col-md-12">
            <h6 class="am-sub-title green-color">{{__('Project Detail')}}</h6>
        </div>
        <div class="col-md-6">
            <div class="formrow{{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="am-label"><span class="red-color">*</span> {{__('Project Name')}}:</label>
                {!! Form::text('name',null, array('class'=>'form-control', 'required'=>'required', 'placeholder'=>__('Project Name'))) !!}
                <span class="help-block"> <strong>{{ $errors->first('name') }}</strong> </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'date_gregorian') !!}">
                <label class="am-label"><span class="red-color">*</span> {{__('Project Start Date')}}:</label>
                {!! Form::text('date_gregorian',null, array('class'=>'form-control input-dates', 'required'=>'required','id'=>'date_gregorian', 'placeholder'=>__('Project Start Date'))) !!}
                <span class="help-block"> <strong>{{ $errors->first('date_gregorian') }}</strong> </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow{{ $errors->has('owner') ? ' has-error' : '' }}">
                <label class="am-label"><span class="red-color">*</span> {{__('Owner')}}:</label>
                {!! Form::text('owner',null, array('class'=>'form-control', 'required'=>'required', 'placeholder'=>__('Owner'))) !!}
                <span class="help-block"> <strong>{{ $errors->first('owner') }}</strong> </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow{{ $errors->has('project_type') ? ' has-error' : '' }}">
                <label class="am-label"><span class="red-color">*</span> {{__('Type')}}:</label>
                {!! Form::select('project_type', ['Private'=>__('Private'),'Governmental'=>__('Governmental')],null , array('class'=>'form-control')) !!}

                <span class="help-block"> <strong>{{ $errors->first('project_type') }}</strong> </span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="formrow{{ $errors->has('description') ? ' has-error' : '' }}">
                <label class="am-label"><span class="red-color">*</span> {{__('Project Description')}}:</label>
                {!! Form::textarea('description',null, array('class'=>'form-control', 'required'=>'required', 'rows'=>'3','placeholder'=>__('Project Description'))) !!}

                <p id="remaining_letters"></p>
                <span class="help-block"> <strong>{{ $errors->first('description') }}</strong> </span>
            </div>
        </div>
    </div>
    <div class="row page-sec">
        <div class="col-md-12">
            <h6 class="am-sub-title green-color">{{__('Project Location')}}</h6>
        </div>
        <div class="col-md-6">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}">
                <label class="am-label"><span class="red-color">*</span> {{__('State')}}:</label>
                {!! Form::select('state_id', ['' => __('Select State')] + $states, old('state_id'), array( 'id'=>'state_id' ,'class' => 'form-control')) !!}

                <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'city_id') !!}">
                <label class="am-label"><span class="red-color">*</span> {{__('City')}}:</label>
                <span id="city_dd">
                    {!! Form::select('city_id', ['' => __('Select City')] , old('city_id'), array( 'id'=>'city_id' ,'class' => 'form-control')) !!}
                    </span>
                <span class="help-block"> {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}</span>
            </div>
        </div>
        <div class="col-md-6">

           <div class="formrow{{ $errors->has('address') ? ' has-error' : '' }}">
                <label class="am-label">{{__('Project Location')}}:</label>
               {!! Form::hidden('latitude',null , array('class'=>'form-control','id'=>'latitude')) !!}
               {!! Form::hidden('longitude',null, array('class'=>'form-control','id'=>'longitude')) !!}

               {!! Form::text('address',null, array('class'=>'form-control','id'=>'address_location' ,'placeholder'=>__('Project Location'))) !!}

                <span class="help-block"> <strong>{{ $errors->first('address') }}</strong> </span>
            </div>
        </div>

        <div class="col-md-12">
            <div id="googleMap" style="width:100%;height:400px;"></div>
        </div>
    </div>
    <div class="row page-sec ms-section">
        <div class="col-md-12">
            <h6 class="am-sub-title green-color">{{__('Project Responsible Persons')}}</h6>
        </div>
        <div class="col-md-4 project-res">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'safety') !!}">
                <?php $selected_safety = old('safety', $safetyIds); //old selected?>
                {!! Form::label('safety', __('Safety_consultant')) !!}
                <span id="span3">{!! Form::select('safety[]', $projectsafety, $selected_safety, array('class'=>'form-control select3-multiple', 'id'=>'safety', 'multiple'=>'multiple')) !!}</span>
                <span class="help-block"> <strong>{{ $errors->first('safety') }}</strong> </span>

            </div>
        </div>
        <div class="col-md-4 project-res">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'consultant') !!}">
                <?php $selected_consultant = old('consultant', $consultantIds);//old selected?>
                {!! Form::label('consultant', __('Project_consultant')) !!}
                <span id="span4">{!! Form::select('consultant[]', $projectconsultant, $selected_consultant, array('class'=>'form-control select4-multiple', 'id'=>'consultant', 'multiple'=>'multiple')) !!}</span>
                {!! APFrmErrHelp::showErrors($errors, 'consultant') !!}
            </div>
        </div>
        <div class="col-md-4 project-res">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'contractor') !!}">
                <?php $selected_contractor = old('contractor', $contractorIds); //old selected?>
                {!! Form::label('contractor', __('Contractor')) !!}
                <span id="span5"> {!! Form::select('contractor[]', $projectcontractor, $selected_contractor, array('class'=>'form-control select5-multiple', 'id'=>'contractor', 'multiple'=>'multiple')) !!}</span>
                <span class="help-block"> <strong>{{ $errors->first('contractor') }}</strong> </span>

            </div>
        </div>
    </div>

        <div class="row page-sec">
            <div class="col-md-12">
                <h6 class="am-sub-title green-color">{{__('Project Statistics')}}</h6>
            </div>
            <div class="col-md-3">
                <div class="formrow{{ $errors->has('Traffic_Accidents') ? ' has-error' : '' }}">
                    <label class="am-label">{{__('Traffic Accidents')}}:</label>
                    {!! Form::text('Traffic_Accidents',null, array('class'=>'form-control' ,'placeholder'=>__('Traffic Accidents'))) !!}
                    <span class="help-block"> <strong>{{ $errors->first('Traffic_Accidents') }}</strong> </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="formrow{{ $errors->has('Fire') ? ' has-error' : '' }}">
                    <label class="am-label">{{__('Fire and explosions')}}:</label>
                    {!! Form::text('Fire',null, array('class'=>'form-control' ,'placeholder'=>__('Fire and explosions'))) !!}
                    <span class="help-block"> <strong>{{ $errors->first('Fire') }}</strong> </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="formrow{{ $errors->has('Injuries') ? ' has-error' : '' }}">
                    <label class="am-label">{{__('Injuries')}}:</label>
                    {!! Form::text('Injuries',null, array('class'=>'form-control' ,'placeholder'=>__('Injuries'))) !!}
                    <span class="help-block"> <strong>{{ $errors->first('Injuries') }}</strong> </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="formrow{{ $errors->has('Deaths') ? ' has-error' : '' }}">
                    <label class="am-label">{{__('Deaths')}}:</label>
                    {!! Form::text('Deaths',null, array('class'=>'form-control' ,'placeholder'=>__('Deaths'))) !!}
                    <span class="help-block"> <strong>{{ $errors->first('Deaths') }}</strong> </span>
                </div>
            </div>


        </div>
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 pull-left">
            <button type="submit" class="btn" style="width: 100%;"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{__('Save')}}
            </button>
        </div>
    </div>
</div>

@push('scripts')

    <script type="text/javascript">
        $(document).ready(function () {
            /*******************************/
            var latitude = $('#latitude').val();
            var longitude = $('#longitude').val();

            console.log(latitude);
            console.log(longitude);

            var markers = [];
            map(latitude, longitude);

/////////////////////////////////////////////////////////////////////////////////////
            $('.select3-multiple').select2({
                allowClear: true
            });
            $('.select4-multiple').select2({
                allowClear: true
            });
            $('.select5-multiple').select2({
                allowClear: true
            });

            var fileInput = document.getElementById("logo");
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
                            $('#thumbnail').append('<div class="fileattached"><img height="150" width="150" src="' + e.target.result + '" > <div>' + theFile.name + '</div><div class="clearfix"></div></div>');
                        };
                    }(file))
                    var ret = reader.readAsDataURL(file);
                }
            }
            /****************************************************************/
            $('.input-dates').daterangepicker({
                "singleDatePicker": true,
                // "timePicker": true,
                // "timePicker24Hour": true,
                "locale": {
                    "format": "YYYY-MM-DD",
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
            }).on('apply.daterangepicker', function(ev, picker) {
                console.log(picker.startDate.format('YYYY-DD'));
                console.log(picker.endDate.format('YYYY-MM-DD'));
            });
            /****************************************************************/
//////////////////////////map code//////////////////////////////////////////////////////////////////////
            // 24.774265 ,46.738586
            function map(latitude, longitude) {
                var geocoder = new google.maps.Geocoder();

                var mapProp = {
                    center: new google.maps.LatLng(latitude, longitude),
                    zoom: 15,
                };
                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(latitude, longitude),
                    map: map,
                });
                markers.push(marker);
                ///////////////////////////////////////////////////////
                google.maps.event.addListener(map, 'click', function (event) {

                    for (var i = 0; i < markers.length; i++) {//remove marker
                        markers[i].setMap();
                    }
                    geocoder.geocode({'latLng': event.latLng}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {

                                document.getElementById("address_location").value = results[0].formatted_address;//set location text
                                $('#latitude').val(event.latLng.lat());
                                $('#longitude').val(event.latLng.lng());
                                var latLng = event.latLng;
                                var mapProp = {//set location
                                    center: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()),
                                    zoom: 7,
                                };

                                marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()),
                                    map: map,
                                });
                                markers.push(marker);
                            }
                        }
                    });
                });
            }
            function getlat_long() {
                var city_id = $('#city_id').val();
                var state_id = $('#state_id').val();
                if (city_id != '') {
                    $.post("{{ route('fetch.city.latlong') }}", {
                        city_id: city_id,
                        state_id: state_id,
                        _method: 'POST',
                        _token: '{{ csrf_token() }}'
                    })
                        .done(function (response) {
                            var obj = JSON.parse(response);
                            var latitude = obj.latitude;
                            var longitude = obj.longitude;

                            map(latitude, longitude)
                        });
                }
            }

///////////////////////////////////////////////////////////////////////////////////////////////
            filterDefaultCities(<?php echo old('city_id', (isset($project)) ? $project->city_id : 0); ?>);
            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterDefaultCities(0);
///////////////////////fetch avilable state employee///////////////////////////////////////////
                var state_id = $('#state_id').val();

                $.post("{{ route('fetch-admin-state-employee') }}",
                    {state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        var obj = JSON.parse(response);
                        $('#span5').html(obj.projectcontractor);
                        $('.select5-multiple').select2({allowClear: true});
                        $('#span4').html(obj.projectconsultant);
                        $('.select4-multiple').select2({allowClear: true});
                        $('#span3').html(obj.projectsafety);
                        $('.select3-multiple').select2({allowClear: true});
                    });
            });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            function filterDefaultCities(city_id)
            {
                var state_id = $('#state_id').val();
                if (state_id != '') {
                    $.post("{{ route('filter.lang.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                        .done(function (response) {
                            $('#city_dd').html(response);

                            $('#city_id').change(function () {
                                document.getElementById("address_location").value = '';//set location text
                                $('#latitude').val();
                                $('#longitude').val();
                                getlat_long();
                            });


                        });
                }
            }
            /////////////////////////////////////////////////////////////

        });


    </script>
@endpush
