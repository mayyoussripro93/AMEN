<div class="paypackages ">
    <!-- Start Latest Projects -->
    <div class="four-plan">

        @if(isset($projects))
            <div class="row page-sec">

                <h4 class="am-title green-color text-center"><i class="fa fa-building" aria-hidden="true"></i> {{__('Latest Projects')}}</h4>

                @foreach($projects AS $project)
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <ul class="boxes">
                            <li class="icon"><i class="fa fa-building-o" aria-hidden="true" style="color: #11AF4F;"></i>
                            </li>
                            <li class="plan-name">{{$project->name}}</li>
                            <li class="plan-pages">{{$project->state->state}}</li>
                            <li class="plan-pages">
                                <a href="{{route('project.detail',['id'=>Crypt::encryptString($project->id)])}}" class="btn btn-default"
                                   style="border: 1px solid #11AF4F;">{{__('View More')}}</a>
                            </li>
                        </ul>
                    </div>

                @endforeach
                @if(count($projects)>0)
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <a href="{{route('project.projects')}}" class="pull-left green-color"
                       style="margin: 35px 20px 0;"><strong>{{__('More...')}}</strong></a>
                </div>
                    @else
                    <div class="row page-sec">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h6 class="text-center"
                                style="color: #908f8f; margin-bottom: 0;">{{__('No Results!!')}}</h6>
                        </div>
                    </div>
                    @endif
            </div>
        @else
            <div class="row page-sec">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h6 class="text-center"
                        style="color: #908f8f; margin-bottom: 0;">{{__('No Results!!')}}</h6>
                </div>
            </div>
        @endif

    </div>
    <!-- End Latest Projects -->
</div>
