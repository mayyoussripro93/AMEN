<div class="col-md-3 col-sm-3 col-xs-12" id="dash_menu">
    <div class="text-center profile-user-img">
        {{Auth::guard('employee')->user()->printUserImage()}}
        <div class="user-role green-color">{{__(Auth::guard('employee')->user()->role->role_name)}} @if(Auth::guard('employee')->user()->state_id!='')({{Auth::guard('employee')->user()->state->state}})@endif
        <p> {{Auth::guard('employee')->user()->job_title}}</p>
            <p> {{Auth::guard('employee')->user()->name}}</p>
        </div>
        <div class="user-action">
            <a href="{{ route('employee.edit1',['id'=>Crypt::encryptString(Auth::guard('employee')->user()->id)]) }}" data-toggle="tooltip"
               title="" class="text-light" data-original-title="{{__('Edit')}}"><i class="fa fa-pencil"></i></a>
            <a href="{{route('delete.account')}}" data-toggle="tooltip" title="" class="red-color" data-original-title="{{__('Delete')}}"><i
                        class="fa fa-trash-o"></i></a>
        </div>
    </div>


    <ul class="usernavdash">
        <li id="s-dash"><a href="{{route('employee.home')}}"><i class="fa fa-tachometer"
                                                                   aria-hidden="true"></i> {{__('Dashboard')}}</a></li>
        <li id="s-prof"><a href="{{ route('employee.show',['id'=>Crypt::encryptString(Auth::guard('employee')->user()->id)]) }}"><i class="fa fa-user" aria-hidden="true"></i> {{__('My Profile')}}</a></li>

        <li id="s-proj"><a href="{{route('project.projects')}}"><i class="fa fa-building" aria-hidden="true"></i> {{__('Projects')}}</a></li>
        <li data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">
            <a href=""><i class="fa fa-cubes" aria-hidden="true"></i> {{__('The Initiatives')}}<i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
        <ul class="collapse sub-menu" id="collapseExample1">
            <li id="s-edu"><a href="{{url('/posted-initiatives')."?Initiatives_type=Education" }}"><i class="fa fa-graduation-cap" aria-hidden="true"></i> {{__('Education')}}</a></li>
            <li id="s-train"><a href="{{url('/posted-initiatives')."?Initiatives_type=Training" }}"><i class="fa fa-cogs" aria-hidden="true"></i> {{__('Training')}}</a></li>
{{--            <li id="s-recr"><a href="{{url('/posted-initiatives')."?Initiatives_type=Recruiting" }}"><i class="fa fa-black-tie" aria-hidden="true"></i> {{__('Recruiting')}}</a></li>--}}
        </ul>


        {{--        {{route('create.project.form')}}--}}

        @can('amen-state-admin')
{{--            <li id="c-proj"><a href="{{route('create.project.form')}}"><i class="fa fa-folder-open" aria-hidden="true"></i> {{__('Add New Project')}}</a></li>--}}
            <?php
            \App\Employee::find(Auth::guard('employee')->user()->id)->getCachedNewRegister();

            $newRegister=\Cache::get(Auth::guard('employee')->user()->state_id.'newRegister');?>
            <li id="s-users"><a href="{{route('new-employees-view')}}"><i class="fa fa-users" aria-hidden="true"></i>@if($newRegister>0)<span class="no-tag pull-left">{{$newRegister}}</span>@endif {{__('New Users')}}</a></li>
            <li id="c-evalu"><a href="{{route('projects.for.evaluation')}}"><i class="fa fa-list-ol" aria-hidden="true"></i> {{__('Add Evaluation')}}</a></li>
            <li id="c-event"><a href="{{route('events.index')}}"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> {{__('Add Event')}}</a></li>
            <li id="all-evalu"><a href="{{route('employee.evaluation.all')}}"><i class="fa fa-list-ol" aria-hidden="true"></i> {{__('All Employee Evaluation')}}</a></li>
        @endcan
        @can('is_manager')
            <li id="c-user"><a href="{{ route('employee.add') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> {{__('Add New Employee')}}</a></li>
            <li id="v-emp"><a href="{{route('employee.employees')}}"><i class="fa fa-group" aria-hidden="true"></i> {{__('Employees')}}</a></li>
        @endcan

        @can('amen-employee')
            <li id="s-evalu"><a href="{{route('employee.evaluation')}}"><i class="fa fa-list-ol" aria-hidden="true"></i> {{__('Evaluation')}}</a></li>
        @if(Auth::guard('employee')->user()->employee_role_id!=1)
            <li data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <a href=""><i class="fa fa-cube" aria-hidden="true"></i> {{__('Add New Initiative')}}<i class="fa fa-chevron-left" aria-hidden="true"></i></a>
            </li>

            <ul class="collapse sub-menu" id="collapseExample">
                <li id="c-edu"><a href="{{url('/post-initiatives')."?Initiatives_type=Education" }}"><i class="fa fa-graduation-cap" aria-hidden="true"></i> {{__('Education')}}</a></li>
                <li id="c-train"><a href="{{url('/post-initiatives')."?Initiatives_type=Training" }}"><i class="fa fa-cogs" aria-hidden="true"></i> {{__('Training')}}</a></li>
{{--                <li id="c-recr"><a href="{{url('/post-initiatives')."?Initiatives_type=Recruiting" }}"><i class="fa fa-black-tie" aria-hidden="true"></i> {{__('Recruiting')}}</a></li>--}}
            </ul>
            @endif
        @endcan



        <?php
        \App\Employee::find(Auth::guard('employee')->user()->id)->getCachedEventsCount();
        $count_new_event=Cache::get(Auth::guard('employee')->user()->id.'count_new_event');
        ?>
        <li id="s-event"><a href="{{route('events.user.index')}}"><i class="fa fa-calendar" aria-hidden="true"></i> @if($count_new_event>0)<span
                        class="no-tag pull-left">{{$count_new_event}}</span>@endif {{__('Events')}}</a></li>


        <?php
        \App\Employee::find(Auth::guard('employee')->user()->id)->getCachedMessgeCount();
        $messages_count=\Cache::get(Auth::guard('employee')->user()->id.'messages_count');
        ?>

        <li id="s-mess"><a href="{{route('employee.messages')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i> @if($messages_count>0)<span
                        class="no-tag pull-left">{{$messages_count}}</span>@endif  {{__('Messages')}}</a></li>

        <li id="s-cont"><a href="{{route('employee.Contacts')}}"><i class="fa fa-globe" aria-hidden="true"></i>{{__('Contacts')}}</a></li>
        {{--        {{ route('post.job') }}--}}
        <li id="s-abuse"><a href="{{route('report.abuse.company')}}"><i class="fa fa-wrench" aria-hidden="true"></i> {{__('Report a Problem')}}</a></li>
        {{--        {{ route('posted.jobs') }}--}}
        <li id="s-delete"><a href="{{route('delete.account')}}"><i class="fa fa-trash-o" aria-hidden="true"></i> {{__('Delete Account')}}</a></li>
        <li><a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="fa fa-sign-out" aria-hidden="true"></i> {{__('Logout')}}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">{{ csrf_field() }}</form>
        </li>
    </ul>

</div>