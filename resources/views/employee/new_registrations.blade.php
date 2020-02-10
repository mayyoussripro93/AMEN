@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('New Users')])
    <!-- Inner Page Title end -->
    <style>
        .table > tbody > tr > td, .table > tbody > tr > th,
        .table > tfoot > tr > td, .table > tfoot > tr > th,
        .table > thead > tr > td, .table > thead > tr > th {
            font-size: 13px;
        }

        @media screen and (max-width: 992px) {
            .table > tbody > tr > td, .table > tbody > tr > th,
            .table > tfoot > tr > td, .table > tfoot > tr > th,
            .table > thead > tr > td, .table > thead > tr > th {
                font-size: 12px;
            }
        }

        @media screen and (max-width: 600px) {
            .table > tbody > tr > td, .table > tbody > tr > th,
            .table > tfoot > tr > td, .table > tfoot > tr > th,
            .table > thead > tr > td, .table > thead > tr > th {
                max-width: 75px;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
            }
        }
    </style>
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        @if(isset($users) )
                            @if(count($users)>0)
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class="userccount">
                                        <div class="formpanel">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <h5 class="am-title green-color"><i class="fa fa-users"
                                                                                        aria-hidden="true"></i> {{__('New Users')}}
                                                    </h5>
                                                </div>
                                            </div>

                                            <div class="row page-sec">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table class="table table-dark text-center">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center" scope="col">{{__('Position')}}</th>
                                                            <th class="text-center" scope="col">{{__('Name')}}</th>
                                                            <th class="text-center" scope="col">{{__('Email')}}</th>
                                                            <th class="text-center" scope="col">{{__('Details')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($users as $user)
                                                            <tr>
                                                                <td>{{ __($user->role->role_name)}}</td>
                                                                <td>{{ $user->name }}</td>
                                                                <td>
                                                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{route('one-employee-view', [Crypt::encryptString($user->id)])}}"><i class="fa fa-eye"></i></a></td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            {{ $users->links() }}
                                        </div>

                                        @else
                                            <div class="col-md-9 col-sm-8">
                                                <div class="userccount">
                                                    <div class="formpanel text-center">
                                                        <h2>{{__('No Results!!')}}</h2>
                                                        <p>{{__('There are no new users waiting for your verification.')}}</p>
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