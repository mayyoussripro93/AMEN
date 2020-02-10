@extends('admin.layouts.email_template')
@section('content')
    @php if (App::isLocale('ar')) {
    $dir='rtl';
    $float='right';
    }
    else{
    $dir='ltr';
     $float='left';
    }
    @endphp

    <table border="0" cellpadding="0" cellspacing="0" class="force-row"
           style="width: 100%; border-bottom: solid 1px #ccc; float: {{$float}};" dir="{{$dir}}">
        <tr>
            <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
                <div class="title" style="font-family: 'Droid Arabic Kufi', serif; font-size: 18px;font-weight:400;color: #333;text-align: right;
                 padding-top: 20px;">{{__('Welcome')}} {{ $user[0]->name }} ,
                </div>
            </td>
        </tr>
        <tr>
            <td class="cols-wrapper" style="padding-left:12px;padding-right:12px"><!--[if mso]>
                <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">
                    <tr>
                        <td width="192" style="width: 192px;" valign="top">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                    <tr>
                        <td class="row" valign="top"
                            style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                                <tr>
                                    <td class="subtitle" style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: right;">
                                        {{ __('Your registered data has been reviewed and now you can access your account on Amen platform.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subtitle" style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: right;">
                                        <p><strong style="color: #17ad68;">{{__('Step One')}}
                                                :</strong> {{__('Please visit the following link and click on the activation button.')}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subtitle"
                                        style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: right;">
                                        <strong>{{ __('Activation Link') }}: </strong>
                                        <br><a href="{{ $url }}" target="_blank">{{ $url }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subtitle"
                                        style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: right;">
                                        <p><strong style="color: #17ad68;">{{__('Step Two')}}
                                                :</strong> {{__('You will be directed to the login page, please enter the following credentials to access you account.')}}
                                        </p>
                                        <strong><u>{{ __('Login Credentials') }}:</u></strong><br>
                                        <strong>{{ __('Email') }}:</strong> {{ $user[0]->email }}<br>
                                        <strong>{{ __('Password') }}:</strong> {{ $user['generated_pass']}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subtitle"
                                        style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: right;">
                                        <strong><u>{{ __('Registered Data') }}:</u></strong><br>
                                        <strong>{{ __('Position Applied') }}:</strong> {{ __($user[0]->role_name) }}<br>
                                        <strong>{{ __('State') }}:</strong> {{ $user['state'] }}<br>
                                        <strong>{{ __('Name') }}:</strong> {{ $user[0]->name }}<br>
                                        {{--<strong>{{ __('National ID Card No.') }}:</strong> {{ $user[0]->national_id_card_number }}<br>--}}
                                        <strong>{{ __('Email') }}:</strong> {{ $user[0]->email }}<br>
                                        <strong>{{ __('Phone') }}:</strong> {{ $user[0]->phone}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
    </table>
@endsection