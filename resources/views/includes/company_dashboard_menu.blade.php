<div class="col-md-3 col-sm-4">
    <div class="row text-center">
        <img src="{{ asset('/') }}images/employers/emplogo1.jpg" >
    </div>


    <ul class="usernavdash">
        <li class="active"><a href="{{route('employee.home')}}"><i class="fa fa-tachometer" aria-hidden="true"></i> {{__('Dashboard')}}</a></li>
        <li><a href="{{ route('employee.edit') }}"><i class="fa fa-user" aria-hidden="true"></i> البروفايل الشخصي</a></li>

        <li><a href="{{route('company.messages')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i> رسائل</a></li>
        <li><a href="{{route('company.followers')}}"><i class="fa fa-building" aria-hidden="true"></i> المشاريع</a></li>
        <li><a href="{{route('create.project.get')}}"><i class="fa fa-folder-open" aria-hidden="true"></i> إنشاء ملف مشروع</a></li>
        <li><a href="{{route('company.followers')}}"><i class="fa fa-user-plus" aria-hidden="true"></i> إنشاء ملف موظف</a></li>
        <li><a href="{{route('company.followers')}}"><i class="fa fa-users" aria-hidden="true"></i><span class="no-tag pull-left">5</span> مستخدمين جدد</a></li>

        <li><a href="{{ route('post.job') }}"><i class="fa fa-wrench" aria-hidden="true"></i>الإبلاغ عن مشكلة</a></li>
        <li><a href="{{ route('posted.jobs') }}"><i class="fa fa-trash-o" aria-hidden="true"></i> حذف الحساب</a></li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> {{__('Logout')}}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
        </li>
    </ul>

</div>
{{--<div class="col-md-3 col-sm-4">--}}
{{--    <ul class="usernavdash">--}}
{{--        <li class="active"><a href="{{route('company.home')}}"><i class="fa fa-tachometer" aria-hidden="true"></i> {{__('Dashboard')}}</a></li>--}}
{{--        <li><a href="{{ route('company.profile') }}"><i class="fa fa-user" aria-hidden="true"></i> {{__('Company Profile')}}</a></li>--}}
{{--        <li><a href="{{ route('company.detail', Auth::guard('company')->user()->slug) }}"><i class="fa fa-user" aria-hidden="true"></i> {{__('Company Public Profile')}}</a></li>--}}
{{--        <li><a href="{{ route('post.job') }}"><i class="fa fa-desktop" aria-hidden="true"></i> {{__('Post Job')}}</a></li>--}}
{{--        <li><a href="{{ route('posted.jobs') }}"><i class="fa fa-desktop" aria-hidden="true"></i> {{__('Company Jobs')}}</a></li>--}}

{{--        <li><a href="{{route('company.messages')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{__('Company Messages')}}</a></li>--}}
{{--        <li><a href="{{route('company.followers')}}"><i class="fa fa-user-o" aria-hidden="true"></i> {{__('Company Followers')}}</a></li>--}}
{{--        <li><a href="{{ route('company.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> {{__('Logout')}}</a>--}}
{{--            <form id="logout-form" action="{{ route('company.logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-12">{!! $siteSetting->dashboard_page_ad !!}</div>--}}
{{--    </div>--}}
{{--</div>--}}