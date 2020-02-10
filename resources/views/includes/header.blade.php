<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-9 navbar-brand logos">

                <div class="cdlogo"></div>
                <div class="visionlogo"></div>
                </a>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                                class="icon-bar"></span> <span class="icon-bar"></span></button>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-3 text-left logos">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-12 text-left top-date">
                        <span id="topLinks_dateid" class="date-span">
                           {{$gregoriandate}}
                            /
                        {{$higridate}}
                        </span>
{{--                        <span class="green-bg date-span">{{__('Date')}}</span>--}}
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <a href="{{url('/')}}" class="logo">
                            <img src="{{ asset('/') }}images/amen_logo.png" alt="{{ $siteSetting->site_name }}"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- row end -->
    </div>
    <div class="container-fluid">
        <div class="row green-bg">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <!-- Nav start -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-collapse collapse" id="nav-main">
                        <ul class="nav navbar-nav">
                            <li class="{{ Request::url() == route('index') ? 'active' : '' }}"><a href="{{url('/')}}">{{__('Home')}}</a></li>
                            {{--                            <li class="{{ Request::url()}}"><a href="{{url('/jobs')}}">{{__('Jobs')}}</a> </li>--}}


                            {{--                            <li class="{{ Request::url()}}"><a href="{{url('/companies')}}">{{__('Companies')}}</a></li>--}}
                            @foreach($show_in_top_menu as $top_menu) @php $cmsContent = App\CmsContent::getContentBySlug($top_menu->page_slug); @endphp
                            <li class="{{ Request::url() == route('cms', $top_menu->page_slug) ? 'active' : '' }}"><a
                                        href="{{ route('cms', $top_menu->page_slug) }}"> @php if(isset($cmsContent->page_title)) echo $cmsContent->page_title @endphp </a>
                            </li>
                            @endforeach
                            <li class="dropdown"><a>{{__('The Initiatives')}} <span
                                            class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('/initiatives')."?Initiatives_type=Learning"}}"><i
                                                    class="fa fa-graduation-cap"
                                                    aria-hidden="true"></i> {{__('Learning')}}</a></li>
                                    <li><a href="{{url('/initiatives')."?Initiatives_type=Training"}}"><i
                                                    class="fa fa-cogs" aria-hidden="true"></i> {{__('Training')}}</a>
                                    </li>
{{--                                    <li><a href="{{url('/jobs')}}"><i class="fa fa-black-tie"--}}
{{--                                                                      aria-hidden="true"></i> {{__('Recruiting')}}</a>--}}
{{--                                    </li>--}}
                                </ul>
                            </li>
                            <li class=""><a href="{{route('images.gallery')}}">{{__('Images Gallery')}}</a></li>
{{--                            <li class="{{ Request::url() == route('contact.us') ? 'active' : '' }}"><a--}}
{{--                                        href="{{ route('contact.us') }}">{{__('Contact us')}}</a></li>--}}
                            @if(Auth::guard('employee')->check())

                                <li class="dropdown userbtn">
                                    <a href="{{route('home')}}" title="{{__('Dashboard')}}">
                                        {{Auth::guard('employee')->user()->printUserImage()}}
                                        <span class="green-color">{{Auth::guard('employee')->user()->name}}</span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('home')}}"><i class="fa fa-tachometer"
                                                                           aria-hidden="true"></i> {{__('Dashboard')}}
                                            </a></li>
                                        <li><a href="{{ route('employee.show',['id'=>Crypt::encryptString(Auth::guard('employee')->user()->id)]) }}"><i class="fa fa-user" aria-hidden="true"></i> {{__('My Profile')}}</a></li>
                                        {{--<li><a href="{{ route('view.public.profile', Auth::guard('employee')->user()->id) }}"><i class="fa fa-eye" aria-hidden="true"></i> {{__('View Public Profile')}}</a> </li>--}}
                                        {{--<li><a href="{{ route('my.job.applications') }}"><i class="fa fa-desktop" aria-hidden="true"></i> {{__('My Job Applications')}}</a> </li>--}}
                                        <li><a href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();"><i
                                                        class="fa fa-sign-out" aria-hidden="true"></i> {{__('Logout')}}
                                            </a></li>
                                        <form id="logout-form-header" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </ul>
                                </li>
                            @endif

                            @if(!Auth::guard('employee')->user())
                                <li class="postjob dropdown"><a href="{{route('login')}}">{{__('Sign in')}} <span
                                                class="caret"></span></a>

                                    <!-- dropdown start -->

                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('login')}}"><i class="fa fa-sign-in"
                                                                            aria-hidden="true"></i> {{__('Sign in')}}
                                            </a></li>
                                        {{--                                    <li><a href="\employee/login">{{__('Sign in')}}</a></li>--}}
                                        <li><a href="{{route('register')}}"><i class="fa fa-user-plus"
                                                                               aria-hidden="true"></i> {{__('Register')}}
                                            </a></li>
                                        {{--                                    <li><a href="\employee/register">{{__('Register')}}</a> </li>--}}
                                    </ul>

                                    <!-- dropdown end -->

                                </li>
                            @endif



                            {{--<li class="dropdown userbtn"><a href="{{url('/')}}"><img src="{{asset('/')}}images/lang.png" alt="" class="userimg" /></a>--}}
                            {{--<ul class="dropdown-menu">--}}
                            {{--@foreach($siteLanguages as $siteLang)--}}
                            {{--<li><a href="javascript:;" onclick="event.preventDefault(); document.getElementById('locale-form-{{$siteLang->iso_code}}').submit();">{{$siteLang->native}}</a>--}}
                            {{--<form id="locale-form-{{$siteLang->iso_code}}" action="{{ route('set.locale') }}" method="POST" style="display: none;">--}}
                            {{--{{ csrf_field() }}--}}
                            {{--<input type="hidden" name="locale" value="{{$siteLang->iso_code}}"/>--}}
                            {{--<input type="hidden" name="return_url" value="{{url()->full()}}"/>--}}
                            {{--<input type="hidden" name="is_rtl" value="{{$siteLang->is_rtl}}"/>--}}
                            {{--</form>--}}
                            {{--</li>--}}
                            {{--@endforeach--}}
                            {{--</ul>--}}
                            {{--</li>--}}
                        </ul>

                        <!-- Nav collapes end -->

                    </div>
                    <div class="clearfix"></div>
                </div>

                <!-- Nav end -->

            </div>
        </div>
    </div>
    <!-- Header container end -->
</div>
