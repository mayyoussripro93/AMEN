<li class="nav-item  "> <a href="javascript:;" class="nav-link nav-toggle"> <i class="icon-briefcase"></i> <span class="title">{{__('The Initiatives')}}</span> <span class="arrow"></span> </a>
    <ul class="sub-menu">
        <li class="nav-item  "> <a href="javascript:;" class="nav-link nav-toggle"> <i class="fa fa-black-tie"></i> <span class="title">{{__('Recruiting')}}</span> <span class="arrow"></span> </a>
            <ul class="sub-menu">
                <li class="nav-item  "> <a href="{{ route('list.jobs') }}" class="nav-link "> <span class="title">{{__('List Jobs')}}</span> </a> </li>
                <li class="nav-item  "> <a href="{{ route('create.job') }}" class="nav-link "> <span class="title">{{__('Add new Job')}}</span> </a> </li>
            </ul>

        </li>
        <li class="nav-item  "> <a href="javascript:;" class="nav-link nav-toggle"> <i class="fa fa-graduation-cap"></i> <span class="title">{{__('Education')}}</span> <span class="arrow"></span> </a>
            <ul class="sub-menu">
                <li class="nav-item  "> <a href="{{url('admin/list-initiatives')."?Initiatives_type=Learning"}}" class="nav-link "> <span class="title">{{__('List Education')}}</span> </a> </li>
                <li class="nav-item  "> <a href="{{url('admin/create-initiatives')."?Initiatives_type=Learning"}}" class="nav-link "> <span class="title">{{__('Add new Education')}}</span> </a> </li>
            </ul>

        </li>
        <li class="nav-item  "> <a href="javascript:;" class="nav-link nav-toggle"> <i class="fa fa-cogs"></i> <span class="title">{{__('Training')}}</span> <span class="arrow"></span> </a>
            <ul class="sub-menu">
                <li class="nav-item  "> <a href="{{url('admin/list-initiatives')."?Initiatives_type=Training"}}" class="nav-link "> <span class="title">{{__('List Training')}}</span> </a> </li>
                <li class="nav-item  "> <a href="{{url('admin/create-initiatives')."?Initiatives_type=Training"}}" class="nav-link "> <span class="title">{{__('Add new Training')}}</span> </a> </li>
            </ul>

        </li>
    </ul>
</li>