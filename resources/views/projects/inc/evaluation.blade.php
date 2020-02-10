<style>
    th, th, td {
        font-size: 12px;
    }
    th {
        font-weight: bold;
        color: #17ad68;
    }
</style>
<table width="100%" class="table table-bordered table-hover">
    <tr align="center" style="background-color: #f9f9f9;">
        <th width="20%">{{__('Name')}}</th>
        <th width="16%">{{__('Performance And Achievement')}}</th>
        <th width="16%">{{__('Initiative And Invention')}}</th>
        <th width="16%">{{__('Collaboration And Career Commitment')}}</th>
        <th width="16%">{{__('Participation And Responsibility')}}</th>
        <th width="16%">{{__('Supervisory Skills')}}</th>
    </tr>
    @if($contractor_managers_count>0)<tr><td align="center" colspan="6"><strong>{{__('Contractor')}}</strong></td></tr>@endif

    @foreach($contractor_managers as $contractor_manager)
    <tr style="background-color: #f9f9f9;">
        <td nowrap="">{{$contractor_manager->name}} <input type="hidden" value="{{$contractor_manager->id}}" name="ids[]"></td>
        <td><input type="number" min="0" max="10" class="form-control" name="performance{{$contractor_manager->id}}" value="{{$evaluation[$contractor_manager->id]->performance or ''}}"></td>
        <td><input type="number" min="0" max="10" class="form-control" name="initiative{{$contractor_manager->id}}"value="{{$evaluation[$contractor_manager->id]->initiative or ''}}"></td>
        <td><input type="number" min="0" max="10" class="form-control" name="collaboration{{$contractor_manager->id}}"value="{{$evaluation[$contractor_manager->id]->collaboration or ''}}"></td>
        <td><input type="number" min="0" max="10" class="form-control" name="participation{{$contractor_manager->id}}"value="{{$evaluation[$contractor_manager->id]->participation or ''}}"></td>
        <td><input type="number" min="0" max="10" class="form-control" name="supervisory{{$contractor_manager->id}}"value="{{$evaluation[$contractor_manager->id]->supervisory or ''}}"></td>
    </tr>
    @endforeach
    @if($safety_managers_count>0) <tr><td  align="center" colspan="6"><strong>{{__('Safety_consultant')}}</strong></td></tr>@endif
    @foreach( $safety_managers as  $safety_manager)
        <tr style="background-color: #f9f9f9;">
            <td nowrap="">{{$safety_manager->name}} <input type="hidden" value="{{$safety_manager->id}}" name="ids[]"></td>
            <td><input type="number" min="0" max="10" class="form-control" name="performance{{$safety_manager->id}}" value="{{$evaluation[$safety_manager->id]->performance or ''}}"></td>
            <td><input type="number" min="0" max="10" class="form-control" name="initiative{{$safety_manager->id}}"value="{{$evaluation[$safety_manager->id]->initiative or ''}}"></td>
            <td><input type="number" min="0" max="10" class="form-control" name="collaboration{{$safety_manager->id}}"value="{{$evaluation[$safety_manager->id]->collaboration or ''}}"></td>
            <td><input type="number" min="0" max="10" class="form-control" name="participation{{$safety_manager->id}}"value="{{$evaluation[$safety_manager->id]->participation or ''}}"></td>
            <td><input type="number" min="0" max="10" class="form-control" name="supervisory{{$safety_manager->id}}"value="{{$evaluation[$safety_manager->id]->supervisory or ''}}"></td>
        </tr>
    @endforeach
   @if($project_managers_count>0) <tr><td  align="center" colspan="6"><strong>{{__('Project_consultant')}}</strong></td></tr>@endif
    @foreach($project_managers as $project_manager)
        <tr style="background-color: #f9f9f9;">
            <td nowrap="">{{$project_manager->name}} <input type="hidden" value="{{$project_manager->id}}" name="ids[]"></td>
            <td><input type="number" min="0" max="10" class="form-control" name="performance{{$project_manager->id}}"value="{{$evaluation[$project_manager->id]->performance or ''}}"></td>
            <td><input type="number" min="0" max="10" class="form-control" name="initiative{{$project_manager->id}}"value="{{$evaluation[$project_manager->id]->initiative or ''}}"></td>
            <td><input type="number" min="0" max="10" class="form-control" name="collaboration{{$project_manager->id}}"value="{{$evaluation[$project_manager->id]->collaboration or ''}}"></td>
            <td><input type="number" min="0" max="10" class="form-control" name="participation{{$project_manager->id}}"value="{{$evaluation[$project_manager->id]->participation or ''}}"></td>
            <td><input type="number" min="0" max="10" class="form-control" name="supervisory{{$project_manager->id}}"value="{{$evaluation[$project_manager->id]->supervisory or ''}}"></td>
        </tr>
    @endforeach
</table>