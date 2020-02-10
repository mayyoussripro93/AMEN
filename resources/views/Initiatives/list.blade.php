@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end -->
<!-- Inner Page Title start -->

@if(urldecode($_GET['Initiatives_type']) == 'Learning')

    @include('includes.inner_page_title', ['page_title'=>__('Learning')])
@elseif(urldecode($_GET['Initiatives_type']) == 'Training')

    @include('includes.inner_page_title', ['page_title'=>__('Training')])
@endif

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
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container">
        @include('flash::message')
        <form action="{{route('Initiatives.list')}}" method="get">
            <!-- Page Title start -->
            @if(urldecode($_GET['Initiatives_type']) == 'Learning')
                {!! Form::hidden("Initiatives_type", 'Learning') !!}

            @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
                {!! Form::hidden("Initiatives_type", 'Training') !!}
            @endif
            <div class="row pageSearch">


                        @if(Auth::guard('employee')->check() && Auth::guard('employee')->user()->employee_role_id!=1)
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            @if(urldecode($_GET['Initiatives_type']) == 'Learning')
                                <a href="{{url('/post-initiatives')."?Initiatives_type=Education" }}" class="btn"><i class="fa fa-cube" aria-hidden="true"></i> {{__('Add Initiatives')}}</a>

                            @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
                                <a href="{{url('/post-initiatives')."?Initiatives_type=Training" }}" class="btn"><i class="fa fa-cube" aria-hidden="true"></i> {{__('Add Initiatives')}}</a>
                            @endif

                       </div>
{{--                        @else--}}
{{--                        <a href="{{url('my-profile#cvs')}}" class="btn"><i class="fa fa-file-text" aria-hidden="true"></i> {{__('Upload Your Resume')}}</a>--}}
                        @else
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="dropdown" style="width: 100%;">
                                @if(urldecode($_GET['Initiatives_type']) == 'Learning')
                                <button class="dropbtn btn-block" >{{__('Learning')}} <i class="fa fa-caret-down"></i></button>
                                @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
                                    <button class="dropbtn btn-block" >{{__('Training')}} <i class="fa fa-caret-down"></i></button>
                                @else
                                    <button class="dropbtn btn-block" >{{__('Recruiting')}} <i class="fa fa-caret-down"></i></button>
                                @endif
                                <div class="dropdown-content">
                                 <a href="{{url('/initiatives')."?Initiatives_type=Learning"}}"><i
                                                    class="fa fa-graduation-cap"
                                                    aria-hidden="true"></i> {{__('Learning')}}</a>

                                   <a href="{{url('/initiatives')."?Initiatives_type=Training"}}"><i
                                                    class="fa fa-cogs" aria-hidden="true"></i> {{__('Training')}}</a>

{{--                                <a href="{{url('/jobs')}}"><i class="fa fa-black-tie"--}}
{{--                                                                      aria-hidden="true"></i> {{__('Recruiting')}}</a>--}}
                                </div>
                            </div>
                        </div>
                        @endif

                    <div class="searchform col-md-9 col-sm-9 col-xs-9">

                            <div class="row" style="margin: 0;">
{{--                                <div class="col-md-{{((bool)$siteSetting->country_specific_site)? 5:3}}">--}}
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <input type="text" name="search" value="{{Request::get('search', '')}}" class="form-control" placeholder="{{__('Initiative Name')}}" style="height: 55px;"/>
                                </div>
{{--                                <div class="col-md-2"> {!! Form::select('functional_area_id[]', ['' => __('Select Functional Area')]+$functionalAreas, Request::get('functional_area_id', null), array('class'=>'form-control', 'id'=>'functional_area_id')) !!} </div>--}}


{{--                                @if((bool)$siteSetting->country_specific_site)--}}
                                {!! Form::hidden('country_id[]', Request::get('country_id[]', $siteSetting->default_country_id), array('id'=>'country_id')) !!}
{{--                                @else--}}

