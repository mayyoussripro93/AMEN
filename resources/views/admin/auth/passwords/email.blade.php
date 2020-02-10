@extends('admin.layouts.login_layout')
@section('content')
    <style>
        h3.font-green, h3.block {
            color: #17ad68 !important;
        }
        .btn.green:not(.btn-outline).focus, .btn.green:not(.btn-outline):focus,
        .btn.green.uppercase, .btn.green:not(.btn-outline).active.focus, .btn.green:not(.btn-outline).active:focus, .btn.green:not(.btn-outline).active:hover, .btn.green:not(.btn-outline):active.focus, .btn.green:not(.btn-outline):active:focus, .btn.green:not(.btn-outline):active:hover, .open > .btn.green:not(.btn-outline).dropdown-toggle.focus, .open > .btn.green:not(.btn-outline).dropdown-toggle:focus, .open > .btn.green:not(.btn-outline).dropdown-toggle:hover {
            background-color: #17ad68;
            border-color: #17ad68;
        }

        .btn.green.uppercase:hover {
            background-color: #555;
            border-color: #555;
        }
    </style>
    <!-- BEGIN LOGIN -->
    <div class="content">
        <!-- BEGIN FORGOT PASSWORD FORM -->
        @if (session('status'))

                <div class="text-center">
                    <img src="../../images/amen_logo.png" alt="Amen" height="120">
                    <h3 class="block">Email Sent!</h3>
                    <p> An email with password reset link has been sent to your provided email address. </p>
                </div>

        @else
            <form class="form-horizontal forget-form" role="form" method="POST"
                  action="{{ route('admin.password.email') }}" style="display:block;">
                {{ csrf_field() }}
                <div class="text-center">
                    <img src="../../images/amen_logo.png" alt="Amen" height="120">

                    <h3 class="font-green">Forgot Password ?</h3>
                </div>
                <p> Enter your e-mail address below to reset your password. </p>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter Email please. </span></div>
                @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span>{{ $errors->first('email') }}</span></div>
                @endif
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">E-Mail Address</label>
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off"
                           placeholder="Email Address" name="email" value="{{old('email')}}"/>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase pull-right">Send Password Reset Link</button>
                </div>
            </form>
    @endif
    <!-- END FORGOT PASSWORD FORM -->
    </div>
@endsection