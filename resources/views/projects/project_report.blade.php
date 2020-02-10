@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Safety Report')])

    <style>
        th {
            text-align: center;
        }

        .tab-pane.fade.show.active {
            opacity: 1;
        }

        .tab-pane {
            line-height: 1.5;
        }

        .nav-tabs > li {
            float: right;
        }

        .job-header .contentbox ul li {
            padding: 7px 0 0 0;
        }

        .job-header .contentbox ul li:before {
            content: none;
        }

        .nav-tabs > li > a.active {
            border-color: #ddd;
            border-bottom-color: transparent !important;
            background: #fff;
        }
    </style>
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
        @include('flash::message')
        @include('projects.inc.project_header')


            <!-- Create Report 1 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="job-header">
                        <div class="contentbox" style="overflow: auto;">
                            <h3>تقرير السلامة</h3>
                            <h6 style="margin-bottom: 15px">رقم التقرير: (يصدر تلقائيًا) </h6>


                            {{--<h1 style="Color: #ccc; font-size: 72px; text-align: center">لا يوجد مخالفات</h1>--}}

{{--                            {!! Form::model($company, array('method' => 'put', 'route' => array('update.company.profile'), 'class' => 'form', 'files'=>true)) !!}--}}

                            <div class="col-md-12" style="margin-bottom: 30px;">
                                <label for="exampleFormControlTextarea1"
                                       style="margin-bottom: 10px; font-weight: bold;">بيانات الخطر</label>

                                <table class="table table-dark text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">تاريخ المخالفة</th>
                                        <th scope="col">رقم المخالفة</th>
                                        <th scope="col">نوع الخطر</th>
                                        <th scope="col">درجة الخطر</th>
                                        <th scope="col">تفاصيل المخالفة</th>
                                        <th scope="col">قيمة المخالفة</th>
                                        <th scope="col">إزالة المخاطر</th>
                                        <th scope="col">تم السداد</th>
                                        <th scope="col">تعديل | حذف</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">12-5-2018</th>
                                        <td>هـ ص م - 526 - 636‬</td>
                                        <td>توصيل أسلاك غير آمن</td>
                                        <td>عالي</td>
                                        <td><i class="fa fa-eye"></i></td>
                                        <td>150 ر.س</td>
                                        <td>3 يوم (إغلاق المنطقة)</td>
                                        <td><i class="fa fa-check-circle green-color"></i></td>
                                        <td><a href="" onclick="showProfileSkillEditModal(16);"
                                               class="text text-primary"><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;<a
                                                    href="" onclick="delete_profile_skill(16);"
                                                    class="text text-danger"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">12-7-2018</th>
                                        <td>هـ ص م - 526 - 636‬</td>
                                        <td>بدون الخوذة</td>
                                        <td>متوسط</td>
                                        <td><i class="fa fa-eye"></i></td>
                                        <td>100 ر.س</td>
                                        <td>5 يوم (إغلاق المنطقة)</td>
                                        <td><i class="fa fa-times-circle" style="color: red;"></i></td>
                                        <td><a href="" onclick="showProfileSkillEditModal(16);"
                                               class="text text-primary"><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;<a
                                                    href="" onclick="delete_profile_skill(16);"
                                                    class="text text-danger"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">12-9-2018</th>
                                        <td>هـ ص م - 526 - 636‬</td>
                                        <td>مواد تعثر على الممرات</td>
                                        <td>منخفض</td>
                                        <td><i class="fa fa-eye"></i></td>
                                        <td>50 ر.س</td>
                                        <td>7 يوم</td>
                                        <td><i class="fa fa-check-circle" style="color: green"></i></td>
                                        <td><a href="" onclick="showProfileSkillEditModal(16);"
                                               class="text text-primary"><i class="fa fa-pencil"></i></a>&nbsp;|&nbsp;<a
                                                    href="" onclick="delete_profile_skill(16);"
                                                    class="text text-danger"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

{{--                            {!! Form::close() !!}--}}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    @include('includes.footer')
@endsection
