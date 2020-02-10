@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Contacts')])
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
                                        <h5 class="green-color am-title">
                                            <i class="fa fa-globe" aria-hidden="true"></i> {{__('Contacts')}}
                                            <ul class="am-links pull-left">
                                                <li>
                                                    <button type="button" class="btn btn-success " data-toggle="modal"
                                                            data-target="#yourModal"/>
                                                    <i class="fa fa-envelope-o"
                                                       aria-hidden="true"></i> {{__('Compose')}}
                                                </li>

                                                </li>
                                                <li>
                                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                                            data-target="#yourModal2"/>
                                                    <i class="fa fa-user-plus"
                                                       aria-hidden="true"></i> {{__('Add Contacts')}}</a>
                                                </li>
                                            </ul>

                                        </h5>

                                    </div>
                                </div>


                                <!-- Compose Message Modal -->
                                <div class="modal fade" id="yourModal" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div id="alert_messages_1"></div>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <h5 class="modal-title green-color"
                                                    id="myModalLabel">{{__('Compose')}}</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row page-sec">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'contact') !!}">
                                                            <label class="am-label"><span
                                                                        class="red-color">*</span> {{__('to')}}:</label>
                                                            <?php
                                                            $subject = old('subject');
                                                            $message = old('message');
                                                            $contact = old('contact', $contactsArrayId);
                                                            ?>
                                                            {!! Form::select('contact[]', $contactsArray, $contact, array('class'=>'form-control select2-multiple', 'id'=>'contact', 'multiple'=>'multiple','style'=>"    width: 100%;",'data-validation'=>'required')) !!}
                                                            {{--                                                                {!! APFrmErrHelp::showErrors($errors, 'contact') !!}--}}
                                                            <span class="help-block red-color"
                                                                  id="contact_1"> <strong>{!! APFrmErrHelp::showErrors($errors, 'contact_1') !!}</strong></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="formrow">
                                                            <label class="am-label"><span
                                                                        class="red-color">*</span> {{__('Subject')}}
                                                                :</label>
                                                            <input type="text" name="subject"
                                                                   value="{{ $subject }}"
                                                                   class="form-control" id="subject"
                                                                   placeholder="{{__('Subject')}}" data-validation="required">
                                                            <span class="help-block red-color"
                                                                  id="subject_1"> <strong>{!! APFrmErrHelp::showErrors($errors, 'subject') !!}</strong></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="formrow">
                                                            <label class="am-label"><span
                                                                        class="red-color">*</span> {{__('Message')}}
                                                                :</label>
                                                            <textarea name="message" class="form-control" id="message"
                                                                      placeholder="{{__('Text Massage')}}" data-validation="required">{{ $message }}</textarea>
                                                            <span class="help-block red-color"
                                                                  id="message_1"> <strong>{!! APFrmErrHelp::showErrors($errors, 'message') !!}</strong></span>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <input type="button" class="btn btn-default-focus"
                                                       id="save_mail" value="{{__('Submit')}}">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">{{__('Closing')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add New Contact Modal -->
                                <div class="modal fade" id="yourModal2" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <h5 class="modal-title green-color"
                                                    id="myModalLabe2">{{__('Add Contacts')}}</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row page-sec">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'first_name') !!}">
                                                            <label class="am-label"><span
                                                                        class="red-color">*</span> {{__('First Name')}}:</label>
                                                            {!! Form::text('first_name', null, array('class'=>'form-control', 'id'=>'first_name', 'placeholder'=>__('First Name'),'data-validation'=>'required')) !!}

                                                            <span class="help-block red-color"
                                                                  id="first_name_1"> <strong>   {!! APFrmErrHelp::showErrors($errors, 'first_name') !!}</strong></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'last_name') !!}">
                                                            <label class="am-label"><span
                                                                        class="red-color">*</span> {{__('Last Name')}}:</label>
                                                            {!! Form::text('last_name', null, array('class'=>'form-control', 'id'=>'last_name', 'placeholder'=>__('Last Name'),'data-validation'=>'required')) !!}

                                                            <span class="help-block red-color"
                                                                  id="last_name_1"> <strong>  {!! APFrmErrHelp::showErrors($errors, 'last_name') !!}</strong></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'email') !!}">
                                                            <label class="am-label"><span
                                                                        class="red-color">*</span> {{__('Email')}}
                                                                :</label>
                                                            {!! Form::text('email', null, array('class'=>'form-control', 'id'=>'email', 'placeholder'=>__('Email'),'data-validation'=>'required')) !!}
                                                            {!! APFrmErrHelp::showErrors($errors, 'email') !!}
                                                            <span class="help-block red-color"
                                                                  id="email_1"> <strong>   {!! APFrmErrHelp::showErrors($errors, 'email') !!}</strong></span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="button" class="btn btn-default-focus"
                                                       id="save_contacts" value="{{__('Save')}}">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">{{__('Closing')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row page-sec">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="userbtns">
                                            <?php
                                            if ((isset($_GET['type']))) {
                                                if (urldecode($_GET['type']) == 'inbox')
                                                    $c_or_e = old('compose_inbox_or_send', 'inbox');
                                                else if (urldecode($_GET['type']) == 'send')
                                                    $c_or_e = old('compose_inbox_or_send', 'send');
                                            } else
                                                $c_or_e = old('compose_inbox_or_send', 'inbox');
                                            ?>
                                            <ul class="row profilestat nav nav-tabs">


                                                <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'inbox')? 'active':''}}"
                                                    style=" width: 50%;">
                                                    <div class="inbox">
                                                        <a data-toggle="tab" href="#inbox" aria-expanded="false">
                                                            <i class="fa fa-users"
                                                               aria-hidden="true"></i> {{__('Contacts List')}}
                                                            {{--                                                            @if($messages_count>0)<span--}}
                                                            {{--                                                                    class="no-tag pull-left">{{$messages_count}}</span>@endif--}}
                                                        </a>
                                                    </div>
                                                </li>

                                                <li class="col-md-2 col-sm-4 col-xs-6 {{($c_or_e == 'send')? 'active':''}}"
                                                    style=" width: 50%;">
                                                    <div class="inbox">
                                                        <a data-toggle="tab" href="#send" aria-expanded="false">
                                                            <i class="fa fa-send-o"
                                                               aria-hidden="true"></i> {{__('Sent messages')}}
                                                        </a>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="tab-content">


                                            <div id="inbox"
                                                 class="formpanel tab-pane fade {{($c_or_e == 'inbox')? 'active in':''}}">
                                                <ul class="searchList">
                                                    <!-- job start -->
                                                    @if(count($contacts)!=0)
                                                        @if(isset($contacts) && count($contacts))
                                                            @foreach($contacts as $contact)

                                                                @php
                                                                    $style = (!(bool)$contact->is_read)? 'font-weight: bold;':'';
                                                                @endphp

                                                                <li>
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-xs-4">
                                                                            <p>{{$contact->first_name}} {{ $contact->last_name }}</p>
                                                                        </div>
                                                                        <div class="col-md-4 col-xs-4">
                                                                            <p>{{$contact->email}} </p>
                                                                        </div>
                                                                        <div class="col-md-3 col-xs-3">
                                                                            <p>{{$contact->created_at->format('M d Y')}}</p>
                                                                        </div>
                                                                        <div class="col-md-1 col-xs-1">
                                                                            <p>
                                                                                <a href="javascript:;"
                                                                                   onclick="deleteContacts({{$contact->id}});"
                                                                                   style="{{$style}}"><i
                                                                                            class="fa fa-trash-o red-color"
                                                                                            aria-hidden="true"></i>
                                                                                </a>
                                                                            </p>
                                                                        </div>
                                                                        {{--                                                                        <div class="col-md-1">--}}
                                                                        {{--                                                                            @if((bool)$contact->is_event)<span--}}
                                                                        {{--                                                                                    class="no-tag " style="background-color: green;">{{__('Appointment')}}</span>@endif--}}
                                                                        {{--                                                                        </div>--}}
                                                                    </div>
                                                                </li>
                                                                <!-- job end -->
                                                            @endforeach
                                                        @endif
                                                    @else

                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="page-sec">
                                                                <div class="formpanel text-center">
                                                                    <h2>{{__('No Results!!')}}</h2>
                                                                    <p>{{__('There are no Contacts')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    @endif
                                                </ul>
                                                <!-- sign up form end-->
                                            </div>
                                            <div id="send"
                                                 class="formpanel tab-pane fade {{($c_or_e == 'send')? 'active in':''}}">
                                                <ul class="searchList">
                                                    <!-- job start -->
                                                    @if(count($messages_send)!=0)
                                                        @if(isset($messages_send) && count($messages_send))
                                                            @foreach($messages_send as $message)

                                                                @php
                                                                    $style = (!(bool)$message->is_read)? 'font-weight: bold;':'';
                                                                @endphp

                                                                <li>
                                                                    <a href="<?php echo e(url('employee-contacts-message-detail/' . $message->id) . "?Reply=no_send"); ?>"
                                                                       title="{{$message->subject}}">
                                                                        <div class="row message">
                                                                            <div class="col-md-4 col-xs-4">
                                                                                <p>{{$message->email}}</p>
                                                                            </div>
                                                                            <div class="col-md-4 col-xs-4">
                                                                                <p>{{$message->subject}}</p>
                                                                            </div>
                                                                            <div class="col-md-3 col-xs-3">
                                                                                <p>{{$message->created_at->format('M d Y')}}</p>
                                                                            </div>
                                                                            <div class="col-md-1 col-xs-1">
                                                                                <p>
                                                                                    <a href="javascript:;"
                                                                                       onclick="deleteContactsMassage({{$message->id}});"
                                                                                       style="{{$style}}"><i
                                                                                                class="fa fa-trash-o red-color"
                                                                                                aria-hidden="true"></i>
                                                                                    </a>
                                                                                </p>
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
@push('scripts')
    <script type="text/javascript">
        function deleteContacts(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {

                $.post("{{ route('delete.front.contacts') }}", {
                    id: id,
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        if (response == 'ok') {

                            window.location.href = ' {{url('employee-contacts')}}' + "?type=inbox";
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function deleteContactsMassage(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                console.log(id);
                $.post("{{ route('delete.front.massage.contacts') }}", {
                    id: id,
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        if (response == 'ok') {

                            window.location.href = ' {{url('employee-contacts')}}' + "?type=send";
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
                $('.select2-multiple').select2({
                    placeholder: "{{__('Choose Contacts')}}",
                    allowClear: true
                });
                var cookies = {};

                if (document.cookie && document.cookie != '') {
                    var split = document.cookie.split(';');
                    for (var i = 0; i < split.length; i++) {
                        var name_value = split[i].split("=");
                        name_value[0] = name_value[0].replace(/^ /, '');
                        cookies[decodeURIComponent(name_value[0])] = decodeURIComponent(name_value[1]);
                    }

                }
                if (typeof cookies.js_massage != "undefined") {
                    var js_massage = cookies.js_massage;
                    var errorString = '<div role="alert" class="alert alert-success">' + js_massage + '</div>';
                    $('#alert_messages').html(errorString);
                    setTimeout(function () {
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
                            response = JSON.parse(data);
                            var res = response.success;
                            if (res == 'success') {
                                document.cookie = "js_massage={{__('Message sent successfully')}}";
                                window.location.href = "{{ route('employee.messages') }}";
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

                            });
                    }
                }

                $('#save_mail').click(function (e) {

                    e.preventDefault();
                    console.log($('#subject').val())
                    var data = {
                        _token: '{{ csrf_token() }}',
                        subject: $('#subject').val(),
                        message: $('#message').val(),
                        contact: $('#contact').val(),
                    };

                    $.post('{{ route('send.mail.contacts') }}', data,
                        function (result) {

                            if (result == "{{__('Message sent successfully')}}") {

                                var errorString = '<div role="alert" class="alert alert-success">' + result + '</div>';
                                $('#alert_messages').html(errorString);


                                $('#yourModal').modal('hide');
                                window.location.href = ' {{url('employee-contacts')}}' + "?type=send";
                                $('#contact').value = '';
                                $('#message').value = '';
                                $('#subject').value = '';

                            } else {
                                if (typeof JSON.parse(result)["contact"] != "undefined") {
                                    $('#contact_1').html(JSON.parse(result)["contact"][0]);
                                }
                                if (typeof JSON.parse(result)["message"] != "undefined") {
                                    $('#message_1').html(JSON.parse(result)["message"][0]);
                                }
                                if (typeof JSON.parse(result)["subject"] != "undefined") {
                                    $('#subject_1').html(JSON.parse(result)["subject"][0]);
                                }


                                // $('#yourModal').modal('hide');
                            }
                        });
                });
                $('#save_contacts').click(function (e) {

                    e.preventDefault();

                    var data = {
                        _token: '{{ csrf_token() }}',
                        first_name: $('#first_name').val(),
                        last_name: $('#last_name').val(),
                        email: $('#email').val(),
                    };

                    $.post('{{ route('add.mail.contacts') }}', data,
                        function (result) {
                            console.log(result);
                            if (result == "{{__('Contacts added successfully')}}") {
                                var errorString = '<div role="alert" class="alert alert-success">' + result + '</div>';
                                $('#alert_messages').html(errorString);


                                $('#yourModal2').modal('hide');
                                window.location.href = ' {{url('employee-contacts')}}' + "?type=inbox";
                                $('#first_name').value = '';
                                $('#last_name').value = '';
                                $('#email').value = '';
                            } else {
                                console.log(typeof JSON.parse(result)["first_name"])
                                if (typeof JSON.parse(result)["first_name"] != "undefined") {
                                    $('#first_name_1').html(JSON.parse(result)["first_name"][0]);
                                }
                                if (typeof JSON.parse(result)["last_name"] != "undefined") {
                                    $('#last_name_1').html(JSON.parse(result)["last_name"][0]);
                                }
                                if (typeof JSON.parse(result)["email"] != "undefined") {
                                    $('#email_1').html(JSON.parse(result)["email"][0]);
                                }


                                // $('#yourModal').modal('hide');
                            }
                        });
                });
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