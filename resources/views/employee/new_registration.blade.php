@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('New User')])
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
                                        <div class="col-md-12 col-xs-12">
                                            <h5 class="am-title green-color"><i class="fa fa-users"
                                                                                aria-hidden="true"></i> {{__('New Users')}}
                                                /
                                                <span style="color: #444;">{{$user->name}}</span></h5>
                                        </div>
                                    </div>

                                    <div class="row page-sec">
                                        <div class="col-md-12 col-xs-12">
                                            <h6 class="am-sub-title green-color"> {{__('New User Info')}}</h6>
                                        </div>
                                        <div class="col-md-12 col-xs-12 am-sec">
                                            <strong>{{__('Position')}}:</strong>
                                            <span>{{__($user->role->role_name)}}</span>
                                        </div>
                                        <div class="col-md-12 col-xs-12 am-sec">
                                            <strong>{{__('Name')}}:</strong>
                                            <span>{{$user->name}}</span>
                                        </div>
                                        <div class="col-md-12 col-xs-12 am-sec">
                                            <strong>{{__('National ID Card No.')}}:</strong>
                                            <span>{{$user->national_id_card_number}}</span>
                                        </div>
                                        <div class="col-md-12 col-xs-12 am-sec">
                                            <strong>{{__('Email')}}:</strong>
                                            <span><a href="mailto:{{$user->email}}">{{$user->email}}</a></span>
                                        </div>
                                        <div class="col-md-12 col-xs-12 am-sec">
                                            <strong>{{__('Phone Number')}}:</strong>
                                            <span>{{$user->phone}}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <h6 class="am-sub-title"><i class="fa fa-paperclip green-color"
                                                                        aria-hidden="true"></i>
                                                <span>{{__('Attachments')}}</span>
                                                <small class="green-color"><strong>({{count($uploads)}})</strong></small>
                                            </h6>

                                        </div>
                                        @foreach ($uploads as $upload)

                                            <div class="col-md-1">
                                                <a href="\download_s3?path=employee_uploads&&name={{$upload->upload_file}}"
                                                   alt="" title="{{__('Click to download')}}" download=""> <img
                                                            src="{{ asset('/') }}images/file.png" width="40px"></a>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="row">
                                        <form method="post" action="{{route('new_register_verify')}}">
                                            @csrf
                                            <div class="col-md-4 pull-left">
                                                <input type="hidden" name="id" value="{{$user->id }}">
                                                <div class="formrow text-left">
                                                    <button type="submit"
                                                            class="btn btn-default">{{__('Send Verification Link')}}</button>
                                                </div>
                                            </div>
                                        </form>

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