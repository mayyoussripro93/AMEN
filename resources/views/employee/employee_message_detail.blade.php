@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Company Messages')])
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
                                    <div class="col-md-12">
                                        <h5 class="green-color am-title"><i class="fa fa-envelope-open-o"
                                                                            aria-hidden="true"></i> {{__('Message Text')}}
                                        </h5>
                                    </div>
                                </div>
                                <div class="row page-sec">
                                    <div class="col-md-12">
                                        <div class="userbtns">
                                            @if(urldecode($_GET['Reply']) == 'no_inbox')

                                                <ul class="row profilestat nav nav-tabs">
                                                    <?php
                                                    $c_or_e = old('compose_inbox_or_send', 'inbox');
                                                    ?>
                                                    <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'compose')? 'active':''}}">
                                                        <div class="inbox">

                                                            <a href="{{url('/employee-messages')."?type=compose"}}"
                                                               aria-expanded="false">
                                                                <i class="fa fa-plus"
                                                                   aria-hidden="true"></i> {{__('Compose')}}
                                                            </a>
                                                        </div>
                                                    </li>
                                                    <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'inbox')? 'active':''}}">
                                                        <div class="inbox">
                                                            <a href="<?php echo e(url('employee-messages') . "?type=inbox"); ?>"
                                                               aria-expanded="true">
                                                                <i class="fa fa-inbox"
                                                                   aria-hidden="true"></i> {{__('Inbox')}}
                                                            </a>
                                                        </div>
                                                    </li>

                                                    <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'send')? 'active':''}}">
                                                        <div class="inbox">
                                                            <a href="<?php echo e(url('employee-messages') . "?type=send"); ?>"
                                                               aria-expanded="false">
                                                                <i class="fa fa-send-o"
                                                                   aria-hidden="true"></i> {{__('Send')}}
                                                            </a>
                                                        </div>
                                                    </li>

                                                </ul>
                                            @elseif(urldecode($_GET['Reply']) == 'no_send')
                                                <?php
                                                $c_or_e = old('compose_inbox_or_send', 'send');
                                                ?>
                                                <ul class="row profilestat nav nav-tabs">

                                                    <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'compose')? 'active':''}}">
                                                        <div class="inbox">

                                                            <a href="{{url('/employee-messages')."?type=compose"}}"
                                                               aria-expanded="false">
                                                                <i class="fa fa-plus"
                                                                   aria-hidden="true"></i> {{__('Compose')}}
                                                            </a>
                                                        </div>
                                                    </li>
                                                    <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'inbox')? 'active':''}}">
                                                        <div class="inbox">
                                                            <a href="<?php echo e(url('employee-messages') . "?type=inbox"); ?>"
                                                               aria-expanded="false">
                                                                <i class="fa fa-inbox"
                                                                   aria-hidden="true"></i> {{__('Inbox')}}@if($messages_count>0)<span
                                                                        class="no-tag pull-left">{{$messages_count}}</span>@endif
                                                            </a>
                                                        </div>
                                                    </li>

                                                    <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'send')? 'active':''}}">
                                                        <div class="inbox">
                                                            <a href="<?php echo e(url('employee-messages') . "?type=send"); ?>"
                                                               aria-expanded="true">
                                                                <i class="fa fa-send-o"
                                                                   aria-hidden="true"></i> {{__('Send')}}
                                                            </a>
                                                        </div>
                                                    </li>

                                                </ul>
                                                @else
                                                                                  <?php
                                                                                            $c_or_e = old('compose_inbox_or_send', 'compose');
                                                                                           ?>
                                                                                      <ul class="row profilestat nav nav-tabs">

                                                                                          <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'compose')? 'active':''}}">
                                                                                              <div class="inbox">

                                                                                                  <a href="{{url('/employee-messages')."?type=compose"}}"
                                                                                                     aria-expanded="true">
                                                                                                      <i class="fa fa-plus"
                                                                                                         aria-hidden="true"></i> {{__('Compose')}}
                                                                                                  </a>
                                                                                              </div>
                                                                                          </li>
                                                                                          <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'inbox')? 'active':''}}">
                                                                                              <div class="inbox">
                                                                                                  <a href="<?php echo e(url('employee-messages') . "?type=inbox"); ?>"
                                                                                                     aria-expanded="false">
                                                                                                      <i class="fa fa-inbox"
                                                                                                         aria-hidden="true"></i> {{__('Inbox')}}@if($messages_count>0)<span
                                                                                                              class="no-tag pull-left">{{$messages_count}}</span>@endif
                                                                                                  </a>
                                                                                              </div>
                                                                                          </li>

                                                                                          <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'send')? 'active':''}}">
                                                                                              <div class="inbox">
                                                                                                  <a href="<?php echo e(url('employee-messages') . "?type=send"); ?>"
                                                                                                     aria-expanded="false">
                                                                                                      <i class="fa fa-send-o"
                                                                                                         aria-hidden="true"></i> {{__('Send')}}
                                                                                                  </a>
                                                                                              </div>
                                                                                          </li>

                                                                                      </ul>
                                            @endif


                                        </div>
                                        <div class="panel-group">
                                            <!-- job start -->
                                            @if(isset($message))
                                                <div class="panel panel-default">

                                                    <div class="panel-body">
                                                        @if((bool)$message->is_event)<h5 class="green-color am-title">{{__('Schedule visit and meeting')}}</h5>@endif
                                                            @if((bool)$message->is_replay)
                                                                <h5 class="green-color am-title">{{__('RE')}}</h5>@endif
                                                        <p class="text-left">
                                                            <table>
                                                                <tr>
                                                                    <td><strong>{{__('Date')}}:</strong></td>
                                                                    <td>
                                                        <p>{{$message->created_at->format('d F Y, h:i A')}}</p></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>{{__('From')}}:</strong></td>
                                                            <td><p>{{$message->from_name}}
                                                                    <span><<a href="{{url('user-profile/'.$message->from_id.'#contact_applicant')}}"
                                                                              target="_blank">{{$message->from_email}}</a>></span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>{{__('Subject')}}:</strong></td>
                                                            <td><p>{{$message->subject}}</p></td>
                                                        </tr>
                                                            @if((bool)$message->is_event)
                                                            <tr>
                                                                <td><strong>{{__('Start Date appointment')}}:</strong></td>
                                                                <td><p>{{ \Arabic\Arabic::adate(' j F Y g:i A', strtotime( $message->start_date))}}</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>{{__('End Date appointment')}}:</strong></td>
                                                                <td><p>{{\Arabic\Arabic::adate(' j F Y g:i A', strtotime( $message->end_date))}}</p></td>
                                                            </tr>
                                                            @endif
                                                            <tr>

                                                                <td><strong>{{__('Message')}}:</strong></td>


                                                                @if((bool)$message->is_event)
                                                                <td><p>{{ \Soundasleep\Html2Text::convert($message->message_txt)}}</p></td>
                                                                    @else
                                                                    <td><p>{{$message->message_txt}}</p></td>
                                                                @endif
                                                            </tr>

                                                        </table>
                                                        </p>
                                                        @if(urldecode($_GET['Reply']) != 'no_send')
                                                        <div class="form-actions">
                                                            <button type="submit" class="btn green-bg uppercase">
                                                                <a href="{{url('/employee-messages')."?message=compose&id=". $message->from_id."&massage_id=".$message->id}}"
                                                                   class="white-color"><i class="fa fa-reply"
                                                                                          aria-hidden="true"></i> {{__('Reply')}}
                                                                </a>
                                                            </button>
                                                        </div>
                                                        @endif
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