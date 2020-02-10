@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Delete Account')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="userccount">
                                <div class="row page-sec">
                                    <div class="text-center">
                                        <img src="{{ asset('/') }}images/amen_logo.png"
                                             alt="{{ $siteSetting->site_name }}"
                                             height="120">
                                    </div>

                                    <div class="formpanel text-center">
                                        @if(Auth::guard('employee')->user()->delete_request=='')
                                        <form name="delete_account" method="post"
                                              action="{{route('delete.account.post')}}">
                                            @csrf
                                            <h4 class="green-color"><i class="fa fa-trash-o" aria-hidden="true"></i> {{__('Delete Account')}} </h4>
                                            <p>{{__('Are you sure? You will delete your account from Amen Platform.')}}</p>
                                            <div class="col-md-4" style="margin: 25px auto; float: none;">
                                            <button type="submit" class="btn btn-danger btn-mini"> {{__('Yes')}}</button>
                                            </div>
                                        </form>
                                            @else <h6 class="green-color">{{__('Request Has Been Created')}}</h6>
                                            <p>{{__("Your request will be confirmed by the admin and you'll receive an email to assure the deletion process." )}}</p>
                                            @endif
                                    </div>

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