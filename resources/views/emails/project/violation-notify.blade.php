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
            <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
                <div class="title">
                    <p style="font-family: 'Droid Arabic Kufi', serif; font-size: 18px;font-weight:400;color: #333;text-align: right;
                 padding-top: 20px;">{{$data['status_message']}}</p>
                </div>
            </td>
        </tr>
        <tr>
            <td class="content-wrapper" style="padding-left:24px;padding-right:24px">
                <table style="width: 100%; text-align: right;">
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__('State')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{$data['violation']->project->state->state}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__('City')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{$data['violation']->project->city->city}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__('Project Name')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{$data['violation']->project->name}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__('Owner')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{$data['violation']->project->owner}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__('Created By')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{$data['violation']->employee_id!='' ?$data['violation']->employee->name :''}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__('Date')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__($data['violation']->gregorian_date)}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__('Time')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__($data['violation']->violation_time)}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__('Violation Code')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{$data['violation']->project->code }} - {{$data['violation']->code}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__('Danger Category')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{$data['violation']->danger_cat->country}}
                            / {{$data['violation']->sub_cat->state}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__('axles')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__($data['violation']->axles)}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__('floor')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__($data['violation']->floor)}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__('area')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__($data['violation']->area)}}</td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__('Special Marque')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__($data['violation']->special_marque)}}</td>
                    </tr>

                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__('Danger Description')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__($data['violation']->description)}}</td>
                    </tr>
{{--trial-hidden--}}
                    {{--<tr>--}}
                        {{--<th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__('Main Fine')}} ({{__('SAR')}})</th>--}}
                        {{--<td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{$data['violation']->cost}} </td>--}}
                    {{--</tr>--}}
                    @if($data['type']=='confirm')
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__('Danger Status')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;">{{__($data['violation']->danger_status_last)}} </td>
                    </tr>
                    <tr>
                        <th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__('Area Status')}}</th>
                        <td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__($data['violation']->area_status_last)}} </td>
                    </tr>
                    {{--<tr>--}}
                        {{--<th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;"><strong>{{__('Total Cost')}} ({{__('SAR')}})</strong></th>--}}
                        {{--<td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;padding: 5px;"><strong>{{$data['violation']->current_cost}}</strong></td>--}}
                    {{--</tr>--}}
                    @endif
                    {{--<tr>--}}
                        {{--<th style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__('Payment Status')}}</th>--}}
                        {{--@php $payment=($data['violation']->payment_status==1)? 'Yes' :'No' @endphp--}}
                        {{--<td style="font-family: 'Droid Arabic Kufi', serif;font-size:14px;line-height:22px;font-weight:400;color:#333; text-align: right;background-color: #f0f0f0; padding: 5px;">{{__($payment)}} </td>--}}
                    {{--</tr>--}}
                </table>
            </td>
        </tr>
    </table>
@endsection