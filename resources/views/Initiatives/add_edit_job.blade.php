@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Edit Initiative')])
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
                                <!-- Personal Information -->
                                    <div class="row">
                                        @if(urldecode($_GET['Initiatives_type']) == 'Education')

                                            @include('Initiatives.inc.education')

                                        @elseif(urldecode($_GET['Initiatives_type']) == 'Training')
                                            @include('Initiatives.inc.training')
                                        @elseif(urldecode($_GET['Initiatives_type']) == 'Recruiting')
                                            @include('Initiatives.inc.job')
                                        @endif

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
        @push('styles')
            <style type="text/css">
                .userccount p {
                    text-align: left !important;
                }
            </style>
        @endpush
        @push('scripts')
            <script>
                //redirect to specific tab
                $(document).ready(function () {
                    $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
                });
            </script>
    {{--        <script>--}}
    {{--            $.get("inc/training.blade.php", function(data){--}}
    {{--                console.log(data);--}}
    {{--                console.log(":D");--}}
    {{--                $('#appends').append(data);--}}
    {{--            });--}}
    {{--        </script>--}}
    @endpush