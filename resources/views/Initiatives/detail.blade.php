@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Initiatives Detail')])
    <!-- Inner Page Title end -->
    @php
        $company = $job->getEmployee();
    @endphp
    <div class="listpgWraper">
        <div class="container">
        @include('flash::message')


        <!-- Job Detail start -->
            <div class="row">
                <div class="col-md-8 col-sm-8">

                    <!-- Job Header start -->
                    <div class="job-header">
                        <div class="jobinfo">
                            <div class="companylogo">
                                @if( !empty($job->logo))
                                    <div class="jobimg thumbimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>
                                @else
                                    <div class="jobimg thumbimg"><img src="{{ asset('/') }}admin_assets/no_image.jpg" class="thumbimg"></div>
                                @endif
                            </div>
                            <h6 class="green-color">{{$job->title}} - {{$job->company_organize_name	}}</h6>
                            {{--                        <h2>{{$job->title}} - {{$company->name}}</h2>--}}
                            <div class="ptext">{{__('Date Posted')}}:{{\Arabic\Arabic::adate(' j F Y ', strtotime($job->created_at))}}</div>
                            {{--                        @if(!(bool)$job->hide_salary)--}}
                            {{--                        <div class="salary">{{__('Monthly Salary')}}: <strong>{{$job->salary_from.' '.$job->salary_currency}} - {{$job->salary_to.' '.$job->salary_currency}}</strong></div>--}}
                            {{--                        @endif--}}

                        </div>
                        <div class="jobButtons">

                            @if($job->isJobExpired())
                                <span class="btn btn-danger" style="font-size: 12px;"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{__('Job is expired')}}</span>
                                {{--                @elseif(Auth::check() && Auth::user()->isAppliedOnJob($job->id))--}}
                                {{--                <a href="javascript:;" class="btn apply"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{__('Already Applied')}}</a>--}}
                                {{--                @else--}}
                                {{--                <a href="{{route('apply.job', $job->slug)}}" class="btn apply"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{__('Apply Now')}}</a>--}}
                            @endif


                            {{--                            <a href="{{route('email.to.friend', $job->slug)}}" class="btn"><i class="fa fa-envelope" aria-hidden="true"></i> {{__('Email to Friend')}}</a>--}}

                               @if (Auth::guard('employee')->check())
                                @if($job->company_id == Auth::guard('employee')->user()->id)
{{--                                    <div class="col-md-3 init-btns">--}}
                                      <a href="{{url('/edit-front-initiatives/'.$job->id)."?Initiatives_type=Education" }}" class="btn btn-success green-color"><i
                                                        class="fa fa-pencil"
                                                        aria-hidden="true"></i> {{__('Edit')}}
                                            </a>

                               <a href="javascript:;" onclick="deleteJob({{$job->id}});" class="btn btn-success green-color"><i class="fa fa-trash-o"
                                                        aria-hidden="true"></i> {{__('Delete')}}
                                            </a>
                                <a href="{{url('/join-initiatives-list/'.$job->id)}}" class="btn btn-success green-color"><i
                                                        class="fa fa-users"
                                                        aria-hidden="true"></i> {{__('Join Request')}}
                                            </a>

