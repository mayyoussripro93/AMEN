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
    <table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%; border-bottom: solid 1px #ccc; float: {{$float}};" dir="{{$dir}}">
        <tr>
            <td class="cols-wrapper" style="padding-left:12px;padding-right:12px"><!--[if mso]>
                <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">
                    <tr>
                        <td width="192" style="width: 192px;" valign="top">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                    <tr>
                        <td class="row" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                                <tr>
                                    <td class="subtitle" style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: right;">
                                        {{ __('Amen has restored your account.') }}
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