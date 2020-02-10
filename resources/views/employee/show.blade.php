@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('My Profile')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="userccount">
                                <div class="formpanel">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h5 class="am-title green-color"><i class="fa fa-user"
                                                                                aria-hidden="true"></i> {{__('My Profile')}}
                                                /
                                                <span style="color: #444;">{{$user->name}}</span></h5>
                                        </div>
                                    </div>

                                    <div class="row page-sec">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h6 class="am-sub-title green-color"> {{__('Personal Information')}}</h6>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-hover table-striped">
                                                <tr>
                                                    <td>{{__('Position')}}</td>
                                                    <td>{{__($user->role->role_name)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Name')}}</td>
                                                    <td>{{$user->name}}</td>
                                                </tr>
{{--                                                <tr>--}}
{{--                                                    <td>{{__('National ID Card No.')}}</td>--}}
{{--                                                    <td>{{$user->national_id_card_number}}</td>--}}
{{--                                                </tr>--}}
                                                <tr>
                                                    <td>{{__('State')}}</td>
                                                    <td>@if($user->state_id!=''){{$user->state->state}}@endif</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('City')}}</td>
                                                    <td>@if(isset($user->city_id)){{$user->city->city}}@endif</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Email')}}</td>
                                                    <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Phone Number')}}</td>
                                                    <td>{{$user->phone}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row page-sec">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h6 class="am-sub-title green-color">
                                                <span>{{__('Attachments')}}</span>
                                                <small class="green-color"><strong>({{count($uploads)}})</strong>
                                                </small>
                                            </h6>

                                        </div>
                                        @foreach ($uploads as $upload)
                                            <div class="col-md-1">

                                                <a href="\download_s3?path=employee_uploads&&name={{$upload->upload_file}}"   title="{{__('Click to download')}}" class="btn-link download_s3"> <img src="{{ asset('/') }}images/file.png" width="40px"></a>

                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="row page-sec">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h6 class="am-sub-title green-color">{{__('Certificates')}}</h6>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-hover table-striped">
                                                @foreach ($educations as $education)
                                                    <tr class="data-row">
                                                        <td>{{$education->degree_title}}</td>
                                                        <td>{{$education->date_completion}}</td>
                                                    </tr>
                                                @endforeach

                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 pull-left">
                                            <div class="formrow text-left">
                                                <a href="{{ route('employee.edit1',['id'=>Crypt::encryptString($user->id)]) }}"
                                                   class="btn btn-default"><i class="fa fa-pencil"
                                                                              aria-hidden="true"></i> {{__('Edit')}}</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('includes.footer')
@endsection