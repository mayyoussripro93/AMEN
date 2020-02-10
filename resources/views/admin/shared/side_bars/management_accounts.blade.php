@if(APAuthHelp::check(['SUP_ADM']))
<li class="heading">
    <h3 class="uppercase">{{__('Management Accounts')}}</h3>
</li>
<li class="nav-item  "> <a href="javascript:;" class="nav-link nav-toggle"> <i class="icon-user"></i> <span class="title">{{__('Management Accounts')}}</span> <span class="arrow"></span> </a>
    <ul class="sub-menu">
        <li class="nav-item  "> <a href="{{ route('list.employees') }}" class="nav-link"> <i class="icon-user"></i> <span class="title">{{__('List Management  Accounts')}}</span> </a> </li>
        <li class="nav-item  "> <a href="{{ route('create.employee') }}" class="nav-link"> <i class="icon-user"></i> <span class="title">{{__('Add new Management  Account')}}</span> </a> </li>
        <li class="nav-item  "> <a href="{{ route('list.employees.deleted') }}" class="nav-link"> <i class="icon-user"></i> <span class="title">{{__('Restore Deleted Management Accounts')}}</span> </a> </li>

    </ul>
</li>
@endif