@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->

    <div class="container-fluid main-content">
        <div class="container section mapwrap">

            <div class="row">

                <div class="col-md-12 col-xs-12">
                    <div class="map-container">

                        <!-- Start Contact Us -->
                        <h2 class="am-title green-color text-center">{{__('Contact Us')}}</h3>
                        <div class="row contacts">
                            <div class="col-md-8 col-sm-12 col-xs-12" style="margin: 25px auto; float: none;">
                                <div class="row" style="margin-right: 0; margin-left: 0;">
                                    <div class="col-md-6 col-sm-6 col-xs-12 text-center">
                                        <div class="init-info">
                                            <i class="fa fa-phone"></i>
                                            <h6><strong class="green-color">يمكنك التواصل معنا عبر الهاتف</strong></h6>
                                            <h4 style="color: #555; direction: ltr;">{{$siteSetting->site_phone_primary}}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 text-center">
                                        <div class="init-info">
                                            <i class="fa fa-envelope-o"></i>
                                            <h6><strong class="green-color">أو مراسلتنا عبر البريد الإلكتروني</strong></h6>
                                            <h4><a href="mailto:{{$siteSetting->mail_from_address}}"
                                                   style="font-size: inherit; border: none; width: auto;">{{$siteSetting->mail_from_address}}</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-right: 0; margin-left: 0;">
                                    <div class="col-md-12 col-xs-12 contact-map" style="height: 300px; text-align: center; margin-top: 25px;">
                                        {!! $siteSetting->site_google_map !!}
                                    </div>
                                    <div class="col-md-12 col-xs-12 social-footer text-center">
                                        <a href="{{$siteSetting->facebook_address}}" target="_blank" title="{{__('Facebook')}}"><img
                                                    src="{{ asset('/') }}images/facebook.png" width="50"></a>
                                        <a href="{{$siteSetting->twitter_address}}" target="_blank" title="{{__('Twitter')}}"><img
                                                    src="{{ asset('/') }}images/twitter.png" width="50"></a>
                                        <a href="{{$siteSetting->instagram_address}}" target="_blank" title="{{__('Instagram')}}"><img
                                                    src="{{ asset('/') }}images/instagram.png" width="50"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Contact Us -->
                    </div>


                </div>

                <div class="col-md-12 col-xs-12">
                    <a href="{{route('safety.gallery')}}" style="text-decoration: none">
                        <div class="formpanel init-info text-center rules-btn">
                            <h3 class="am-title" style="margin-bottom: 0;">{{__('Safety and Health Rules')}}</h3>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>

    @include('includes.footer')
@endsection
@push('scripts')


@endpush