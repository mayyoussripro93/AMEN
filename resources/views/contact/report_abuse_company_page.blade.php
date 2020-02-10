@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Report a Problem')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="userccount">
                                {!! Form::open(array('method' => 'post', 'route' => ['report.abuse.company'])) !!}
                                @csrf
                                <div class="formpanel">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <h5 class="green-color am-title"><i class="fa fa-wrench"
                                                                                aria-hidden="true"></i> {{__('Report a Problem')}}
                                            </h5>
                                        </div>
                                    </div>
                                    <!-- Ad Information -->
                                    <div class="row page-sec">
                                        <div class="col-md-10 col-xs-12" style="float: none !important; margin: 0 auto;">
                                            <div class="formrow{{ $errors->has('listing_url') ? ' has-error' : '' }}">
                                                {!! Form::textarea('company_url', null, array('class'=>'form-control', 'id'=>'company_url', 'placeholder'=>__('Please write your problem here...'), 'required'=>'required')) !!}
                                                <span class="help-block"> <strong>{{ $errors->first('company_url') }}</strong> </span>
                                            </div>
                                        </div>
{{--                                        <div class="col-md-8 col-md-offset-2">--}}
{{--                                            <div class="formrow{{ $errors->has('your_name') ? ' has-error' : '' }}">--}}
{{--                                                @php  $your_name = (Auth::guard('employee')->check()) ? Auth::guard('employee')->user()->name : '';@endphp--}}
{{--                                                {!! Form::text('your_name', $your_name, array('class'=>'form-control', 'id'=>'your_name', 'placeholder'=>__('Your Name'), 'required'=>'required')) !!}--}}
{{--                                                <span class="help-block"> <strong>{{ $errors->first('your_name') }}</strong> </span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-8 col-md-offset-2">--}}
{{--                                            <div class="formrow{{ $errors->has('your_email') ? ' has-error' : '' }}">--}}
{{--                                                @php $your_email = (Auth::guard('employee')->check()) ? Auth::guard('employee')->user()->email : '';@endphp--}}
{{--                                                {!! Form::text('your_email', $your_email, array('class'=>'form-control', 'id'=>'your_email', 'placeholder'=>__('Your Email'), 'required'=>'required')) !!}--}}
{{--                                                <span class="help-block"> <strong>{{ $errors->first('your_email') }}</strong> </span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="col-md-10 col-xs-12" style="float: none !important; margin: 0 auto;">
                                            <div class="col-md-4 pull-left" style="padding: 0;">
                                                <input type="submit" id="post_ad_btn" class="btn"
                                                       value="{{__('Submit')}}">
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
    </div>

    @include('includes.footer')
@endsection