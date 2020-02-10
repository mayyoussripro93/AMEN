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
                 padding-top: 20px;">{{__('Welcome')}} {{ $user['user']->name }} ,
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
                                        {{ __('Amen has created account for you and now you can login using the following credentials.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subtitle" style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: right;">
                                        <strong style="color: #17ad68;">{{ __('Login Credentials') }}</strong><br>
                                        <strong>{{ __('Email') }}:</strong> {{ $user['user']->email }}<br>
                                        <strong>{{ __('Password') }}:</strong> {{ $user['generated_pass'] }}<br>
                                        <strong>{{ __('Login Link') }}:</strong> <a href="{{ $url }}"
                                                                                    target="_blank"> {{ $url }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="subtitle" style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: right;">
                                        <strong style="color: #17ad68;">{{ __('Registered Data') }}</strong><br>
                                        <strong>{{ __('Name') }}:</strong> {{ $user['user']->name }}<br>
                                        {{--<strong>{{ __('National ID Card No.') }}:</strong> {{ $user['user']->national_id_card_number }}<br>--}}
                                        <strong>{{ __('Job Employer') }}:</strong> {{$user['user']->job_employer }}<br>
                                        <strong>{{ __('Job Title') }}:</strong> {{ $user['user']->job_title}}<br>
                                        <strong>{{ __('Email') }}:</strong> {{ $user['user']->email }}<br>
                                        <strong>{{ __('Phone') }}:</strong> {{ $user['user']->phone}}
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
                <![endif]--></td>
        </tr>
    </table>
@endsection