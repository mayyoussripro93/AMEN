@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Contacts Messages')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="userccount message-cont messages">
                                <div class="row">

                                    <div class="col-md-12 col-xs-12">

                                        <h5 class="green-color am-title"><i class="fa fa-envelope-open-o"
                                                                            aria-hidden="true"></i> {{__('Message Text')}}

                                        </h5>
                                    </div>
                                </div>
                                <div class="row page-sec">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="userbtns">

                                            <?php
                                            $c_or_e = old('compose_inbox_or_send', 'compose');
                                            ?>
                                            <ul class="row profilestat nav nav-tabs">

                                                <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'inbox')? 'active':''}}"
                                                    style=" width: 50%;">
                                                    <div class="inbox">

                                                        <a href="{{url('/employee-contacts')."?type=inbox"}}"
                                                           aria-expanded="true">
                                                            <i class="fa fa-plus"
                                                               aria-hidden="true"></i> {{__('Contacts List')}}
                                                        </a>
                                                    </div>
                                                </li>

                                                <li class="col-md-2 col-sm-4 col-xs-6 active {{($c_or_e == 'send')? 'active':''}}"
                                                    style=" width: 50%;">
                                                    <div class="inbox">
                                                        <a href="<?php echo e(url('employee-contacts') . "?type=send"); ?>"
                                                           aria-expanded="false">
                                                            <i class="fa fa-send-o"
                                                               aria-hidden="true"></i> {{__('Sent messages')}}
                                                        </a>
                                                    </div>
                                                </li>

                                            </ul>


                                        </div>
                                        <div class="panel-group">
                                            <!-- job start -->
                                            @if(isset($message))
                                                <div class="panel panel-default">

                                                    <div class="panel-body">
                                                        <p class="text-left">
                                                            <table>
                                                                <tr>
                                                                    <td><strong>{{__('Date')}}:</strong></td>
                                                                    <td>
                                                        <p>{{$message->created_at->format('d F Y, h:i A')}}</p></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>{{__('To')}}:</strong></td>
                                                            <td><p>{{$contact_mail->first_name}}
                                                                    <span><<a href="{{url('user-profile/'.$message->from_id.'#contact_applicant')}}"
                                                                              target="_blank">{{$message->email}}</a>></span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>{{__('Subject')}}:</strong></td>
                                                            <td><p>{{$message->subject}}</p></td>
                                                        </tr>

                                                        <tr>
                                                            <td><strong>{{__('Message')}}:</strong></td>
                                                            <td><p>{{$message->message}}</p></td>
                                                        </tr>

                                                        </table>
                                                        </p>

                                                        <div class="form-actions">
                                                            <button type="submit" class="btn btn-link">
                                                                <a href="{{url('/employee-contacts')."?type=send"}}" style="font-size: 10px;"><i
                                                                            class="fa fa-reply"
                                                                            aria-hidden="true"></i> {{__('Back')}}
                                                                </a>
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- job end -->
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
    </div>
    @include('includes.footer')
@endsection