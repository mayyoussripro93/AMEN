@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Join To Initiatives')])
    <!-- Inner Page Title end -->
    <!-- Page Title End -->
    <div class="listpgWraper">
        <div class="container">
            @include('flash::message')
            <div class="row center-content">
                <div class="col-md-8 col-sm-10 col-xs-12">
                    <div class="userccount"> {!! Form::open(array('method' => 'post', 'route' => ['join.initiatives.post',$job->id ])) !!}
                        <div class="formpanel">
                            <!-- Ad Information -->
                            <h5 class="green-color am-title"><i class="fa fa-reply"
                                                                aria-hidden="true"></i> {{__('Join To Initiatives')}}
                                : <small>           <a href="{{route('Initiatives.detail', [$job->slug])}}"
                                                       title="{{$job->title}}">{{$job->title}}</a></small></h5>
                            <div class="row">
                                <div class="formrow">
                                    {!! Form::hidden('job_id',$job, array('class'=>'form-control', 'id'=>'job_id')) !!}
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <div class="formrow{{ $errors->has('your_name') ? ' has-error' : '' }}">
                                        <?php
                                        $your_name = (Auth::check()) ? Auth::user()->name : '';
                                        ?>
                                        <label class="am-label"><span class="red-color">*</span> {{__('Name')}}:</label>
                                        {!! Form::text('your_name', null, array('class'=>'form-control', 'id'=>'your_name', 'placeholder'=>__('Your Name'), 'required'=>'required')) !!}
                                        <span class="help-block"> <strong>{{ $errors->first('your_name') }}</strong> </span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <?php
                                        $your_email = (Auth::check()) ? Auth::user()->email : '';
                                        ?>
                                        <label class="am-label"><span class="red-color">*</span> {{__('Email')}}:</label>
                                        {!! Form::text('email', null, array('class'=>'form-control', 'id'=>'email', 'placeholder'=>__('Your Email'), 'required'=>'required')) !!}
                                        <span class="help-block"> <strong>{{ $errors->first('email') }}</strong> </span>
                                    </div>
                                </div>
                                {!! Form::hidden("Jop_id_2", $job->id) !!}
                                <div class="col-md-12 col-xs-12">
                                    <div class="formrow{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <?php
                                        $your_phone = (Auth::check()) ? Auth::user()->phone : '';
                                        ?>
                                        <label class="am-label"><span class="red-color">*</span> {{__('Phone')}}:</label>
                                        {!! Form::text('phone', null, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>__('Your Phone'), 'required'=>'required')) !!}
                                        <span class="help-block"> <strong>{{ $errors->first('phone') }}</strong> </span>
                                    </div>
                                </div>
                                {{--                            <div class="col-md-12">--}}
                                {{--                                <div class="formrow{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">--}}
                                {{--                                    {!! app('captcha')->display() !!}--}}
                                {{--                                    @if ($errors->has('g-recaptcha-response')) <span class="help-block"> <strong>{{ $errors->first('g-recaptcha-response') }}</strong> </span> @endif--}}
                                {{--                                </div>--}}
                                {{--                            </div>--}}

                                <div class="col-md-12 col-xs-12">
                                <input type="submit" id="post_ad_btn" class="btn" value="{{__('Join Now')}}">
                                </div>
                            </div>

                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection