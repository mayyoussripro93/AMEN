@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Messages')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container-fluid">
            <div class="row center-content">
                <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                    @include('flash::message')
                    <div id="alert_messages"></div>

                    <div class="row">
                        @include('includes.employee_dashboard_menu')

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="userccount messages">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <h5 class="green-color am-title"><i class="fa fa-envelope-o"
                                                                            aria-hidden="true"></i> {{__('Messages')}}
                                        </h5>
                                    </div>
                                </div>
                                <div class="row page-sec">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="userbtns">
                                            <?php
                                            if ((isset($_GET['type']))) {
                                                if (urldecode($_GET['type']) == 'compose')
                                                    $c_or_e = old('compose_inbox_or_send', 'compose');
                                                else if (urldecode($_GET['type']) == 'inbox')
                                                    $c_or_e = old('compose_inbox_or_send', 'inbox');
                                                else if (urldecode($_GET['type']) == 'send')
                                                    $c_or_e = old('compose_inbox_or_send', 'send');
                                            } else
                                                $c_or_e = old('compose_inbox_or_send', 'compose');
                                            ?>
                                            <ul class="row profilestat nav nav-tabs">

                                                <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'compose')? 'active':''}}">
                                                    <div class="inbox">
                                                        <a data-toggle="tab" href="#compose" aria-expanded="true">
                                                            <i class="fa fa-plus"
                                                               aria-hidden="true"></i> {{__('Compose')}}
                                                        </a>
                                                    </div>
                                                </li>
                                                <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'inbox')? 'active':''}}">
                                                    <div class="inbox">
                                                        <a data-toggle="tab" href="#inbox" aria-expanded="false">
                                                            <i class="fa fa-inbox"
                                                               aria-hidden="true"></i> {{__('Inbox')}}@if($messages_count>0)<span
                                                                    class="no-tag pull-left">{{$messages_count}}</span>@endif
                                                        </a>
                                                    </div>
                                                </li>

                                                <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'send')? 'active':''}}">
                                                    <div class="inbox">
                                                        <a data-toggle="tab" href="#send" aria-expanded="false">
                                                            <i class="fa fa-send-o"
                                                               aria-hidden="true"></i> {{__('Send')}}
                                                        </a>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="tab-content">

                                            @if (isset($_GET['message']))
                                                @if(($_GET['message']) == 'compose')
                                                    <div id="compose" class="formpanel tab-pane fade {{($c_or_e == 'compose')? 'active in':''}}">
                                                        <!-- Contact Company start -->
                                                        <div class="job-header">
                                                            <div class="jobdetail">
                                                                {{--                                                            <h3 id="contact_company">{{__('Send Massage')}}</h3>--}}

                                                                <?php
                                                                $from_name = $from_email = $from_phone = $subject = $message = $from_id = '';
                                                                if (Auth::check()) {
                                                                    $from_name = Auth::guard('employee')->user()->name;
                                                                    $from_email = Auth::guard('employee')->user()->email;
                                                                    $from_phone = Auth::guard('employee')->user()->phone;
                                                                    $from_id = Auth::guard('employee')->user()->id;
                                                                }
                                                                $from_name = old('name', $from_name);
                                                                $from_email = old('email', $from_email);
                                                                $from_phone = old('phone', $from_phone);
                                                                $subject = old('subject');
                                                                $message = old('message');
$employee_id= $_GET['id'];
                                                                ?>
                                                                <form method="post" id="send-company-message-form">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="compose_inbox_or_send"
                                                                           value="compose"/>
                                                                    <input type="hidden" name="empid"
                                                                           value="{{ $employee_id}}">
                                                                    <input type="hidden" name="compose" value="compose">
                                                                    <input type="hidden" name="massage_id"
                                                                           value="{{ $_GET['massage_id']}}">
                                                                    <input type="hidden" name="company_id"
                                                                           value="{{$from_id}}">
                                                                    <input type="hidden" name="company_name"
                                                                           value="{{ $from_name }}">
                                                                    <div class="formpanel">


                                                                        <div class="formrow">
                                                                <textarea name="message" class="form-control"
                                                                          placeholder="{{__('Text Massage')}}" ,data-validation="required">{{ $message }}</textarea>
                                                                        </div>

                                                                        <div class="formrow" style="margin-top: 35px;">
                                                                            <input type="button" class="btn"
                                                                                   value="{{__('Submit')}}"
                                                                                   id="send_company_message">
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- sign up form end-->
                                                    </div>
                                                @endif
                                            @else
                                                <div id="compose" class="formpanel tab-pane fade {{($c_or_e == 'compose')? 'active in':''}}">
                                                    <!-- Contact Company start -->
                                                    <div class="job-header">
                                                        <div class="jobdetail">
                                                            {{--                                                        <h3 id="contact_company">{{__('Send Massage')}}</h3>--}}

                                                            <?php
                                                            $from_name = $from_email = $from_phone = $subject = $message = $from_id = '';
                                                            if (Auth::check()) {
                                                                $from_name = Auth::guard('employee')->user()->name;
                                                                $from_email = Auth::guard('employee')->user()->email;
                                                                $from_phone = Auth::guard('employee')->user()->phone;
                                                                $from_id = Auth::guard('employee')->user()->id;
                                                            }
                                                            $from_name = old('name', $from_name);
                                                            $from_email = old('email', $from_email);
                                                            $from_phone = old('phone', $from_phone);
                                                            $subject = old('subject');
                                                            $message = old('message');
                                                            ?>
                                                            <form method="post" id="send-company-message-form" >
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="compose_inbox_or_send"
                                                                       value="compose"/>
                                                                <input type="hidden" name="compose" value="notcompose">
                                                                <input type="hidden" name="company_id"
                                                                       value="{{$from_id}}">
                                                                <input type="hidden" name="company_name"
                                                                       value="{{ $from_name }}">
                                                                <div class="formpanel">
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-xs-12">
                                                                            @if (isset($_GET['id']))
                                                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'consultant') !!}" id="country_id_div">
                                                                                    <label class="am-label"><span class="red-color">*</span> {{__('Project Name')}}:</label>
                                                                                    {!! Form::select('consultant', ['' => __('Select Project')]+$projects,Crypt::decryptString($_GET['id']), array('class'=>'form-control', 'id'=>'consultant','data-validation'=>'required')) !!}
                                                                                    <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'consultant') !!}</strong></span>
                                                                                </div>
                                                                            @else
                                                                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'consultant') !!}" id="country_id_div">
                                                                                    <label class="am-label"><span class="red-color">*</span> {{__('Project Name')}}:</label>
                                                                                    {!! Form::select('consultant', ['' => __('Select Project')]+$projects, old('consultant'), array('class'=>'form-control', 'id'=>'consultant','data-validation'=>'required')) !!}
                                                                                    <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'consultant') !!}</strong></span>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'employee_id') !!}" id="employee_id_div">
                                                                                <label class="am-label"><span class="red-color">*</span> {{__('Employee Name')}}:</label>
                                                                                <span id="default_state_dd">
                                                                                    {!! Form::select('employee_id[]', ['' => __('Select Employee')],  old('employee_id'), array('class'=>'form-control select2-multiple', 'id'=>'employee_id','multiple'=>'multiple','data-validation'=>'required')) !!}
{{--                                                                                    {!! Form::select('skills[]', $jobSkills, $skills, array('class'=>'form-control select2-multiple', 'id'=>'skills', 'multiple'=>'multiple')) !!}--}}
                                                                                </span>
                                                                                <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'employee_id') !!}</strong></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="formrow">
                                                                        <label class="am-label"><span class="red-color">*</span> {{__('Subject')}}:</label>
                                                                        <input type="text" name="subject"
                                                                               value="{{ $subject }}"
                                                                               class="form-control"
                                                                               placeholder="{{__('Subject')}}" data-validation="required" >
                                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'subject') !!}</strong></span>
                                                                    </div>
                                                                    <div class="formrow">
                                                                        <label class="am-label"><span class="red-color">*</span> {{__('Message')}}:</label>
                                                                        <textarea name="message" class="form-control"
                                                                      placeholder="{{__('Text Massage')}}" data-validation='required'>{{ $message }}</textarea>
                                                                        <span class="help-block"> <strong>{!! APFrmErrHelp::showErrors($errors, 'message') !!}</strong></span>

                                                                    </div>
                                                                    <div class="formrow">
                                                                        <input type="button" class="btn"
                                                                               value="{{__('Submit')}}"
                                                                               id="send_company_message">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- sign up form end-->
                                                </div>

                                            @endif
                                            <div id="inbox" class="formpanel tab-pane fade {{($c_or_e == 'inbox')? 'active in':''}}">
                                                <ul class="searchList">
                                                    <!-- job start -->
                                                    @if(count($messages)!=0)
                                                    @if(isset($messages) && count($messages))
                                                        @foreach($messages as $message)

                                                            @php
                                                                $style = (!(bool)$message->is_read)? 'font-weight: bold;':'';
                                                            @endphp

                                                            <li>
                                                                <a href="<?php echo e(url('employee-message-detail/'.$message->id) . "?Reply=no_inbox"); ?>"
                                                                   title="{{$message->subject}}">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-4">
                                                                            <p style="{{$style}}">{{$message->from_name}}</p>
                                                                        </div>
                                                                        <div class="col-md-4 col-xs-4">
                                                                            <p style="{{$style}}">{{$message->subject}}</p>
                                                                        </div>
                                                                        <div class="col-md-3 col-xs-3">
                                                                            <p style="{{$style}}">{{$message->created_at->format('M d Y')}}</p>
                                                                        </div>
                                                                        <div class="col-md-1 col-xs-1">
                                                                            <p style="{{$style}}">
                                                                            <a  href="javascript:;"
                                                                               onclick="deleteJobInbox({{$message->id}});" style="{{$style}}"><i
                                                                                        class="fa fa-trash-o red-color" style="font-size: 15px;"
                                                                                        aria-hidden="true"></i>
                                                                            </a>
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-1 col-xs-1">
                                                                            @if((bool)$message->is_event)<i class="fa fa-calendar green-color" aria-hidden="true"></i>@endif
                                                                        </div>
                                                                    </div>
                                                                </a>

                                                            </li>
                                                            <!-- job end -->
                                                        @endforeach
                                                    @endif
                                                    @else

                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="page-sec">
                                                                <div class="formpanel text-center">
                                                                    <h2>{{__('No Results!!')}}</h2>
                                                                    <p>{{__('There are no Massage')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    @endif
                                                </ul>
                                            {{($messages->appends(["type"=>"inbox"],["inbox" => $messages->currentPage()])->links())}}
                                                <!-- sign up form end-->
                                            </div>
                                            <div id="send" class="formpanel tab-pane fade {{($c_or_e == 'send')? 'active in':''}}">
                                                <ul class="searchList">
                                                    <!-- job start -->
                                                    @if(count($messages_send)!=0)
                                                    @if(isset($messages_send) && count($messages_send))
                                                        @foreach($messages_send as $message)

                                                            @php
                                                                $style = (!(bool)$message->is_read)? 'font-weight: bold;':'';
                                                            @endphp

                                                            <li>
                                                                <a href="<?php echo e(url('employee-message-detail/'.$message->id) . "?Reply=no_send"); ?>"
                                                                   title="{{$message->subject}}">
                                                                    <div class="row message">
                                                                        <div class="col-md-4 col-xs-4">
                                                                            <p>{{__('To')}}: {{$message->to_name}}</p>
                                                                        </div>
                                                                        <div class="col-md-4 col-xs-4">
                                                                            <p>{{$message->subject}}</p>
                                                                        </div>
                                                                        <div class="col-md-2 col-xs-2">
                                                                            <p>{{$message->created_at->format('M d Y')}}</p>
                                                                        </div>
                                                                        <div class="col-md-1 col-xs-1">
                                                                            <p>
                                                                                <a  href="javascript:;"
                                                                                    onclick="deleteJob({{$message->id}});" style="{{$style}}"><i
                                                                                            class="fa fa-trash-o red-color" style="font-size: 15px;"
                                                                                            aria-hidden="true"></i>
                                                                                </a>
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-1 col-xs-1">
                                                                        @if((bool)$message->is_event)
                                                                                <p title="{{__('Meeting Alert')}}"><i class="fa fa-calendar green-color" aria-hidden="true"></i></p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <!-- job end -->
                                                        @endforeach
                                                    @endif
                                                    @else

                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="page-sec">
                                                                <div class="formpanel text-center">
                                                                    <h2>{{__('No Results!!')}}</h2>
                                                                    <p>{{__('There are no Massage')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    @endif
                                                </ul>

                                            {{($messages_send->appends(["type"=>"send"],["send" => $messages_send->currentPage()])->links())}}
                                                <!-- sign up form end-->
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
    </div>
                @include('includes.footer')
                @endsection
@push('styles')
    <style type="text/css">
        .datepicker > div {
            display: block;
        }
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-search--inline .select2-search__field,
        .select2-container .select2-search--inline {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple {
            border-color: #ddd !important;
        }

        .rtl .radio-inline {
            padding-left: 0;
            padding-right: 20px;
        }

        .radio-inline {
            margin-top: 5px;
        }

        .rtl .radio-inline input[type=radio] {
            margin-left: 0;
            margin-right: -20px;
        }

        .formpanel label {
            margin-bottom: 0;
            margin-left: 10px;
            display: inline-block;
        }
    </style>
@endpush
                @push('scripts')
                    <script type="text/javascript">

                        function deleteJob(id) {
                            var msg = 'Are you sure?';
                            if (confirm(msg)) {
                                console.log(id);
                                $.post("{{ route('delete.front.massage') }}", {
                                    id: id,
                                    _method: 'DELETE',
                                    _token: '{{ csrf_token() }}'
                                })
                                    .done(function (response) {
                                        if (response == 'ok') {

                                            window.location.href =' {{url('employee-messages')}}'+ "?type=send";
                                        } else {
                                            alert('Request Failed!');
                                        }
                                    });
                            }
                        }
                        function deleteJobInbox(id) {
                            var msg = 'Are you sure?';
                            if (confirm(msg)) {
                                console.log(id);
                                $.post("{{ route('delete.front.massage') }}", {
                                    id: id,
                                    _method: 'DELETE',
                                    _token: '{{ csrf_token() }}'
                                })
                                    .done(function (response) {
                                        if (response == 'ok') {

                                            window.location.href =' {{url('employee-messages')}}'+ "?type=inbox";
                                        } else {
                                            alert('Request Failed!');
                                        }
                                    });
                            }
                        }
                    </script>
                    <script type="text/javascript">
                        $(document).ready(function () {



                                var cookies = {};

                                if (document.cookie && document.cookie != '') {
                                    var split = document.cookie.split(';');
                                    for (var i = 0; i < split.length; i++) {
                                        var name_value = split[i].split("=");
                                        name_value[0] = name_value[0].replace(/^ /, '');
                                        cookies[decodeURIComponent(name_value[0])] = decodeURIComponent(name_value[1]);
                                    }

                                }
                              var timer;
                                if (typeof cookies.js_massage != "undefined") {
                                    var js_massage = cookies.js_massage;
                                    var errorString = '<div role="alert" class="alert alert-success">' + js_massage + '</div>';
                                    $('#alert_messages').html(errorString);
                                    // if(  $('#alert_messages').)
                                    timer = setTimeout(function () {
                                        $('#alert_messages').hide('fast')
                                    }, 5000);

                                    var delete_cookie = function (js_massage) {
                                        document.cookie = js_massage + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';

                                    };
                                    delete_cookie('js_massage');
                                }

                                $(document).on('click', '#send_company_message', function () {

                                    // $('input, select, textarea').each(function () {
                                    //
                                    //     console.log($(this));
                                    //
                                    // })
                                    var postData = $('#send-company-message-form').serialize();
                                    postData = postData + "&employee_id=" + $('#employee_id').val();
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{ route('contact.employee.message.send') }}",
                                        data: postData,
                                        //dataType: 'json',
                                        success: function (data) {
                                            if(typeof timer != undefined){

                                                clearTimeout(timer);
                                                $('#alert_messages').show('fast')
                                            }
                                            response = JSON.parse(data);
                                            var res = response.success;
                                            if (res == 'success') {
                                                $('#alert_messages').show('fast')
                                                document.cookie = "js_massage={{__('Message sent successfully')}}";
                                                window.location.href = "{{ route('employee.messages') }}";
                                                $('#alert_messages').show('fast')
                                            } else {
                                                var errorString = '<div class="alert alert-danger" role="alert"><ul>';
                                                response = JSON.parse(data);
                                                $.each(response, function (index, value) {
                                                    errorString += '<li>' + value + '</li>';
                                                });
                                                errorString += '</ul></div>';
                                                $('#alert_messages').html(errorString);
                                                $(document).scrollTo('.alert', 2000);
                                            }
                                        },
                                    });
                                });

                                $('#consultant').on('change', function (e) {

                                    e.preventDefault();
                                    filterLangStates(0);
                                });
                                filterLangStates(<?php echo old('employee_id', (isset($job)) ? $job->employee_id : 0); ?>);

                                function filterLangStates(employee_id) {
                                    var country_id = $('#consultant').val();
                                    var inputId = 't_employee_id';
                                    if (country_id != '') {
                                        $.post("{{ route('filter.lang.employee.dropdown') }}", {
                                            country_id: country_id,
                                            employee_id: employee_id,
                                            _method: 'POST',
                                            _token: '{{ csrf_token() }}'
                                        })
                                            .done(function (response) {

                                                $('#default_state_dd').html(response);

                                                $('.select2-multiple').select2({
                                                    placeholder: "{{ __('Select Employee')}}",
                                                    allowClear: true
                                                })

                                            });
                                    }
                                }
                            }
                        );

                        $.validate({
                            modules : 'file',
                            addValidClassOnAll : true,
                            errorMessagePosition : 'top' ,// Instead of 'inline' which is default
                            validateOnBlur : false,
                            showHelpOnFocus : false,
                            addSuggestions : false
                        });
                    </script>
    @endpush