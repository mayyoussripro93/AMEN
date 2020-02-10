<ul class="row profilestat page-sec">
    <li class="col-md-2 col-sm-3 col-xs-4">
        <a href="{{route('project.projects')}}" class="stats-link"><div class="inbox"> <i class="fa fa-folder-open-o" aria-hidden="true"></i>
            <h6>{{$projects_count}}</h6>
            <strong>{{__('Project')}}</strong></div></a>
    </li>
    @can('is_manager')
        <li class="col-md-2 col-sm-3 col-xs-4">
            <a href="{{route('employee.employees')}}" class="stats-link"><div class="inbox"> <i class="fa fa-user-o" aria-hidden="true"></i>
                <h6>{{$employee_count}}</h6>
                <strong>{{__('Employee')}}</strong> </div></a>
        </li>
    @endcan

    <li class="col-md-2 col-sm-3 col-xs-4">
        <a href="{{route('employee.messages')}}" class="stats-link"><div class="inbox"> <i class="fa fa-envelope-o" aria-hidden="true"></i>
            <h6>{{$messages_count}} </h6>
            <strong>{{__('message')}}</strong> </div></a>
    </li>

    <li class="col-md-2 col-sm-3 col-xs-4">
        <a href="{{route('events.user.index')}}" class="stats-link"><div class="inbox"> <i class="fa fa-calendar" aria-hidden="true"></i>
            <h6> {{$count_new_event}}</h6>
            <strong>{{__('Event')}}</strong> </div></a>
    </li>
    @can('amen-employee')
        <li class="col-md-2 col-sm-3 col-xs-4">
            <a href="{{route('employee.evaluation')}}" class="stats-link"><div class="inbox"> <i class="fa fa-list-ol" aria-hidden="true"></i>
                <h6>{{$evaluation_count}}</h6>
                <strong>{{__('evaluation')}}</strong> </div></a>
        </li>
    @endcan
{{--    <li class="col-md-2 col-sm-4 col-xs-6">--}}
{{--        <div class="inbox"> <i class="fa fa-wrench" aria-hidden="true"></i>--}}
{{--            <h6><a href="{{route('report.abuse.company')}}"></a></h6>--}}
{{--            <strong>{{__('Problem')}}</strong> </div>--}}
{{--    </li>--}}
</ul>