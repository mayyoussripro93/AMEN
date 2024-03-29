@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Job Detail')])
    <!-- Inner Page Title end -->
    @php
        $company = $job->getEmployee();
    @endphp
    <div class="listpgWraper">
        <div class="container">
        @include('flash::message')


        <!-- Job Detail start -->
            <div class="row">
                <div class="col-md-8">

                    <!-- Job Header start -->
                    <div class="job-header">

                        <div class="jobinfo">

                            <div class="companylogo">
                                <?php $project = \App\Project::where('id', $job->project_id)->first();
                                ?>
                                <div class="jobimg thumbimg">{{$project->printProjectImage()}}</div>
                            </div>
                            <h6 class="green-color am-sub-title">{{$job->title}} - {{$company->name}}</h6>
                            <div class="salary">{{$project->name}}</div>
                            <div class="ptext">{{__('Date Posted')}}: {{$job->created_at->format('M d, Y')}}</div>
                            @if(!(bool)$job->hide_salary)
                                <div class="salary">{{__('Monthly Salary')}}:
                                    <strong>{{$job->salary_from.' '.$job->salary_currency}}
                                        - {{$job->salary_to.' '.$job->salary_currency}}</strong></div>
                            @endif

                        </div>
                        <div class="jobButtons">

                            @if($job->isJobExpired())
                                <span class="jbexpire"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{__('Job is expired')}}</span>
                                {{--                @elseif(Auth::check() && Auth::user()->isAppliedOnJob($job->id))--}}
                                {{--                <a href="javascript:;" class="btn apply"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{__('Already Applied')}}</a>--}}
                                {{--                @else--}}
                                {{--                <a href="{{route('apply.job', $job->slug)}}" class="btn apply"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{__('Apply Now')}}</a>--}}
                            @endif


                            {{--                <a href="{{route('email.to.friend', $job->slug)}}" class="btn"><i class="fa fa-envelope" aria-hidden="true"></i> {{__('Email to Friend')}}</a>--}}
                            {{--                @if(Auth::check() && Auth::user()->isFavouriteJob($job->slug)) <a href="{{route('remove.from.favourite', $job->slug)}}" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Favourite Job')}} </a> @else <a href="{{route('add.to.favourite', $job->slug)}}" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Add to Favourite')}}</a> @endif--}}
                            {{--                <a href="{{route('report.abuse', $job->slug)}}" class="btn btn-danger white-color"><i class="fa fa-wrench" aria-hidden="true"></i> {{__('Report a Problem')}}</a>--}}
                        </div>
                    </div>


                    <!-- Job Description start -->
                    <div class="job-header">
                        <div class="contentbox">
                            <h6 class="green-color am-sub-title">{{__('Job Description')}}</h6>
                            <p>{!! $job->description !!}</p>

                            <hr>
                            <h6 class="green-color am-sub-title">{{__('Skills Required')}}</h6>
                            <ul class="skillslist">
                                {!!$job->getJobSkillsList()!!}
                            </ul>
                        </div>
                    </div>
                    <!-- Job Description end -->

                    <!-- related jobs start -->
                    <div class="relatedJobs">
                        <h6>{{__('Related Jobs')}}</h6>
                        <ul class="searchList">
                        @if(isset($relatedJobs) && count($relatedJobs))
                            @foreach($relatedJobs as $relatedJob)
                                <?php $relatedJobCompany = $relatedJob->getEmployee(); ?>

                                @if(null !== $relatedJobCompany)
                                    <!--Job start-->
                                        <li>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8">
                                                    <?php $project = \App\Project::where('id', $relatedJob->project_id)->first();
                                                    ?>
                                                    <div class="jobimg thumbimg"><a href="" title="{{$relatedJob->title}}">
                                                            {{$project->printProjectImage()}}
                                                        </a></div>
                                                    <div class="jobinfo">
                                                        <h3><a href="{{route('job.detail', [$relatedJob->slug])}}"
                                                               title="{{$relatedJob->title}}">{{$relatedJob->title}}</a>
                                                        </h3>
                                                        <div class="companyName"><a href=""
                                                                                    title="{{$project->name}}">{{$project->name}}</a>
                                                        </div>
                                                        <div class="location">
                                                            <span>{{$relatedJob->getState('state')}}</span> -
                                                            <span>{{$relatedJob->getCity('city')}}</span></div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="listbtn"><a
                                                                href="{{route('job.detail', [$relatedJob->slug])}}">{{__('View Detail')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>{{str_limit(strip_tags($relatedJob->description), 150, '...')}}</p>
                                        </li>
                                        <!--Job end-->
                                @endif
                            @endforeach
                        @endif

                        <!-- Job end -->
                        </ul>
                    </div>
                </div>
                <!-- related jobs end -->

                <div class="col-md-4">
                    <div class="job-header">
                        <div class="companyinfo">
                            <div class="companylogo">{{$company->printCompanyImage()}}</div>
                            <div class="title"><strong class="green-color">{{$company->name}}</strong></div>
                            <div class="ptext">{{$company->getLocation()}}</div>
                            <div class="opening">
                                @if ($company->employee_role_id==1)
                                    <div class="listbtn green-color">{{__('Civil Defense Department')}}</div>

                                @elseif($company->employee_role_id==2)
                                    <div class="listbtn green-color">{{__('Civil defense personnel')}}</div>
                                @elseif($company->employee_role_id==3)
                                    <div class="listbtn green-color">{{__('Safety_consultant')}}</div>
                                @elseif($company->employee_role_id==4)
                                    <div class="listbtn green-color">{{__('Project_consultant')}}</div>
                                @elseif($company->employee_role_id==5)
                                    <div class="listbtn green-color">{{__('Contractor')}}</div>


                                @endif
                                {{--                                <a href="{{route('company.detail',$company->slug)}}">--}}
                                {{--                                    {{App\Company::countNumJobs('company_id', $company->id)}} {{__('Current Jobs Openings')}}--}}
                                {{--                                </a>--}}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <!-- Job Detail start -->
                    <div class="job-header">
                        <div class="jobdetail">
                            <h6 class="green-color">{{__('Initiative Details')}}</h6>
                            <ul class="jbdetail">
                                <li class="row">
                                    <div class="col-md-4 col-xs-5">{{__('Location')}}</div>
                                    <div class="col-md-8 col-xs-7">
                                        @if((bool)$job->is_freelance)
                                            <span>Freelance</span>
                                        @else
                                            <span>{{$job->getLocation()}}</span>
                                        @endif
                                    </div>
                                </li>
                                <li class="row">
                                    <div class="col-md-4 col-xs-5">{{__('Project')}}</div>
                                    <?php $project = \App\Project::where('id', $job->project_id)->first();
                                    ?>
                                    <div class="col-md-8 col-xs-7"><span class="permanent">{{$project->name}}</span>
                                    </div>
                                </li>
                                {{--                            <li class="row">--}}
                                {{--                                <div class="col-md-4 col-xs-5">{{__('Type')}}</div>--}}
                                {{--                                <div class="col-md-8 col-xs-7"><span class="permanent">{{$job->getJobType('job_type')}}</span></div>--}}
                                {{--                            </li>--}}
                                {{--                            <li class="row">--}}
                                {{--                                <div class="col-md-4 col-xs-5">{{__('Shift')}}</div>--}}
                                {{--                                <div class="col-md-8 col-xs-7"><span class="freelance">{{$job->getJobShift('job_shift')}}</span></div>--}}
                                {{--                            </li>--}}
                                {{--                            <li class="row">--}}
                                {{--                                <div class="col-md-4 col-xs-5">{{__('Career Level')}}</div>--}}
                                {{--                                <div class="col-md-8 col-xs-7"><span>{{$job->getCareerLevel('career_level')}}</span></div>--}}
                                {{--                            </li>--}}
                                {{--                            <li class="row">--}}
                                {{--                                <div class="col-md-4 col-xs-5">{{__('Positions')}}</div>--}}
                                {{--                                <div class="col-md-8 col-xs-7"><span>{{$job->num_of_positions}}</span></div>--}}
                                {{--                            </li>--}}
                                <li class="row">
                                    <div class="col-md-4 col-xs-5">{{__('Experience')}}</div>
                                    <div class="col-md-8 col-xs-7">
                                        <span class="permanent">{{$job->getJobExperience('job_experience')}}</span></div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6 col-xs-6">{{__('Salary from (SAR)')}}</div>
                                    <div class="col-md-6 col-xs-6"><span class="permanent">{{$job->salary_from}}</span></div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6 col-xs-6">{{__('Salary to (SAR)')}}</div>
                                    <div class="col-md-6 col-xs-6"><span class="permanent">{{$job->salary_to}}</span></div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6 col-xs-6">{{__('Functional Area')}}</div>
                                    <div class="col-md-6 col-xs-6">
                                        <span class="permanent">{{$job->getFunctionalArea('functional_area')}}</span></div>
                                </li>
                                {{--                            <li class="row">--}}
                                {{--                                <div class="col-md-4 col-xs-5">{{__('Gender')}}</div>--}}
                                {{--                                <div class="col-md-8 col-xs-7"><span>{{$job->getGender('gender')}}</span></div>--}}
                                {{--                            </li>--}}
                                <li class="row">
                                    <div class="col-md-6 col-xs-6">{{__('Degree')}}</div>
                                    <div class="col-md-6 col-xs-6"><span class="permanent">{{$job->getDegreeLevel('degree_level')}}</span>
                                    </div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6 col-xs-6">{{__('Apply Before')}}</div>
                                    <div class="col-md-6 col-xs-6"><span class="permanent">
                                        {{\Arabic\Arabic::adate(' j F Y ', strtotime($job->expiry_date))}}</span></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Google Map start -->
{{--                    <div class="job-header">--}}
{{--                        <div class="jobdetail">--}}
{{--                            <h3>{{__('Google Map')}}</h3>--}}
{{--                            <div class="gmap">--}}
{{--                                {!!$company->map!!}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
@push('styles')
    <style type="text/css">
        .view_more {
            display: none !important;
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
                if ($(this).height() > 100) {
                    $(this).css('height', 100);
                    $(this).css('overflow', 'hidden');
                    //alert($( this ).next());
                    $(this).next().removeClass('view_more');
                }
            });


        });
    </script>
@endpush