{{--                                    {!! Form::hidden('Initiatives_type', Request::get('Initiatives_type', null), array('id'=>'Initiatives_type','value'=>'{{urldecode($_GET[\'u\'])}}')) !!}--}}
{{--                                <div class="col-md-2">--}}
{{--                                    {!! Form::select('country_id[]', ['' => __('Select Country')]+$countries, Request::get('country_id', $siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}--}}
{{--                                </div>--}}
{{--                                @endif--}}

                                <div class="col-md-4 col-sm-3 col-xs-6">
                                    <span id="state_dd">
                                        {!! Form::select('state_id[]', ['' => __('Select State')], Request::get('state_id', null), array('class'=>'form-control', 'id'=>'state_id')) !!}
                                    </span>
                                </div>
                                <div class="col-md-4 col-sm-3 col-xs-6">
                                    <span id="city_dd">
                                        {!! Form::select('city_id[]', ['' => __('Select City')], Request::get('city_id', null), array('class'=>'form-control', 'id'=>'city_id')) !!}
                                    </span>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-6" style="float: left;">
                                    <button type="submit" class="btn" style="height: 55px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </div>

                    </div>
                </div>

            <!-- Page Title end -->
        </form>
        <form action="{{route('Initiatives.list')}}" method="get">
        @if(urldecode($_GET['Initiatives_type']) == 'Learning')
            {!! Form::hidden("Initiatives_type", 'Learning') !!}
            <?php $Initiatives_type = '1' ?>

        @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
            {!! Form::hidden("Initiatives_type", 'Training') !!}
            <?php $Initiatives_type = '2' ?>
        @endif
            <!-- Search Result and sidebar start -->
            <div class="row">
                @include('includes.initiatives_list_side_bar')
{{--                <div class="col-md-3 col-sm-6 pull-right">--}}
{{--                    <!-- Sponsord By -->--}}
{{--                    <div class="sidebar">--}}
{{--                        <h4 class="widget-title">{{__('Sponsord By')}}</h4>--}}
{{--                        <div class="gad">{!! $siteSetting->listing_page_vertical_ad !!}</div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="userccount">
                    <!-- Search List -->
                    <ul class="searchList">
                        <!-- job start -->
                        @if(isset($jobs) && count($jobs))
                        @foreach($jobs as $job)
                        @php $company = $job->getEmployee(); @endphp
{{--                        @if(null !== $company)--}}
                        <li>
                            <div class="row">
                                <div class="col-md-8 col-sm-8 col-xs-8">

                                    <div class="jobimg">
                                        @if( !empty($job->logo))
                                            <div class="jobimg thumbimg">{{ ImgUploader::print_image("company_logos/$job->logo") }}</div>
                                        @else
                                            <img src="{{ asset('/') }}admin_assets/no_image.jpg" class="thumbimg">
                                        @endif
                                     </div>
                                    <div class="jobinfo">
                                        @if($job->Initiatives_type == 1)
                                        <h3><a href="{{url('initiatives/'.$job->slug."?Initiatives_type=Learning")}}" title="{{$job->title}}">{{$job->title}}</a></h3>
                                        @elseif($job->Initiatives_type == 2)
                                        <h3><a href="{{url('initiatives/'.$job->slug."?Initiatives_type=Training")}}" title="{{$job->title}}">{{$job->title}}</a></h3>
                                        @elseif($job->Initiatives_type == 0)
                                            <h3><a href="{{url('/jobs')}}" title="{{$job->title}}">{{$job->title}}</a></h3>
                                        @endif
                                        <div class="companyName">
                                            @if($job->Initiatives_type != 0)

                                            <strong>{{$job->company_organize_name}}</strong>
                                            <small>({{\Arabic\Arabic::adate(' j F Y', strtotime($job->gregorian_data))}})</small>
                                            @else
                                                <a href="" title="{{$company->name}}"><span class="permanent">{{$company->name}}</span></a>
                                            @endif
                                        </div>
                                        <div class="companyName"></div>
{{--                                        <div class="companyName"><a href="{{route('employee.detail', $company->slug)}}" title="{{$company->name}}">{{$company->name}}</a></div>--}}
                                        <div class="location">
{{--                                            <label class="fulltime" title="{{$job->getJobShift('job_shift')}}">{{$job->getJobShift('job_shift')}}</label>--}}

                                            <span>{{$job->getState('state')}}</span>
                                            - <span>{{$job->getCity('city')}}</span></div>
{{--                                            <p>{{str_limit(strip_tags($job->description), 150, '...')}}</p>--}}

                                    </div>





{{--                                    <div class="jobimg">{{$company->printCompanyImage()}}</div>--}}
{{--                                    <div class="jobinfo">--}}
{{--                                        <h3><a href="{{route('job.detail', [$job->slug])}}" title="{{$job->title}}">{{$job->title}}</a></h3>--}}
{{--                                        <div class="companyName"><a href="{{route('company.detail', $company->slug)}}" title="{{$company->name}}">{{$company->name}}</a></div>--}}
{{--                                        <div class="location">--}}
{{--                                            <label class="fulltime" title="{{$job->getJobType('job_type')}}">{{$job->getJobType('job_type')}}</label>--}}
{{--                                            - <span>{{$job->getCity('city')}}</span></div>--}}
{{--                                    </div>--}}

                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    @if($job->Initiatives_type == 1)
                                    <div class="listbtn">
                                        <a href="{{url('initiatives/'.$job->slug."?Initiatives_type=Learning")}}"><i class="fa fa-eye"></i> {{__('View Details')}}</a>
                                    </div>
                                    @elseif($job->Initiatives_type == 2)
                                        <div class="listbtn">
                                            <a href="{{url('initiatives/'.$job->slug."?Initiatives_type=Training")}}"><i class="fa fa-eye"></i> {{__('View Details')}}</a>
                                        </div>
                                    @elseif($job->Initiatives_type == 0)
                                        <div class="listbtn">
                                            <a href="{{route('job.detail', [$job->slug])}}"><i class="fa fa-eye"></i> {{__('View Details')}}</a>
                                        </div>
                                    @endif
                                        <div class="listbtn">
                                        <a href="{{route('join.initiatives', $job->id)}}"><i class="fa fa-reply"></i> {{__('Join To Initiatives')}}</a>
                                        </div>
                                </div>
                            </div>
                        </li>
                        <!-- job end -->
{{--                        @endif--}}
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document" style="margin-top: 100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <img src="../images/amen_logo.png" width="150" style="margin-bottom: 15px">
                <p style="font-size: 16px; color: #555; line-height: 1.5; padding-bottom: 15px;">ﻷننا نؤمن بأن السلامة والصحة المهنية هي ثقافة مجتمع فإننا نسعى لتعليم وتدريب المتطوعين والمهندسين وطلاب التخصصات الهندسية والمهنية لنشر هذه الثقافة مما يخلق بيئة عمل أكثر أمانًا في المستقبل.
                </p>
            </div>

        </div>
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
    @include('includes.country_state_city_js')
<script>
    // var App = jQuery('#date_type');
    //
    // App.change(function () {
    //     if ($('#date_type').val() == '0') {
    //
    //         $('.hidden_greg').hide();
    //         $('.hidden_greg').val("");
    //         $('.hidden_hijri').show();
    //
    //     } else if ($('#date_type').val() == '1') {
    //         $('.hidden_greg').show();
    //         $('.hidden_hijri').hide();
    //         $('.hidden_hijri' +
    //             '').val("");
    //
    //     }
    // });
    $(document).ready(function () {
        var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();


        $('#gregorian_data').daterangepicker({

            minDate: new Date(currentYear, currentMonth, currentDate)
            ,  dateFormat: 'yy-mm-dd'
            // altField: '#gregorian_data',
            // altFormat: 'yyyy-mm-dd'
            , startDate: moment(date).add(0, 'days'),

            "singleDatePicker": true,
            // "timePicker": true,
            // "timePicker24Hour": true,
            "autoUpdateInput": false,
            "locale": {
                "format": "YYYY-MM-DD",
                // "format": "DD, d MM, yyyy",
                "separator": " - ",
                "applyLabel": "Apply",
                "cancelLabel": "Cancel",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Su",
                    "Mo",
                    "Tu",
                    "We",
                    "Th",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ],
                "firstDay": 1
            },
        }).on('hide.daterangepicker', function(ev, picker) {

            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            event.preventDefault();


            // console.log(picker.startDate.format('YYYY-DD'));
            // console.log(picker.endDate.format('YYYY-MM-DD'));
        });
        $('#gregorian_data_to').daterangepicker({

            minDate: new Date(currentYear, currentMonth, currentDate)
            , dateFormat:  'yy-mm-dd'
            , startDate: moment(date).add(0, 'days'),
            //  altField: '#gregorian_data_to',
            // altFormat: 'DD, d MM, yyyy',
            "singleDatePicker": true,
            // "timePicker": true,
            // "timePicker24Hour": true,
            "autoUpdateInput": false,
            "locale": {
                "format": "YYYY-MM-DD",
                "separator": " - ",
                "applyLabel": "Apply",
                "cancelLabel": "Cancel",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Su",
                    "Mo",
                    "Tu",
                    "We",
                    "Th",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ],
                "firstDay": 1
            },
        }).on('hide.daterangepicker', function(ev, picker) {

            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            event.preventDefault();

            // console.log(picker.startDate.format('YYYY-DD'));
            // console.log(picker.endDate.format('YYYY-MM-DD'));
        });
        // $('#islamic_data').calendarsPicker(
        //     $.extend({showTrigger: '#calImg',
        //             altField: '#rtlAlternate',
        //             altFormat: 'DD, d MM, yyyy',
        //             localNumbers: true,
        //             calendar: $.calendars.instance('islamic'),
        //         },
        //
        //         $.calendarsPicker.regionalOptions['ar'])
        // );
        // $('#gregorian_data').calendarsPicker({
        //     calendar: $.calendars.instance(''),
        //     showTrigger: '#calImg',
        //     altFormat: 'DD, d MM, yyyy',
        //     localNumbers: true,
        //     showOtherMonths: true,
        //
        // });
        //
        // $('#islamic_data_to').calendarsPicker(
        //     $.extend({showTrigger: '#calImg',
        //             altField: '#rtlAlternate_to',
        //             altFormat: 'DD, d MM, yyyy',
        //             localNumbers: true,
        //             calendar: $.calendars.instance('islamic'),
        //         },
        //
        //         $.calendarsPicker.regionalOptions['ar'])
        // );
        // $('#gregorian_data_to').calendarsPicker({
        //     calendar: $.calendars.instance(''),
        //     showTrigger: '#calImg',
        //     altFormat: 'DD, d MM, yyyy',
        //     localNumbers: true,
        //     showOtherMonths: true,
        //
        // });
        // var App = jQuery('#date_type');
        //
        // App.change(function () {
        // if ($('#date_type').val() === '0') {
        //
        //     $('.hidden_greg').hide();
        //     $('.hidden_hijri').show();
        //
        // } else if ($('#date_type').val() === '1') {
        //     $('.hidden_greg').show();
        //     $('.hidden_hijri').hide();
        //
        // }
        // });
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
        // $(".datepicker").datepicker({
        //     autoclose: true,
        //     format: 'yyyy-m-d'
        // });


        //////modal-show///////////////////////////////////

        setTimeout(function(){ $('#exampleModal').modal('show'); }, 3000);
        setTimeout(function(){ $('#exampleModal').modal('hide'); }, 10000);
    });
    // window.addEventListener("load", function () {
    //     var App = jQuery('#date_type');
    //     App.change(function () {
    //         if ($('#date_type').val() == '0') {
    //
    //             $('.hidden_greg').hide();
    //             $('.hidden_hijri').show();
    //
    //         } else if ($('#date_type').val() == '1') {
    //             $('.hidden_greg').show();
    //             $('.hidden_hijri').hide();
    //
    //         }
    //     });
    // });
</script>

@endpush