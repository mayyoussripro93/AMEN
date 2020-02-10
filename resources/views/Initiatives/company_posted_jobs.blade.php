@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Amen Initiatives')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    @include('flash::message')

                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="userccount">
                                <div class="formpanel">
                                    @if(urldecode($_GET['Initiatives_type']) == 'Education')
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <h5 class="green-color am-title"><i class="fa fa-graduation-cap"
                                                                                    aria-hidden="true"></i> {{__('Amen Initiatives for Education')}}
                                                </h5>
                                            </div>
                                        </div>
                                        <ul class="searchList">
                                            <!-- job start -->
                                            @if(count($jobs_1)!=0)
                                                @if(isset($jobs_1) && count($jobs_1))
                                                    @if(count($jobs_1)>0)
                                                        @foreach($jobs_1 as $job)
                                                            @if($job->Initiatives_type == 1)
                                                                @php $company = $job->getEmployee(); @endphp

                                                                <li id="job_li_{{$job->id}}">
                                                                    <div class="row">
                                                                        <div class="col-md-9 col-sm-9 col-xs-9">
                                                                            <div class="jobimg">

                                                                                @if( !empty($job->logo))
                                                                                    {{--                <img src="{{ asset('/') }}company_logos/{!! $job->logo !!}" class="thumbimg">--}}
                                                                                    <div class="jobimg thumbimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>
                                                                                @else
                                                                                    <div class="jobimg thumbimg"><img
                                                                                                src="{{ asset('/') }}admin_assets/no_image.jpg"
                                                                                                class="thumbimg"></div>
                                                                                @endif
                                                                            </div>

                                                                            <div class="jobinfo">
                                                                                <h3>
                                                                                    <a href="{{route('Initiatives.detail', [$job->slug])}}"
                                                                                       title="{{$job->title}}">{{$job->title}}</a>
                                                                                    @if($job->isJobExpired())
                                                                                        <small class="expired">{{__('Job is expired')}}</small>
                                                                                    @endif
                                                                                </h3>


                                                                                <div class="companyName">
                                                                                    <strong>{{$job->company_organize_name}}</strong>
                                                                                    <small>({{\Arabic\Arabic::adate(' j F Y', strtotime($job->gregorian_data))}}
                                                                                        )</small>
                                                                                </div>
                                                                                <div class="companyName">
                                                                                    <a href=""
                                                                                       title="{{$company->name}}">{{$company->name}}</a>
                                                                                </div>
                                                                                <div class="location">
                                                                                    {{--                                                                            <label class="fulltime"--}}
                                                                                    {{--                                                                                   title="{{$job->getJobShift('job_shift')}}">{{$job->getJobShift('job_shift')}}</label>--}}
                                                                                    <span>{{$job->getState('state')}}</span>
                                                                                    -
                                                                                    <span>{{ $job->getCity('city')}}</span>
                                                                                </div>
                                                                                {{--                                                                        <p>{{str_limit(strip_tags($job->description), 150, '...')}}</p>--}}
                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="col-md-3 col-xs-3 init-btns">
                                                                            <div class="listbtn"><a
                                                                                        href="{{url('/edit-front-initiatives/'.$job->id)."?Initiatives_type=Education" }}"><i
                                                                                            class="fa fa-pencil"
                                                                                            aria-hidden="true"></i> {{__('Edit')}}
                                                                                </a>
                                                                            </div>
                                                                            <div class="listbtn"><a href="javascript:;"
                                                                                                    onclick="deleteJob({{$job->id}});"><i
                                                                                            class="fa fa-trash-o"
                                                                                            aria-hidden="true"></i> {{__('Delete')}}
                                                                                </a>
                                                                            </div>
                                                                            <div class="listbtn"><a
                                                                                        href="{{url('/join-initiatives-list/'.$job->id."?Initiatives_type=Education" )}}"><i
                                                                                            class="fa fa-users"
                                                                                            aria-hidden="true"></i> {{__('Join Request')}}
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <!-- job end -->

                                                            @endif
                                                        @endforeach
                                                    @else

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="page-sec">
                                                                <div class="formpanel text-center">
                                                                    <h2>{{__('No Results!!')}}</h2>
                                                                    <p>{{__('There are no Education Initiative.')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    @endif

                                                @endif
                                            @else

                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="page-sec">
                                                        <div class="formpanel text-center">
                                                            <h2>{{__('No Results!!')}}</h2>
                                                            <p>{{__('There are no Education Initiative.')}}</p>
                                                        </div>
                                                    </div>
                                                </div>


                                            @endif
                                        </ul>
                                        <!-- Pagination Start -->
                                        <div class="pagiWrap">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="showreslt">
                                                        {{__('Showing Pages')}} : {{ $jobs_1->firstItem() }}
                                                        - {{ $jobs_1->lastItem() }} {{__('Total')}} {{ $jobs_1->total() }}
                                                    </div>
                                                </div>
                                                <div class="col-md-7 text-right">
                                                    @if(isset($jobs_1) && count($jobs_1))
                                                        {{ $jobs_1->appends(request()->query())->links() }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Pagination end -->
                                    @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="green-color am-title"><i class="fa fa-cogs"
                                                                                    aria-hidden="true"></i> {{__('Amen Initiatives for Training')}}
                                                </h5>
                                            </div>
                                        </div>
                                        <ul class="searchList">
                                            @if(count($jobs_2)!=0)
                                                @if(isset($jobs_2) && count($jobs_2))
                                                    @if(count($jobs_2)>0)
                                                        @foreach($jobs_2 as $job)
                                                            @if($job->Initiatives_type == 2)
                                                                @php $company = $job->getEmployee(); @endphp
                                                                @if(null !== $company)
                                                                    <li id="job_li_{{$job->id}}">
                                                                        <div class="row">
                                                                            <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                <div class="jobimg">

                                                                                    @if( !empty($job->logo))
                                                                                        <div class="jobimg thumbimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>
                                                                                    @else
                                                                                        <div class="jobimg thumbimg">
                                                                                            <img src="{{ asset('/') }}admin_assets/no_image.jpg"
                                                                                                 class="thumbimg"></div>
                                                                                    @endif

                                                                                </div>

                                                                                <div class="jobinfo">
                                                                                    <h3>
                                                                                        <a href="{{route('Initiatives.detail', [$job->slug])}}"
                                                                                           title="{{$job->title}}">{{$job->title}}</a>
                                                                                        @if($job->isJobExpired())
                                                                                            <small class="expired">{{__('Job is expired')}}</small>
                                                                                        @endif
                                                                                    </h3>
                                                                                    <div class="companyName">
                                                                                        <strong>{{$job->company_organize_name}}</strong>
                                                                                        <small>({{\Arabic\Arabic::adate(' j F Y', strtotime($job->gregorian_data))}}
                                                                                            )</small>
                                                                                    </div>
                                                                                    <div class="companyName"><a
                                                                                                href=""
                                                                                                title="{{$company->name}}">{{$company->name}}</a>
                                                                                    </div>
                                                                                    <div class="location">
                                                                                        {{--                                                                                    <label class="fulltime"--}}
                                                                                        {{--                                                                                           title="{{$job->getJobShift('job_shift')}}">{{$job->getJobShift('job_shift')}}</label>--}}
                                                                                        <span>{{$job->getState('state')}}</span>
                                                                                        -
                                                                                        <span>{{ $job->getCity('city')}}</span>

                                                                                    </div>
                                                                                    {{--                                                                            <p>{{str_limit(strip_tags($job->description), 150, '...')}}</p>--}}
                                                                                </div>
                                                                                <div class="clearfix"></div>
                                                                            </div>
                                                                            <div class="col-md-3 col-xs-3 init-btns">
                                                                                {{--                                                            <div class="listbtn"><a href="{{route('list.favourite.applied.users', [$job->id])}}">{{__('List Short Listed Candidates')}}</a></div>--}}
                                                                                {{--                                                            <div class="listbtn"><a href="{{route('list.applied.users', [$job->id])}}">{{__('List Candidates')}}</a></div>--}}
                                                                                <div class="listbtn"><a
                                                                                            href="{{url('/edit-front-initiatives/'.$job->id)."?Initiatives_type=Training" }}"><i
                                                                                                class="fa fa-pencil"
                                                                                                aria-hidden="true"></i> {{__('Edit')}}
                                                                                    </a>
                                                                                </div>
                                                                                <div class="listbtn"><a
                                                                                            href="javascript:;"
                                                                                            onclick="deleteJob({{$job->id}});"><i
                                                                                                class="fa fa-trash-o"
                                                                                                aria-hidden="true"></i> {{__('Delete')}}
                                                                                    </a>
                                                                                </div>
                                                                                <div class="listbtn"><a
                                                                                            href="{{url('/join-initiatives-list/'.$job->id."?Initiatives_type=Training")}}"><i
                                                                                                class="fa fa-users"
                                                                                                aria-hidden="true"></i> {{__('Join Request')}}
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endif    <!-- job end -->
                                                            @endif
                                                        @endforeach
                                                    @else

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="page-sec">
                                                                <div class="formpanel text-center">
                                                                    <h2>{{__('No Results!!')}}</h2>
                                                                    <p>{{__('There are no Training Initiative.')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    @endif
                                                @endif
                                            @else

                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="page-sec">
                                                        <div class="formpanel text-center">
                                                            <h2>{{__('No Results!!')}}</h2>
                                                            <p>{{__('There are no Training Initiative.')}}</p>
                                                        </div>
                                                    </div>
                                                </div>


                                            @endif
                                        </ul>

                                        <!-- Pagination Start -->
                                        <div class="pagiWrap">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="showreslt">
                                                        {{__('Showing Pages')}} : {{ $jobs_2->firstItem() }}
                                                        - {{ $jobs_2->lastItem() }} {{__('Total')}} {{ $jobs_2->total() }}
                                                    </div>
                                                </div>
                                                <div class="col-md-7 text-right">
                                                    @if(isset($jobs_2) && count($jobs_2))
                                                        {{$jobs_2->appends(request()->query())->links() }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Pagination end -->
                                    @elseif(urldecode($_GET['Initiatives_type']) == 'Recruiting')
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <h5 class="green-color am-title"><i class="fa fa-black-tie"
                                                                                    aria-hidden="true"></i> {{__('Amen Initiatives for Recruiting')}}
                                                </h5>
                                            </div>
                                        </div>
                                        <ul class="searchList">

                                            @if(count($jobs_0)!=0)
                                                @foreach($jobs_0 as $job)

                                                    @if($job->Initiatives_type == 0)
                                                        @php $company = $job->getEmployee(); @endphp
                                                        @if(null !== $company)
                                                            <?php $project = \App\Project::where('id', $job->project_id)->first();

                                                            ?>
                                                            <li id="job_li_{{$job->id}}">
                                                                <div class="row">
                                                                    <div class="col-md-9 col-sm-9 col-xs-9">
                                                                        @if( !empty($job->logo))
                                                                            <div class="jobimg thumbimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>
                                                                        @else
                                                                            <div class="jobimg"><a
                                                                                        href="">{{$project->printProjectImage()}}</a>
                                                                            </div>
                                                                        @endif


                                                                        <div class="jobinfo">
                                                                            <h3>
                                                                                <a href="{{route('job.detail', [$job->slug])}}"
                                                                                   title="{{$job->title}}">{{$job->title}}</a>
                                                                                @if($job->isJobExpired())
                                                                                    <small class="expired">{{__('Job is expired')}}</small>
                                                                                @endif
                                                                            </h3>
                                                                            <div class="companyName"><a
                                                                                        href=""
                                                                                        title="{{$project->name}}">{{$project->name}}</a>
                                                                            </div>
                                                                            <div class="location">
                                                                                {{--                                                                                <label class="fulltime"--}}
                                                                                {{--                                                                                       title="{{$job->getJobShift('job_shift')}}">{{$job->getJobShift('job_shift')}}</label>--}}
                                                                                <span>{{$job->getState('state')}}</span>
                                                                                -
                                                                                <span>{{ $job->getCity('city')}}</span>
                                                                            </div>
                                                                            {{--                                                                        <p>{{str_limit(strip_tags($job->description), 150, '...')}}</p>--}}
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                    <div class="col-md-3 col-xs-3 init-btns">
                                                                        {{--                                                            <div class="listbtn"><a href="{{route('list.favourite.applied.users', [$job->id])}}">{{__('List Short Listed Candidates')}}</a></div>--}}
                                                                        {{--                                                            <div class="listbtn"><a href="{{route('list.applied.users', [$job->id])}}">{{__('List Candidates')}}</a></div>--}}
                                                                        <div class="listbtn">


                                                                            <a href="{{url('/edit-front-initiatives/'.$job->id)."?Initiatives_type=Recruiting" }}"><i
                                                                                        class="fa fa-pencil"
                                                                                        aria-hidden="true"></i> {{__('Edit')}}
                                                                            </a>
                                                                        </div>
                                                                        <div class="listbtn">
                                                                            <a href="javascript:;"
                                                                               onclick="deleteJob({{$job->id}});"><i
                                                                                        class="fa fa-trash-o"
                                                                                        aria-hidden="true"></i> {{__('Delete')}}
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </li>
                                                            <!-- job end -->
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @else

                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="page-sec">
                                                        <div class="formpanel text-center">
                                                            <h2>{{__('No Results!!')}}</h2>
                                                            <p>{{__('There are no Job Initiative.')}}</p>
                                                        </div>
                                                    </div>
                                                </div>


                                            @endif

                                        </ul>
                                        <!-- Pagination Start -->
                                        <div class="pagiWrap">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="showreslt">
                                                        {{__('Showing Pages')}} : {{ $jobs_0->firstItem() }}
                                                        - {{ $jobs_0->lastItem() }} {{__('Total')}} {{ $jobs_0->total() }}
                                                    </div>
                                                </div>
                                                <div class="col-md-7 text-right">
                                                    @if(isset($jobs_0) && count($jobs_0))
                                                        {{ $jobs_0->appends(request()->query())->links() }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Pagination end -->
                                    @endif

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
@push('scripts')
    <script type="text/javascript">
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
    </script>
@endpush