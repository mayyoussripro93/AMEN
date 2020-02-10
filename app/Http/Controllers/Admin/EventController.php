<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Project;
use Auth;
//use Calender\LaravelFullcalendar\Calendar;
use DB;
use Input;
use Redirect;
use App\Job;
use App\Company;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Controllers\Controller;
use App\Traits\JobTrait;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\CompanyMessage;
use App\Employee;
use App\Mail\CompanyContactMail;
use App\Mail\UserEventMail;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Carbon\Carbon;

use Validator;

use Mail;


class EventController extends Controller
{

    use JobTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth:employee');
    }

    public function indexEvent()
    {
        $appointments = Event::all();
        $event_list = [];
        foreach ($appointments as $key => $event) {
            $event_list[] = Calendar::event(
                $event->event_name,
                true,
                new \DateTime($event->start_date),
                new \DateTime($event->end_date.' +1 day'),
                null,
                // Add color and link on event
                [
                    'color' => 'green',
//                        'url' => 'pass here url and any route',
                ]
            );
        }

        $calendar_details = Calendar::addEvents($event_list)

            ->setCallbacks([
//                'themeSystem' => '"bootstrap4"',
            'eventRender' => 'function(event, element) {
                element.popover({
                  animation: true,
                  html: true,
                  content: $(element).html(),
                  trigger: "hover"
                  });
                }'
        ]);

        $query_project=Project::select('*');



        $projects= $query_project->pluck('name', 'id')->toArray();
        $i=0;
        foreach($appointments as $appointment){
            $appointments[$i]->description   =\Soundasleep\Html2Text::convert($appointment->description);

            $appointments[$i]->description=preg_replace( "/\r|\n/", " ",  $appointments[$i]->description  );
            $appointments[$i]->description=preg_replace( "/-/", ".",  $appointments[$i]->description  );
            $i++;
        }
        $employees=Employee::where('employee_role_id',2)->where('is_manager',1)->active()->pluck('name', 'id')->toArray();

        return view('admin.event.index', compact('appointments','calendar_details','projects','employees'));

    }
    public function createEvent()
    {
        $appointments = Event::all();
        $event_list = [];
        foreach ($appointments as $key => $event) {
            $event_list[] = Calendar::event(
                $event->event_name,
                true,
                new \DateTime($event->start_date),
                new \DateTime($event->end_date.' +1 day'),
                null,
                // Add color and link on event
                [
                    'color' => 'green',
//                        'url' => 'pass here url and any route',
                ]
            );
        }

        $calendar_details = Calendar::addEvents($event_list)

            ->setCallbacks([
//                'themeSystem' => '"bootstrap4"',
                'eventRender' => 'function(event, element) {
                element.popover({
                  animation: true,
                  html: true,
                  content: $(element).html(),
                  trigger: "hover"
                  });
                }'
            ]);

        $query_project=Project::select('*');


        $projects= $query_project->pluck('name', 'id')->toArray();

        $employees=Employee::where('employee_role_id',2)->where('is_manager',1)->active()->pluck('name', 'id')->toArray();
        return view('admin.event.add', compact('appointments','calendar_details','projects','employees'));

    }
    public function storeEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'event_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'consultant'=>'required'
        ], [
            'employee_id.required' => 'Select Employee required',
            'event_name.required' => 'Meeting Title required',
            'start_date.required' => 'Start Date required' ,
            'end_date.required' =>'End Date required',
            'consultant.required' => 'Select Project required',
        ]);

        if ($validator->fails()) {

            return \Illuminate\Support\Facades\Redirect::to('/admin/create-event')->withInput()->withErrors($validator);
        }


        $event = new Event;
        $event->employee_id =$request['employee_id'];
        $event->event_name = $request['event_name'];
        $event->start_date = $request['start_date'];
        $event->end_date = $request['end_date'];
        $event->project_id = $request['consultant'];
        $event->description = $request['description'];
        $event->save();
        $assignees=Project::findOrfail( $request['consultant'])->assignees()->where('employees.id','!=', 1)->get();
        $employee=Employee::where('id',$request['employee_id'])->first();

        foreach ($assignees as $assignee){

            $from_name = $employee->name;
            $from_email =  $employee->email;
            $from_phone = $employee->phone;
            $from_id = $request['employee_id'];
            $data['company_id'] = $from_id;
            $data['company_name'] = $from_name;
            $data['from_id'] = $from_id;
            $data['to_id'] = $assignee->id;
            $data['from_name'] = $from_name;
            $data['from_email'] = $from_email;
            $data['from_phone'] = $from_phone;
            $data['subject'] =  $request['event_name'];
            $data['message_txt'] = $request['description'];
            $data['to_email'] = $assignee->email;
            $data['to_name'] = $assignee->name;
            $data['is_event'] = 1;
            $data['project_id'] = $request['consultant'];
            $data['start_date'] = $request['start_date'];
            $data['end_date'] = $request['end_date'];
            $data['note']=__('A new appointment has been added');
            $msg_save = CompanyMessage::create($data);
            Mail::send(new UserEventMail($data));


        }
        $employee_admin=Employee::where('id',1)->first();
        $from_name = $employee_admin->name;
        $from_email =  $employee_admin->email;
        $from_phone = $employee_admin->phone;
        $from_id = $employee_admin->id;
        $data['company_id'] = $from_id;
        $data['company_name'] = $from_name;
        $data['from_id'] = $from_id;
        $data['to_id'] = $employee->id;
        $data['from_name'] = $from_name;
        $data['from_email'] = $from_email;
        $data['from_phone'] = $from_phone;
        $data['subject'] =  __('Appointment Officer :').$request['event_name'];
        $data['message_txt'] = __('You have been selected to be responsible for this appointment :').$request['description'];
        $data['to_email'] = $employee->email;
        $data['to_name'] = $employee->name;
        $data['is_event'] = 1;
        $data['project_id'] = $request['consultant'];
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['note']=__('A new appointment has been added');
        $msg_save = CompanyMessage::create($data);

        Mail::send(new UserEventMail($data));

        \Session::flash('success','Event added successfully');
        return Redirect::to('/admin/list-event');
    }


    public function updateEvent(Request $request)
    {

        $rules = array(
            'employee_id_edit' => 'required',
            'event_name_edit' => 'required',
            'project_name_edit' => 'required',
            'start_date' => 'required',
            'end_date'=>'required'
        );
        $rules_messages =  array(
            'employee_id_edit.required' =>'Select Employee required',
            'event_name_edit.required' =>'Meeting Title required',
            'start_date.required' => 'Start Date required' ,
            'end_date.required' => 'End Date required',
            'project_name_edit.required' => 'Select Project required',
        );

        $validation = Validator::make($request->all(), $rules, $rules_messages);

        if ($validation->fails()) {
            $msgresponse = $validation->messages();

            echo $msgresponse;
            exit;
        }
//        if ($validator->fails()) {
//
//            return Redirect::to('/events')->withInput()->withErrors($validator);
//        }

        $start = date( 'Y-m-d H:i:s', strtotime(($request->start_date)));
        $end = date( 'Y-m-d H:i:s', strtotime(($request->end_date)));
//
//        $request->start_date = $start;
//
//        $request->end_date = $end;
        $appointment = Event::findOrFail($request->appointment_id);

        $appointment->update([
            'employee_id'=> $request->employee_id_edit,
            'start_date' =>  $request->start_date,
            'end_date' =>    $request->end_date,
            'project_id' =>  $request->project_name_edit,
            'event_name' =>    $request->event_name_edit,
            'description' =>    $request->description_name_edit,
        ]);
        $employee=Employee::where('id',$request->employee_id_edit)->first();

        $assignees=Project::findOrfail($request->project_name_edit)->assignees()->where('employees.id','!=',1)->get();

        foreach ($assignees as $assignee) {

            $from_name = $employee->name;
            $from_email =  $employee->email;
            $from_phone = $employee->phone;
            $from_id =$request->employee_id_edit;
            $data['company_id'] = $from_id;
            $data['company_name'] = $from_name;
            $data['from_id'] = $from_id;
            $data['to_id'] = $assignee->id;
            $data['from_name'] = $from_name;
            $data['from_email'] = $from_email;
            $data['from_phone'] = $from_phone;
            $data['subject'] = $request->event_name_edit;
            $data['message_txt'] =  $request->description_name_edit;
            $data['to_email'] = $assignee->email;
            $data['to_name'] = $assignee->name;
            $data['is_event'] = 1;
            $data['project_id'] =  $request->consultant;
            $data['start_date'] =  $request->start_date;
            $data['end_date'] =  $request->end_date;
            $data['note']=__('A new appointment has been Updated');
            $msg_save = CompanyMessage::create($data);

            Mail::send(new UserEventMail($data));
        }
        $employee_admin=Employee::where('id',1)->first();
        $from_name = $employee_admin->name;
        $from_email =  $employee_admin->email;
        $from_phone = $employee_admin->phone;
        $from_id = $employee_admin->id;
        $data['company_id'] = $from_id;
        $data['company_name'] = $from_name;
        $data['from_id'] = $from_id;
        $data['to_id'] = $employee->id;
        $data['from_name'] = $from_name;
        $data['from_email'] = $from_email;
        $data['from_phone'] = $from_phone;
        $data['subject'] =  __('Appointment Officer :').$request->event_name_edit;
        $data['message_txt'] = __('You have been selected to be responsible for this appointment :'). $request->description_name_edit;
        $data['to_email'] = $employee->email;
        $data['to_name'] = $employee ->name;
        $data['is_event'] = 1;
        $data['project_id'] =  $request->consultant;
        $data['start_date'] =  $request->start_date;
        $data['end_date'] =  $request->end_date;
        $data['note']=__('A new appointment has been Updated');
        $msg_save = CompanyMessage::create($data);

        Mail::send(new UserEventMail($data));
//        return response()->json(['appointment' => $appointment]);
        return 'ok';
    }

    public function deleteEvent(Request $request)
    {

        try {
            $appointment = Event::findOrFail($request->appointment_id);
            $assignees=Project::findOrfail($appointment->project_id)->assignees()->where('employees.id','!=',$request->employee_id)->get();
            $employee=Employee::where('id',$request->employee_id)->first();
            $projectdetail=Project::where('id',$appointment->project_id)->first();
            foreach ($assignees as $assignee) {

                $from_name = $employee->name;
                $from_email =  $employee->email;
                $from_phone = $employee->phone;
                $from_id = $request['employee_id_edit'];

                $data['company_id'] = $from_id;
                $data['company_name'] = $from_name;
                $data['from_id'] = $from_id;
                $data['to_id'] = $assignee->id;
                $data['from_name'] = $from_name;
                $data['from_email'] = $from_email;
                $data['from_phone'] = $from_phone;
                $data['subject'] = __('Meeting is canceled').":".$appointment->event_name;
                $data['message_txt'] =$appointment->description;
                $data['to_email'] = $assignee->email;
                $data['to_name'] = $assignee->name;
                $data['is_event'] = 1;
                $data['project_id'] = $projectdetail->id;
                $data['start_date'] =  $request->start_date;
                $data['end_date'] =  $request->end_date;
                $msg_save = CompanyMessage::create($data);
                $data['note']=__('Your appointment has been canceled and you will be contacted shortly');
                Mail::send(new UserEventMail($data));
            }
            $appointment->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }

    }
    public function employeeProject(Request $request)
    {

        $employee_id= $request->input('employee_id');

        $project_id = $request->input('project_id');
        $assignees=Employee::where('id',$employee_id)->first();
        $project_assignees=Project::where('state_id','=',$assignees->state_id)->get();
  ;
        if (count($project_assignees )==0  ){
            $dd='<select   id="consultant"  name="consultant"   class="form-control " style="width: 100%"  required="true" >';

            $dd .='<option value=" "> '.__('NO Project').'</option></select>';

        }else{

            if (count($project_assignees ) !=0  ){
                $dd='<select  id="consultant"  name="consultant"  class="form-control " style="width: 100%"  required="true" >';
                foreach ($project_assignees as $project_assignee){
                    if($project_assignee['id']== $project_id)
                        $dd .='<option value="'.$project_assignee['id'].'"  selected  > '.$project_assignee['name'].'</option>';
                    else
                        $dd .='<option value="'.$project_assignee['id'].'"    > '.$project_assignee['name'].'</option>';
                }
            }


            $dd .='</select>'  ;
        }

        echo $dd;
    }

}
