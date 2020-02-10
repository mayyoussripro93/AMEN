@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end -->
<!-- Inner Page Title start -->


    @include('includes.inner_page_title', ['page_title'=>__('Recruiting')])


<!-- Inner Page Title end -->
<div class="listpgWraper">
    <style>
        .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {background-color: #ddd;}

        .dropdown:hover .dropdown-content {display: block;}

        .dropdown:hover .dropbtn {background-color: #3e8e41;}
    </style>
    <div class="container">
        @include('flash::message')
        <form action="{{route('job.list')}}" method="get">
            <!-- Page Title start -->
            <div class="pageSearch">
                <div class="row">

{{--                        @if(Auth::guard('company')->check())--}}
{{--                        <a href="{{ route('post.job') }}" class="btn"><i class="fa fa-file-text" aria-hidden="true"></i> {{__('Post Job')}}</a>--}}
{{--                        @else--}}
                        @if(Auth::guard('employee')->check())
                            <div class="col-md-3">

                                    <a href="{{url('/jobs')}}" class="btn"><i class="fa fa-black-tie"
                                                                  aria-hidden="true"></i> {{__('Recruiting')}}</a>

                            </div>
                            @else
                        <div class="col-md-3">
                            <div class="dropdown" style="width: 100%;">

                                    <button class="dropbtn btn-block" >{{__('Recruiting')}} <i class="fa fa-caret-down"></i></button>

                                <div class="dropdown-content">
                                    <a href="{{url('/initiatives')."?Initiatives_type=Learning"}}"><i
                                                class="fa fa-graduation-cap"
                                                aria-hidden="true"></i> {{__('Learning')}}</a>

                                    <a href="{{url('/initiatives')."?Initiatives_type=Training"}}"><i
                                                class="fa fa-cogs" aria-hidden="true"></i> {{__('Training')}}</a>

                                    <a href="{{url('/jobs')}}"><i class="fa fa-black-tie"
                                                                  aria-hidden="true"></i> {{__('Recruiting')}}</a>
                                </div>
                            </div>
                        </div>
                        @endif


                    <div class="col-md-9">
                        <div class="searchform">
                            <div class="row">
{{--                                <div class="col-md-{{((bool)$siteSetting->country_specific_site)? 5:3}}">--}}
                                <div class="col-md-4">
                                    <input type="text" name="search" value="{{Request::get('search', '')}}" class="form-control" placeholder="{{__('Skills or job title')}}" style="height: 55px;"/>
                                </div>
                                <div class="col-md-3"> {!! Form::select('functional_area_id[]', ['' => __('Functional Area')]+$functionalAreas, Request::get('functional_area_id', null), array('class'=>'form-control', 'id'=>'functional_area_id')) !!} </div>


                                @if((bool)$siteSetting->country_specific_site)
                                {!! Form::hidden('country_id[]', Request::get('country_id[]', $siteSetting->default_country_id), array('id'=>'country_id')) !!}
                                @else
                                <div class="col-md-2" style="display: none;">
                                    {!! Form::select('country_id[]', ['' => __('Select Country')]+$countries, Request::get('country_id', $siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}
                                </div>
                                @endif

                                <div class="col-md-2">
                                    <span id="state_dd">
                                        {!! Form::select('state_id[]', ['' => __('Select State')], Request::get('state_id', null), array('class'=>'form-control', 'id'=>'state_id')) !!}
                                    </span>
                                </div>
                                <div class="col-md-2">
                                    <span id="city_dd">
                                        {!! Form::select('city_id[]', ['' => __('Select City')], Request::get('city_id', null), array('class'=>'form-control', 'id'=>'city_id')) !!}
                                    </span>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn" style="height: 55px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page Title end -->
        </form>
        <form action="{{route('job.list')}}" method="get">
            <!-- Search Result and sidebar start -->
            <div class="row"> @include('includes.job_list_side_bar')
{{--                <div class="col-md-3 col-sm-6 pull-right">--}}
{{--                    <!-- Sponsord By -->--}}
{{--                    <div class="sidebar">--}}
{{--                        <h4 class="widget-title">{{__('Sponsord By')}}</h4>--}}
{{--                        <div class="gad">{!! $siteSetting->listing_page_vertical_ad !!}</div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-9 col-sm-12">
                    <div class="userccount">
                    <!-- Search List -->
                    <ul class="searchList">
                        <!-- job start -->
                        @if(isset($jobs) && count($jobs))
                        @foreach($jobs as $job)
                        @php $company = $job->getEmployee(); @endphp
                        @if(null !== $company)
                        <li>
                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                                    <div class="jobimg">
                                        <?php
                                         $job1=\App\Job::where('id',$job->id)->first();
                                        $project= \App\Project::where('id',$job1->project_id)->first();

                                        ?>
                                            @if( !empty($job1->logo))
                                                <div class="jobimg thumbimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>
                                            @else

                                                {{$project->printProjectImage()}}
                                            @endif

                                    </div>
                                    <div class="jobinfo">
                                        <h3><a href="{{route('job.detail', [$job->slug])}}" title="{{$job->title}}">{{$job->title}}</a></h3>
                                        <div class="companyName"><a href="" title="{{$project->name}}">{{$project->name}}</a></div>
                                        <div class="location">
                                            <span>{{$job->getState('state')}}</span>
                                            - <span>{{$job->getCity('city')}}</span></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="listbtn"><a href="{{route('job.detail', [$job->slug])}}">{{__('View Details')}}</a></div>
                                </div>
                            </div>
                            <p>{{str_limit(strip_tags($job->description), 150, '...')}}</p>
                        </li>
                        <!-- job end -->
                        @endif
                        @endforeach
                        @endif
                    </ul>

                    <!-- Pagination Start -->
                    <div class="pagiWrap">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="showreslt">
                                    {{__('Showing Pages')}} : {{ $jobs->firstItem() }} - {{ $jobs->lastItem() }} {{__('Total')}} {{ $jobs->total() }}
                                </div>
                            </div>
                            <div class="col-md-7 text-right">
                                @if(isset($jobs) && count($jobs))
                                {{ $jobs->appends(request()->query())->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Pagination end -->
{{--                    <div class=""><br />{!! $siteSetting->listing_page_horizontal_ad !!}</div>--}}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@include('includes.footer')
@endsection
@push('styles')
<style type="text/css">
    .searchList li .jobimg {
        min-height: 80px;
    }
    .hide_vm_ul{
        height:90px;
        overflow:hidden;
    }
    .hide_vm{
        display:none !important;
    }
    .view_more{
        cursor:pointer;
    }
</style>
@endpush
@push('scripts')
<script>
    $(document).ready(function ($) {
        $("form").submit(function () {
            $(this).find(":input").filter(function () {
                return !this.value;
            }).attr("disabled", "disabled");
            return true;
        });
        $("form").find(":input").prop("disabled", false);

        $(".view_more_ul").each(function () {
            if ($(this).height() > 100)
            {
                $(this).addClass('hide_vm_ul');
                $(this).next().removeClass('hide_vm');
            }
        });
        $('.view_more').on('click', function (e) {
            e.preventDefault();
            $(this).prev().removeClass('hide_vm_ul');
            $(this).addClass('hide_vm');
        });

    });
</script>
@include('includes.country_state_city_js')
@endpush