@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Join Request initiative')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        @if(isset($joininitiatives) )
                            @if(count($joininitiatives)>0)

                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class="userccount">
                                        <div class="formpanel">
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <h5 class="am-title green-color"><i class="fa fa-users"
                                                                                        aria-hidden="true"></i> {{__('Join Request initiative')}}
                                                    </h5>
                                                </div>
                                            </div>

                                            <div class="row page-sec">
                                                <div class="col-md-12 col-xs-12">
                                                    <table class="table table-dark text-center">
                                                        <thead>
                                                        <tr>
                                                            {{--                                                    <th class="text-center" scope="col">{{__('Position')}}</th>--}}
                                                            <th class="text-center" scope="col">{{__('Name')}}</th>
                                                            <th class="text-center" scope="col">{{__('Email')}}</th>
                                                            <th class="text-center" scope="col">{{__('Phone')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($joininitiatives as $joininitiative)
                                                            <tr>
                                                                {{--                                                        <td>{{ __($user->role_name)}}</td>--}}
                                                                <td>{{ $joininitiative->name }}</td>
                                                                <td><a href="mailto:{{ $joininitiative->email }}">{{ $joininitiative->email }}</a>
                                                                    {{--                                                        <td><a href="mailto:{{ $joininitiative->email }}">{{ $joininitiative->email }}</a>--}}

                                                                </td>
                                                                <td>{{ $joininitiative->phone }}</td>
                                                            </tr>
                                                        @endforeach

                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                            <div class="form-actions">
{{--                                                <button type="submit" class="btn btn-link">--}}

{{--                                                </button>--}}
                                            </div>
                                            {{ $joininitiatives->links() }}
                                        </div>
                                        <a href="{{ url()->previous() }}" class="pull-left"><i class="fa fa-reply"
                                                                             aria-hidden="true"></i> {{__('Back')}}
                                        </a>
                                        @else
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="userccount">
                                                    <div class="page-sec">
                                                    <div class="formpanel text-center">
                                                        <h2>{{__('No Results!!')}}</h2>
                                                        <p>{{__('There are no Request to join initiative.')}}</p>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection