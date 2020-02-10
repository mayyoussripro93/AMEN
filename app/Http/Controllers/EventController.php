<?php

namespace App\Http\Controllers;

use App\CompanyMessage;
use App\Employee;
use App\Mail\CompanyContactMail;
use App\Mail\UserEventMail;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Event;
use Mail;
use Calendar;
class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');

    }

    public function index(){
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
        $calendar_details = Calendar::addEvents($event_list)->setCallbacks([
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
//
//        return view('event.Event', compact('calendar_details') );

//        $appointments = Event::all();
        $query_project=Project::select('*');

        if (Auth::guard('employee')->user()->employee_role_id==1) {

        }
        elseif(Auth::guard('employee')->user()->employee_role_id==2){
            $query_project->where('state_id', Auth::guard('employee')->user()->state_id);
        }
        else{
            $query_project->join('projects_assigns', 'projects_assigns.project_id', '=', 'projects.id')
                ->select('projects.*', 'projects_assigns.employee_id')
                ->where('projects_assigns.employee_id', [Auth::guard('employee')->user()->id])
            ;
        }
        $projects= $query_project->pluck('name', 'id')->toArray();
        $i=0;
        foreach($appointments as $appointment){
            $appointments[$i]->description   =\Soundasleep\Html2Text::convert($appointment->description);

            $appointments[$i]->description=preg_replace( "/\r|\n/", " ",  $appointments[$i]->description  );

            $appointments[$i]->description=preg_replace( "/-/", ".",  $appointments[$i]->description  );
            $i++;
        }

        return view('event.Event', compact('appointments','calendar_details','projects'));
    }
    public function userIndex(){

        $query_project=Project::select('*');

        if (Auth::guard('employee')->user()->employee_role_id==1) {

        }
        elseif(Auth::guard('employee')->user()->employee_role_id==2){
            $query_project->where('state_id', Auth::guard('employee')->user()->state_id);
        }
        else{
            $query_project->join('projects_assigns', 'projects_assigns.project_id', '=', 'projects.id')
                ->select('projects.*', 'projects_assigns.employee_id')
                ->where('projects_assigns.employee_id', [Auth::guard('employee')->user()->id])
            ;
        }
        $projects=$query_project->get();
        $appointments = [];
        foreach ($projects as $project){
            $appointments[] = Event::where('project_id',$project->id)->get();

        }

        $event_list = [];
        $count_new_event=0;
        foreach ($appointments as $key => $event1) {
            foreach ($event1 as $key => $event) {
                $time_now=Carbon::now();
                $date_now= date( 'Y-m-d H:i:s', strtotime($time_now) );
                if($event->start_date >= $date_now){
                    $count_new_event++;
                }

////                dd($sum = array_sum($count_new_event));
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
        }

      ;
        $calendar_details = Calendar::addEvents($event_list)->setCallbacks([
            'themeSystem' => '"bootstrap4"',
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

        if (Auth::guard('employee')->user()->employee_role_id==1) {

        }
        elseif(Auth::guard('employee')->user()->employee_role_id==2){
            $query_project->where('state_id', Auth::guard('employee')->user()->state_id);
        }
        else{
            $query_project->join('projects_assigns', 'projects_assigns.project_id', '=', 'projects.id')
                ->select('projects.*', 'projects_assigns.employee_id')
                ->where('projects_assigns.employee_id', [Auth::guard('employee')->user()->id])
            ;
        }

        $projects= $query_project->pluck('name', 'id')->toArray();

        foreach($appointments as $appointment1){
            $i=0;
            foreach($appointment1 as $appointment){
                $appointment1[$i]->description   =\Soundasleep\Html2Text::convert($appointment->description);

                $appointment1[$i]->description=preg_replace( "/\r|\n/", " ",  $appointment1[$i]->description  );

                $appointment1[$i]->description=preg_replace( "/-/", ".",  $appointment1[$i]->description  );

                $i++;
            }
        }
        return view('event.Event_User', compact('appointments','calendar_details','projects'));
    }
    public function ajaxUpdate(Request $request)
    {

            $rules = array(
            'event_name_edit' => 'required',
            'project_name_edit' => 'required',
            'start_date' => 'required',
            'end_date'=>'required'
    );
        $rules_messages =  array(
            'event_name_edit.required' => __('Meeting Title required'),
            'start_date.required' => __('Start Date required') ,
            'end_date.required' => __( 'End Date required'),
            'project_name_edit.required' => __( 'Select Project required'),
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
            'start_date' =>  $request->start_date,
            'end_date' =>    $request->end_date,
            'project_id' =>  $request->project_name_edit,
            'event_name' =>    $request->event_name_edit,
            'description' =>    $request->description_name_edit,
        ]);

        $assignees=Project::findOrfail($request->project_name_edit)->assignees()->where('employees.id','!=', Auth::guard('employee')->user()->id)->get();

        foreach ($assignees as $assignee) {


            $from_name = Auth::guard('employee')->user()->name;
            $from_email = Auth::guard('employee')->user()->email;
            $from_phone = Auth::guard('employee')->user()->phone;
            $from_id = Auth::guard('employee')->user()->id;
            $data['company_id'] = $from_id;
            $data['company_name'] = $from_name;
            $data['from_id'] = $from_id;
            $data['to_id'] = $assignee->id;
            $data['from_name'] = $from_name;
            $data['from_email'] = $from_email;
            $data['from_phone'] = $from_phone;
            $data['subject'] = $request->event_name_edit;
            $data['message_txt'] = $request->description_name_edit;
            $data['to_email'] = $assignee->email;
            $data['to_name'] = $assignee->name;
            $data['is_event'] = 1;
            $data['project_id'] = $request->project_name_edit;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $data['note']=__('A new appointment has been Updated');
            $msg_save = CompanyMessage::create($data);

            Mail::send(new UserEventMail($data));
        }
//        return response()->json(['appointment' => $appointment]);
        return 'ok';
    }

    public function ajaxDelete(Request $request)
    {

        try {
            $appointment = Event::findOrFail($request->appointment_id);
            $projectdetail=Project::where('id',$appointment->project_id)->first();
            $assignees=Project::findOrfail($appointment->project_id)->assignees()->where('employees.id','!=', Auth::guard('employee')->user()->id)->get();
            foreach ($assignees as $assignee) {


                $from_name = Auth::guard('employee')->user()->name;
                $from_email = Auth::guard('employee')->user()->email;
                $from_phone = Auth::guard('employee')->user()->phone;
                $from_id = Auth::guard('employee')->user()->id;
                $data['company_id'] = $from_id;
                $data['company_name'] = $from_name;
                $data['from_id'] = $from_id;
                $data['to_id'] = $assignee->id;
                $data['from_name'] = $from_name;
                $data['from_email'] = $from_email;
                $data['from_phone'] = $from_phone;
                $data['subject'] = $appointment->event_name;
                $data['message_txt'] =$appointment->description;
                $data['to_email'] = $assignee->email;
                $data['to_name'] = $assignee->name;
                $data['is_event'] = 1;
                $data['project_id'] = $projectdetail->id;
                $data['start_date'] =$request->start_date ;
                $data['end_date'] =$request->end_date ;
                $data['note']=__('Your appointment has been canceled and you will be contacted shortly');
                $msg_save = CompanyMessage::create($data);
                Mail::send(new UserEventMail($data));
            }
            $appointment->delete();

            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }

    }
    public function addEvent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'event_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'consultant'=>'required'
        ], [
            'event_name.required' => __('Meeting Title required'),
            'start_date.required' => __('Start Date required') ,
            'end_date.required' => __( 'End Date required'),
            'consultant.required' => __( 'Select Project required'),
        ]);

        if ($validator->fails()) {

            return Redirect::to('/events')->withInput()->withErrors($validator);
        }

        $event = new Event;
        $event->employee_id = Auth::guard('employee')->user()->id;
        $event->event_name = $request['event_name'];
        $event->start_date = $request['start_date'];
        $event->end_date = $request['end_date'];
        $event->project_id = $request['consultant'];
        $event->description = $request['description'];
        $event->save();
        $assignees=Project::findOrfail( $request['consultant'])->assignees()->where('employees.id','!=', Auth::guard('employee')->user()->id)->get();

        foreach ($assignees as $assignee){


        $from_name =  Auth::guard('employee')->user()->name;
        $from_email =  Auth::guard('employee')->user()->email;
        $from_phone =  Auth::guard('employee')->user()->phone;
        $from_id =  Auth::guard('employee')->user()->id;
        $data['company_id'] = $from_id;
        $data['company_name'] = $from_name;
        $data['from_id'] = $from_id;
        $data['to_id'] = $assignee->id;
        $data['from_name'] = $from_name;
        $data['from_email'] = $from_email;
        $data['from_phone'] = $from_phone;
        $data['subject'] = $request->event_name ;
        $data['message_txt'] =$request->description ;
        $data['to_email'] = $assignee->email;
        $data['to_name'] = $assignee->name;
        $data['is_event'] = 1;
        $data['project_id'] = $request->consultant ;
        $data['start_date'] = $request->start_date;
        $data['end_date'] =$request->end_date ;
        $data['note']=__('A new appointment has been added');
        $msg_save = CompanyMessage::create($data);

        Mail::send(new UserEventMail($data));

        }
            \Session::flash('success',__('Event added successfully.'));
            return Redirect::to('/events_create');
        }

}