{{--                                    </div>--}}
                                @endif
                                    @else
                                    <a href="{{route('join.initiatives', $job->id)}}" class="btn btn-success green-color"><i class="fa fa-reply" aria-hidden="true"></i> {{__('Join To Initiatives')}}</a>
                                @endif


                            {{--                            @if(Auth::check() && Auth::user()->isFavouriteJob($job->slug)) <a--}}
                            {{--                                    href="{{route('remove.from.favourite', $job->slug)}}" class="btn"><i--}}
                            {{--                                        class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Favourite Job')}}--}}
                            {{--                            </a> @else <a href="{{route('add.to.favourite', $job->slug)}}" class="btn"><i--}}
                            {{--                                        class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Add to Favourite')}}--}}
                            {{--                            </a> @endif--}}
                            {{--                                                        <a href="{{route('report.abuse', $job->slug)}}" class="btn report"><i--}}
                            {{--                                                                    class="fa fa-exclamation-triangle"--}}
                            {{--                                                                    aria-hidden="true"></i> {{__('Report Abuse')}}</a>--}}
                        </div>
                    </div>


                    <!-- Job Description start -->
                    <div class="job-header">
                        <div class="contentbox">
                            <h6 class="green-color am-sub-title">{{__("required for education Initiative")}}</h6>
                            <p>{!! $job->description !!}</p>

                            {{--                        <hr>--}}
                            {{--                        <h3>{{__('Skills Required')}}</h3>--}}
                            {{--                        <ul class="skillslist">--}}
                            {{--                            {!!$job->getJobSkillsList()!!}--}}
                            {{--                        </ul>--}}
                        </div>
                    </div>
                    <!-- Job Description end -->

                    <!-- related jobs start -->
                    <div class="relatedJobs">
                        <h6>{{__('Related Initiatives')}}</h6>
                        <ul class="searchList">
                        @if(isset($relatedJobs) && count($relatedJobs))
                            @foreach($relatedJobs as $relatedJob)
                                <?php $relatedJobCompany = $relatedJob->getEmployee(); ?>
                                @if(null !== $relatedJobCompany)
                                    <!--Job start-->
                                        <li>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8">
                                                    {{--                                    <div class="jobimg"><a href="{{route('job.detail', [$relatedJob->slug])}}" title="{{$relatedJob->title}}">--}}
                                                    {{--                                            {{$relatedJobCompany->printCompanyImage()}}--}}
                                                    {{--                                        </a></div>--}}
                                                    {{--                                    <div class="jobinfo">--}}
                                                    {{--                                        <h3><a href="{{route('job.detail', [$relatedJob->slug])}}" title="{{$relatedJob->title}}">{{$relatedJob->title}}</a></h3>--}}
                                                    {{--                                        <div class="companyName"><a href="{{route('company.detail', $relatedJobCompany->slug)}}" title="{{$relatedJobCompany->name}}">{{$relatedJobCompany->name}}</a></div>--}}
                                                    {{--                                        <div class="location">--}}
                                                    {{--                                            <label class="fulltime">{{$relatedJob->getJobType('job_type')}}</label>--}}
                                                    {{--                                            <label class="partTime">{{$relatedJob->getJobShift('job_shift')}}</label>   - <span>{{$relatedJob->getCity('city')}}</span></div>--}}
                                                    {{--                                    </div>--}}
                                                    {{--                                    <div class="clearfix"></div>--}}
                                                    {{--                                </div>--}}
                                                    {{--                                <div class="col-md-4 col-sm-4">--}}
                                                    {{--                                    <div class="listbtn"><a href="{{route('job.detail', [$relatedJob->slug])}}">{{__('View Detail')}}</a></div>--}}
                                                    {{--                                </div>--}}


{{--                                                    <div class="jobimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>--}}
                                                    <div class="jobinfo">
                                                        @if( !empty($relatedJob->logo))
                                                            <div class="jobimg thumbimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>
                                                        @else
                                                            <div class="jobimg thumbimg"><img src="{{ asset('/') }}admin_assets/no_image.jpg" class="thumbimg"></div>
                                                        @endif
                                                        @if($relatedJob->Initiatives_type == 1)
                                                            <h3>
                                                                <a href="{{url('initiatives/'.$relatedJob->slug."?Initiatives_type=Learning")}}"
                                                                   title="{{$relatedJob->title}}">{{$relatedJob->title}}</a></h3>
                                                        @elseif($relatedJob->Initiatives_type == 2)
                                                            <h3>
                                                                <a href="{{url('initiatives/'.$relatedJob->slug."?Initiatives_type=Training")}}"
                                                                   title="{{$relatedJob->title}}">{{$relatedJob->title}}</a></h3>
                                                        @endif
                                                        <div class="companyName">{{$relatedJob->company_organize_name}}</div>
                                                        <div class="companyName">{{\Arabic\Arabic::adate(' j F Y ', strtotime($relatedJob->gregorian_data))}}</div>

                                                        <div class="companyName"><a
                                                                    href=""
                                                                    title="{{$relatedJob->name}}">{{$relatedJob->name}}</a>
                                                        </div>
                                                        <div class="location">
                                                            <span>{{$relatedJob->getState('state')}}</span> - <span>{{$relatedJob->getCity('city')}}</span></div>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    @if($relatedJob->Initiatives_type == 1)
                                                        <div class="listbtn"><a
                                                                    href="{{url('initiatives/'.$relatedJob->slug."?Initiatives_type=Learning")}}">{{__('View Details')}}</a>
                                                        </div>
                                                    @elseif($relatedJob->Initiatives_type == 2)
                                                        <div class="listbtn"><a
                                                                    href="{{url('initiatives/'.$relatedJob->slug."?Initiatives_type=Training")}}">{{__('View Details')}}</a>
                                                        </div>

                                                    @endif
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

                <div class="col-md-4 col-sm-4">
                    <div class="job-header">
                    <div class="companyinfo">
                        <div class="companylogo">
                            {{$company->printCompanyImage()}}
                        </div>
                        <div class="title">
                            <strong class="green-color">{{$company->name}}</strong>
                        </div>
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
                                    <div class="col-md-4 col-xs-5">{{__('Company')}}</div>
                                    <div class="col-md-8 col-xs-7"><span
                                                class="permanent">{{ $job->company_organize_name }}</span></div>
                                </li>

                                <li class="row">
                                    <div class="col-md-6 col-xs-6">{{__('The date of Initiative began')}}</div>
                                    <div class="col-md-6 col-xs-6"><span
                                                class="permanent">{{\Arabic\Arabic::adate(' j F Y ', strtotime($job->gregorian_data))}}</span>
                                    </div>
                                </li>
                                <li class="row">
                                    <div class="col-md-6 col-xs-6">{{__('The date of Initiative end')}}</div>
                                    <div class="col-md-6 col-xs-6"><span
                                                class="permanent">{{\Arabic\Arabic::adate(' j F Y ', strtotime($job->gregorian_data_to))}}</span>
                                    </div>
                                </li>
<!--                                --><?php //dd((strtotime($job->gregorian_data_to)- strtotime($job->gregorian_data))/ (60 * 60 * 24)) ?>
                                <li class="row">
                                    <div class="col-md-4 col-xs-5">{{__('Duration of Initiative')}}</div>
                                    <div class="col-md-8 col-xs-7"><span
                                                class="permanent">{{ (strtotime($job->gregorian_data_to)- strtotime($job->gregorian_data))/ (60 * 60 * 24)}} {{__('Day')}}</span></div>
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
                                {{--                            <li class="row">--}}
                                {{--                                <div class="col-md-4 col-xs-5">{{__('Experience')}}</div>--}}
                                {{--                                <div class="col-md-8 col-xs-7"><span>{{$job->getJobExperience('job_experience')}}</span></div>--}}
                                {{--                            </li>--}}
                                {{--                            <li class="row">--}}
                                {{--                                <div class="col-md-4 col-xs-5">{{__('Gender')}}</div>--}}
                                {{--                                <div class="col-md-8 col-xs-7"><span>{{$job->getGender('gender')}}</span></div>--}}
                                {{--                            </li>--}}
                                {{--                            <li class="row">--}}
                                {{--                                <div class="col-md-4 col-xs-5">{{__('Degree')}}</div>--}}
                                {{--                                <div class="col-md-8 col-xs-7"><span>{{$job->getDegreeLevel('degree_level')}}</span></div>--}}
                                {{--                            </li>--}}
                                {{--                            <li class="row">--}}
                                {{--                                <div class="col-md-4 col-xs-5">{{__('Apply Before')}}</div>--}}
                                {{--                                <div class="col-md-8 col-xs-7"><span>{{$job->expiry_date->format('M d, Y')}}</span></div>--}}
                                {{--                            </li>--}}
                            </ul>
                        </div>
                    </div>
                    <!-- Google Map start -->
                    {{--                <div class="job-header">--}}
                    {{--                    <div class="jobdetail">--}}
                    {{--                        <h3>{{__('Google Map')}}</h3>--}}
                    {{--                        <div class="gmap">--}}
                    {{--                            {!!$company->map!!}--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                </div>--}}
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
            function deleteJob(id) {
                var msg = 'Are you sure?';
                if (confirm(msg)) {
                    $.post("{{ route('delete.front.job') }}", {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                        .done(function (response) {
                            if (response == 'ok') {
                                $('#job_li_' + id).remove();
                            } else {
                                alert('Request Failed!');
                            }
                        });
                }
            }
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