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

                    <!-- Start Technical Support -->
                    <h3 class="am-title green-color text-center"><img src="{{ asset('/') }}images/support.png"
                                                                      width="55"
                                                                      style="vertical-align: middle;"> {{__('Technical Support')}}
                    </h3>

                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12" style="margin: 0 auto 25px; float: none;">
                            <form class="form-horizontal" method="POST" action="{{route('report.abuse')}}">
                                {{ csrf_field() }}

                                <div class="row formpanel" style="margin-right: 0; margin-left: 0;">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="formrow">
                                            <label class="am-label"><span class="red-color">*</span> {{__('Name')}}
                                                :</label>
                                            <input id="name" type="text" class="form-control" name="your_name" {{ old('your_name') }}
                                                   value="" required placeholder="{{__('Name')}}">
                                            <span class="help-block">
                                                                <strong></strong>
                                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="formrow{{ $errors->has('your_email') ? ' has-error' : '' }}">
                                            <label class="am-label"><span class="red-color">*</span> {{__('Email')}}
                                                :</label>
                                            <input id="email" type="email" class="form-control" name="your_email"
                                                   value="{{ old('your_email') }}" required autofocus
                                                   placeholder="{{__('Email')}}">
                                            <span class="help-block">
                                                                <strong>{{ $errors->first('your_email') }}</strong>
                                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="formrow">
                                            <label class="am-label"><span class="red-color">*</span> {{__('Subject')}}:</label>
                                            <input id="subject" type="text" class="form-control" name="subject" value="" required placeholder="{{__('Subject')}}">
                                            <span class="help-block"><strong></strong></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="formrow">
                                            <label class="am-label"><span class="red-color">*</span> {{__('Message')}}
                                                :</label>
                                            <textarea class="form-control" rows="4" cols="50" required name="message" placeholder="{{__('Please write your problem here...')}}"></textarea>
                                            <span class="help-block">
                                                                <strong></strong>
                                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <input type="submit" class="btn" value="{{__('Report a Problem')}}">
                                    </div>
                                </div>
                                <!-- login form  end-->
                            </form>
                        </div>
                    </div>
                    <!-- End Technical Support -->
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