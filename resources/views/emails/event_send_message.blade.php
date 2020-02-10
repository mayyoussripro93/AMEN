
@extends('admin.layouts.email_template')
@section('content')
<table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">
    <tr>
        <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
            <div class="title" style="font-family: 'Droid Arabic Kufi', serif; font-size: 18px;font-weight:400;color: #333;text-align: right;
                 padding-top: 20px; direction: rtl;">{{__('Welcome')}} {{ $to_name }},</div></td>
    </tr>
    <tr>
        <td class="cols-wrapper" style="padding-left:12px;padding-right:12px"><!--[if mso]>
         <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">
            <tr>
               <td width="192" style="width: 192px;" valign="top">
                  <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">
                <tr>
                    <td class="row" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tr>
                                <td class="subtitle" style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: right; direction: rtl;">
                            <?php if (!empty($note ))  {;?>
                                    {{ $note }} <br>
                            <?php }?>
                                    <strong>{{__('Meeting Title')}}: </strong>{{ $subject }}
                                    <br>
                                    <strong>{{__('Meating Detail')}}: </strong>{{\Soundasleep\Html2Text::convert($message_txt) }}
                                    <br>
                                    <strong>{{__('Start Date')}}: </strong>{{ $start_date }}
                                    <br>
                                    <strong>{{__('End Date')}}: </strong>{{ $end_date }}

                                </td>
                            </tr>
                            <tr>
                                <td style="direction: rtl;font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px; text-align: right;">{{__('Thanks')}}
                                    <br>{{__('Amen Platform')}}</td>
                            </tr>
                        </table>
                        <br></td>
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