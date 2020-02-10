@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Project Detail')])

    <style>
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
    </style>
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    @include('flash::message')
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            @include('projects.inc.project_header')

                            @if ($errors->any())
                                <div class="panel panel-danger">

                                    <div class="panel-heading">
                                        @foreach ($errors->all() as $error)
                                            <p>{{$error}}</p>
                                        @endforeach
                                    </div>
                                </div>

                        @endif
                        <!-- Project Details -->
                            <div class="row proj-detail">
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <!-- About Project -->
                                    <div class="job-header">
                                        <div class="contentbox">
                                            <h5 class="green-color">{{__('Project Description')}}</h5>
                                            <div style="word-break: break-word; line-height: 1.5; text-align: justify; font-size: 13px;">{{$project->description}}</div>
                                        </div>
                                    </div>

                                    <div class="job-header">
                                        <div class="contentbox">
                                            <h5 class="green-color">{{__('Project Violations')}}</h5>
                                            @if(count($violations))
                                                <table class="table table-dark text-center" style="font-size: 12px">
                                                    <thead>
                                                    <tr>
                                                        {{--                                                        <th scope="col">{{__('Date')}}</th>--}}
                                                        {{--                                                        <th scope="col">{{__('Code')}}</th>--}}
                                                        <th scope="col">{{__('Danger Category')}}</th>
                                                        <th scope="col">{{__('Danger Level')}}</th>
                                                        <th class="trial-hidden" scope="col">{{__('Invoice')}}</th>
                                                        <th class="trial-hidden" scope="col">{{__('Paid')}}</th>
                                                        <th scope="col">{{__('Details')}}</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($violations as $violation)
                                                        <tr>
                                                            {{--                                                            <th scope="row">{{\Arabic\Arabic::adate(' j F Y ', strtotime($violation->gregorian_date))}}</th>--}}
                                                            {{--                                                            <td>{{$project->code }} - {{$violation->code}}‬</td>--}}
                                                            <td style="text-overflow: ellipsis;white-space: nowrap;max-width: 125px;overflow: hidden;">{{$violation->sub_cat->state}}</td>
                                                            <td>{{__($violation->danger_status)}}</td>

                                                            <td class="trial-hidden">
                                                                <a data-toggle="modal" data-target="#invoiceModal"
                                                                   title="{{__('Invoice')}}"><i
                                                                            class="fa fa-dollar "></i></a>
                                                            {{--                                            <button class="btn btn-sm" data-toggle="modal"--}}
                                                            {{--                                                    data-target="#invoiceModal">{{__('Invoice')}}</button>--}}

                                                            <!-- Invoice Modal -->
                                                                <div class="modal fade" id="invoiceModal" tabindex="-1"
                                                                     role="dialog"
                                                                     aria-labelledby="invoiceModalLabel"
                                                                     aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title green-color"
                                                                                    id="invoiceModalLabel">{{__('Invoice')}}</h5>
                                                                                <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close"><span
                                                                                            aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body" id="capture"
                                                                                 style="text-align: left;direction:rtl;background-color: #fff">
                                                                                <div style="border: 1px solid #dadada;border-radius: 2px; padding: 10px; margin-bottom: 15px;">
                                                                                    <table width="100%">
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <td><strong>{{__('Date')}}
                                                                                                    :</strong> {{\Arabic\Arabic::adate(' j F Y ', strtotime(date('y-m-d')))}}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <strong>{{__('Project Name')}}
                                                                                                    :</strong> {{$project->name}}
                                                                                            </td>
                                                                                            <td><strong>{{__('Owner')}}
                                                                                                    :</strong> {{$project->owner}}
                                                                                                / {{__($project->project_type)}}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2">
                                                                                                <strong>{{__('Danger Category')}}
                                                                                                    :</strong>{{$violation->danger_cat->country}}
                                                                                                / {{$violation->sub_cat->state}}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <strong>{{__('Violation Code')}}
                                                                                                    :</strong> {{$project->code }}
                                                                                                - {{$violation->code}}
                                                                                            </td>
                                                                                        </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <div style="border: 1px solid #dadada;border-radius: 2px; padding: 10px;">
                                                                                    <h6>{{__('Invoice Details')}}</h6>
                                                                                    <table class="table table-striped table-hover">
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <th>{{__('Main Fine')}}
                                                                                                ({{__('SAR')}})
                                                                                            </th>
                                                                                            <td>{{\Arabic\Arabic::adate(' j F Y ', strtotime($violation->gregorian_date))}}</td>
                                                                                            <td>{{$violation->cost}}</td>
                                                                                        </tr>
                                                                                        @foreach($violation->history as $trial)
                                                                                            <tr>
                                                                                                <th>{{__('Violation Follow Up')}}
                                                                                                    ({{__('SAR')}})
                                                                                                </th>
                                                                                                <td>{{\Arabic\Arabic::adate(' j F Y ', strtotime($trial->created_at))}}</td>
                                                                                                <td>{{$trial->cost}}</td>
                                                                                            </tr>
                                                                                        @endforeach

                                                                                        <tr>
                                                                                            <th><strong>{{__('Total')}}
                                                                                                    ({{__('SAR')}}
                                                                                                    )</strong></th>
                                                                                            <td colspan="2">
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
                                                                                      method="post"
                                                                                      style="display: inline-block;">
                                                                                    <input type="hidden"
                                                                                           value="{{$violation->id}}"
                                                                                           id="pdf-data"
                                                                                           name="pdf-data">
                                                                                    @csrf
                                                                                    <button type="submit"
                                                                                            class="btn btn-default-focus">
                                                                                        <i class="fa fa-download"></i> {{__('Download')}}
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </td>
                                                            <td class="trial-hidden">
                                                                @if ($violation->payment_status)
                                                                    @php $disabled="fa-check-circle green-color"; @endphp
                                                                @else
                                                                    @php $disabled="fa-times-circle red-color"; @endphp
                                                                @endif

                                                                <i class="fa {{$disabled}}"></i>
                                                            </td>

                                                            <td>
                                                                <a href="{{route('project.violation.detail',['id1'=>Crypt::encryptString($project->id),'id2'=>Crypt::encryptString($violation->id)])}}"><i
                                                                            class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                    </tbody>
                                                </table>

                                                <a href="{{route('project.project_violations',['id'=>Crypt::encryptString($project->id)])}}"
                                                   class="pull-left green-color"
                                                   style="font-weight: bold;">{{__('More...')}}</a>
                                            @else
                                                <div class="row page-sec" style="margin-top: 20px">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <h6 class="text-center"
                                                            style="color: #908f8f; margin-bottom: 0;">{{__('No Results!!')}}</h6>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="job-header">
                                        <div class="contentbox">
                                            <h5 class="green-color">{{__('Project Studies')}}
                                                @canany(['project-consultant','safety-consultant'])
                                                    <button class="btn btn-default pull-left" data-toggle="modal"
                                                            data-target="#studyModal"
                                                            style="font-size: 12px; font-weight: bold;"><i
                                                                class="fa fa-upload"
                                                                aria-hidden="true"></i> {{__('Add Study')}}
                                                    </button>@endcan
                                            </h5>
                                            <!-- Invoice Modal -->
                                            @if($uploads_count>0)
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item active">
                                                        <a class="nav-link" id="fires-tab" data-toggle="tab"
                                                           href="#fires"
                                                           role="tab" aria-controls="fires"
                                                           aria-selected="true">{{__('Fire and Alarm')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="evacuation-tab" data-toggle="tab"
                                                           href="#evacuation"
                                                           role="tab" aria-controls="evacuation"
                                                           aria-selected="false">{{__('Evacuation and Rescue')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="danger-tab" data-toggle="tab"
                                                           href="#danger"
                                                           role="tab"
                                                           aria-controls="danger"
                                                           aria-selected="false">{{__('Dangerous Areas')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="surrounding-tab" data-toggle="tab"
                                                           href="#surrounding"
                                                           role="tab" aria-controls="surrounding"
                                                           aria-selected="false">{{__('Surrounding Environment')}}</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade in active" id="fires" role="tabpanel"
                                                         aria-labelledby="home-tab">

                                                        @foreach($fires as $fire)
                                                            <div class="row" style="margin-bottom: 10px">
                                                                <div class="col-md-4 col-sm-4 col-xs-4">{{__($fire->employee->name)}}</div>
                                                                <div class="col-md-4 col-sm-4 col-xs-4">{{\Arabic\Arabic::adate(' j F Y ', strtotime($fire->created_at))}}</div>
                                                                <div class="col-md-2 col-sm-2 col-xs-2"><a
                                                                            href="{{$storage_url}}amen_project/studies/{{$fire->upload_file}}"
                                                                            title="{{__('View')}}" target="_blank"><i
                                                                                class="fa fa-eye"
                                                                                aria-hidden="true"></i></a>
                                                                </div>
                                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                                    <a href="\download_s3?path=amen_project/studies&&name={{$fire->upload_file}}"
                                                                       title="{{__('Fire and Alarm')}}"><i
                                                                                class="fa fa-download"
                                                                                aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="tab-pane fade" id="evacuation" role="tabpanel"
                                                         aria-labelledby="contact-tab">
                                                        @foreach($evacuations as $evacuation)
                                                            <div class="row" style="margin-bottom: 10px">
                                                                <div class="col-md-4 col-sm-4 col-xs-4">{{__($evacuation->employee->name)}}</div>
                                                                <div class="col-md-4 col-sm-4 col-xs-4">{{\Arabic\Arabic::adate(' j F Y ', strtotime($evacuation->created_at))}}</div>
                                                                <div class="col-md-2 col-sm-2 col-xs-2"><a
                                                                            href="{{$storage_url}}amen_project/studies/{{$evacuation->upload_file}}"
                                                                            title="{{__('View')}}" target="_blank"><i
                                                                                class="fa fa-eye"
                                                                                aria-hidden="true"></i></a>
                                                                </div>
                                                                <div class="col-md-2 col-sm-2 col-xs-2"><a
                                                                            href="\download_s3?path=amen_project/studies&&name={{$evacuation->upload_file}}"
                                                                            title="{{__('Evacuation and Rescue')}}"
                                                                            download="book.pdf"><i
                                                                                class="fa fa-download"
                                                                                aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="tab-pane fade" id="danger" role="tabpanel"
                                                         aria-labelledby="profile-tab">
                                                        @foreach($dangerous_areas as $dangerous_area)
                                                            <div class="row" style="margin-bottom: 10px">
                                                                <div class="col-md-4 col-sm-4 col-xs-4">{{__($dangerous_area->employee->name)}}</div>
                                                                <div class="col-md-4 col-sm-4 col-xs-4">{{\Arabic\Arabic::adate(' j F Y ', strtotime($dangerous_area->created_at))}}</div>
                                                                <div class="col-md-2 col-sm-2 col-xs-2"><a
                                                                            href="{{$storage_url}}amen_project/studies/{{$dangerous_area->upload_file}}"
                                                                            title="{{__('View')}}" target="_blank"><i
                                                                                class="fa fa-eye"
                                                                                aria-hidden="true"></i></a>
                                                                </div>
                                                                <div class="col-md-2 col-sm-2 col-xs-2"><a
                                                                            href="\download_s3?path=amen_project/studies&&name={{$dangerous_area->upload_file}}"
                                                                            title="{{__('Dangerous Areas')}}"
                                                                            download="book.pdf"><i
                                                                                class="fa fa-download"
                                                                                aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="tab-pane fade" id="surrounding" role="tabpanel"
                                                         aria-labelledby="contact-tab">
                                                        @foreach($surroundings as $surrounding)
                                                            <div class="row" style="margin-bottom: 10px">
                                                                <div class="col-md-4 col-sm-4 col-xs-4">{{__($surrounding->employee->name)}}</div>
                                                                <div class="col-md-4 col-sm-4 col-xs-4">{{\Arabic\Arabic::adate(' j F Y ', strtotime($surrounding->created_at))}}</div>
                                                                <div class="col-md-2 col-sm-2 col-xs-2"><a
                                                                            href="{{$storage_url}}amen_project/studies/{{$surrounding->upload_file}}"
                                                                            title="{{__('View')}}" target="_blank"><i
                                                                                class="fa fa-eye"
                                                                                aria-hidden="true"></i></a>
                                                                </div>
                                                                <div class="col-md-2 col-sm-2 col-xs-2"><a
                                                                            href="\download_s3?path=amen_project/studies&&name={{$surrounding->upload_file}}"
                                                                            title="{{__('Surrounding Environment')}}"><i
                                                                                class="fa fa-download"
                                                                                aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <a href="{{route('project.studies',[Crypt::encryptString($project->id)])}}"
                                                   class="pull-left green-color"
                                                   style="font-weight: bold;">{{__('More...')}}</a>
                                            @else
                                                <div class="row page-sec" style="margin-top: 20px">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <h6 class="text-center"
                                                            style="color: #908f8f; margin-bottom: 0;">{{__('No Results!!')}}</h6>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <!-- Company Details start -->
                                    <div class="job-header">
                                        <div class="jobdetail">
                                            <h3>{{__('Project Detail')}}</h3>
                                            @if($assignees_count>0)
                                                <ul class="jbdetail">
                                                    @if($contractor_managers_count>0)
                                                        <li class="row">
                                                            <div class="col-md-12 col-xs-12"><p>
                                                                    <strong>{{__('Contractor')}}</strong></p></div>
                                                            <div class="col-md-12 col-xs-12">
                                                                @foreach($contractor_managers as $contractor_manager)
                                                                    @php $title='';@endphp
                                                                    @foreach( $sub_contractors as  $sub_contractor)
                                                                        @if($sub_contractor->pivot->employee_head_id==$contractor_manager->id)
                                                                            @php  $title.= $sub_contractor->name."<br>"@endphp
                                                                        @endif
                                                                    @endforeach
                                                                    <p data-toggle="tooltip" data-html="true"
                                                                       title="{{$title}}" class="project-tooltip"
                                                                       data-placement="left">{{$contractor_manager->name}}</p><br>
                                                                @endforeach
                                                            </div>
                                                        </li>
                                                    @endif
                                                    @if($safety_managers_count>0)
                                                        <li class="row">
                                                            <div class="col-md-12 col-xs-12"><p>
                                                                    <strong>{{__('Safety_consultant')}}</strong></p>
                                                            </div>
                                                            <div class="col-md-12 col-xs-12">
                                                                @foreach( $safety_managers as  $safety_manager)
                                                                    @php $title='';@endphp
                                                                    @foreach( $sub_safeties as  $sub_safety)
                                                                        @if($sub_safety->pivot->employee_head_id==$safety_manager->id)
                                                                            @php  $title.= $sub_safety->name."<br>"@endphp
                                                                        @endif
                                                                    @endforeach
                                                                    <p data-toggle="tooltip" data-html="true"
                                                                       title="{{$title}}" class="project-tooltip"
                                                                       data-placement="left"> {{$safety_manager->name}} </p><br>
                                                                @endforeach
                                                            </div>
                                                        </li>
                                                    @endif

                                                    @if($project_managers_count>0)
                                                        <li class="row">
                                                            <div class="col-md-12 col-xs-12"><p>
                                                                    <strong>{{__('Project_consultant')}}</strong></p>
                                                            </div>
                                                            <div class="col-md-12 col-xs-12">
                                                                @foreach($project_managers as $project_manager)
                                                                    @php $title='';@endphp
                                                                    @foreach( $sub_projects as  $sub_project)
                                                                        @if($sub_project->pivot->employee_head_id==$project_manager->id)
                                                                            @php  $title.= $sub_project->name."<br>"@endphp
                                                                        @endif
                                                                    @endforeach
                                                                    <p data-toggle="tooltip" data-html="true"
                                                                       title="{{$title}}" class="project-tooltip"
                                                                       data-placement="left">{{$project_manager->name}}</p><br>

                                                                @endforeach
                                                            </div>
                                                        </li>
                                                    @endif

                                                    <li class="row">
                                                        <div class="col-md-9 col-xs-9">
                                                            <p>{{__('Number of Employees')}}</p>
                                                        </div>
                                                        <div class="col-md-3 col-xs-3 text-left">
                                                            <p><strong>{{$total_employees}}</strong></p></div>
                                                    </li>
                                                </ul>
                                            @else
                                                <div class="row page-sec" style="margin-top: 20px">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <h6 class="text-center"
                                                            style="color: #908f8f; margin-bottom: 0;">{{__('No Results!!')}}</h6>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Project MAp -->
                                    <div class="job-header">
                                        <input type="hidden" name="latitude" id="latitude"
                                               value="{{$project->latitude}}">
                                        <input type="hidden" name="longitude" id="longitude"
                                               value="{{$project->longitude}}">
                                        <div class="jobdetail" style="min-height: 300px; height: 100%" id="googleMap">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row proj-stat">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="job-header">
                                        <div class="contentbox">
                                            <h5 class="green-color"><i
                                                        class="fa fa fa-bar-chart"></i> {{__('Project Violation Types')}}
                                            </h5>
                                            <div id="piechart" style=" height: 300px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="display:none">
                                    <div class="job-header">
                                        <div class="contentbox">
                                            <h5 class="green-color"><i
                                                        class="fa fa fa-bar-chart"></i> {{__('Violations Payment Status')}}
                                            </h5>
                                            <div id="columnchart_material" style=" height: 300px;"></div>
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
    <div id="myList" style="display: none;"></div>
    @include('includes.footer')

@endsection
@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZRr6CKJzMijVKkL1du2k-CesBshdv_64"></script>
    <script type="text/javascript">
        var latitude = $('#latitude').val();
        var longitude = $('#longitude').val();
        var markers = [];
        map(latitude, longitude);

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

        //////////////////////////////////////////////////////////////////////////////////////////
        $(".print-btn").click(function () {
            var divToPrint = $(this).parent().parent().children('.modal-body')[0];
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html lang="ar" class="rtl" dir="rtl"><head><link rel="stylesheet" href="{{asset('/')}}css/main.css" type="text/css" /> <link rel="stylesheet" href="{{asset('/')}}css/rtl-style.css" type="text/css" /></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
            newWin.document.close();
        });

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['type', 'count'],<?php echo $pie_data?>
            ]);

            var options = {
                title: '<?php echo __('Project Violations')?>'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Paid', 'NotPaid'],<?php echo $columnchart_data ?>
            ]);

            var options = {
                chart: {
                    title: '<?php echo __('Violations Payment')?>',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
@endpush
