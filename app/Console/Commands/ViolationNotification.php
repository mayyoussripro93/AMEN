<?php

namespace App\Console\Commands;

use App\CompanyMessage;
use App\Event;
use App\Mail\UserEventMail;
use App\ViolationHistory;
use Illuminate\Console\Command;
use App\Violation;
use App\Project;
use App\Employee;
use Carbon\Carbon;
use Mail;
use App\Mail\ViolationNotificationMail;


class ViolationNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'violation:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends notifications emails to assignees about violations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
     $violations=Violation::with('project.assignees')->where('objection_status','!=','1')->whereDate('removement_duration','=',Carbon::tomorrow())->get();

        foreach($violations as $violation)
        {
            unset($emails);
            $emails=array();
            foreach($violation->project->assignees as $one)
            {
               $emails[]=$one->email;
            }
           Mail::to($emails)->send(new ViolationNotificationMail(['violation'=>$violation,'status_message'=>__('Violation Removement Date Notification'),'type'=>'violation']));
        }
        $violationhistorys=ViolationHistory::with('project.assignees','violation')->whereDate('removement_duration','=',Carbon::tomorrow())->get();
        foreach($violationhistorys as $violationhistory)
        {
            unset($emails);
            $emails=array();
            if($violationhistory->violation->objection_status != '1')
            {
                foreach($violationhistory->project->assignees as $one)
                {
                    $emails[]=$one->email;
                }
                Mail::to($emails)->send(new ViolationNotificationMail(['violation'=>$violationhistory->violation,'status_message'=>__('Violation Confirmation Removement Date Notification'),'type'=>'confirm']));

            }
        }
        $appointments = Event::whereDate('events.start_date','=',date('Y-m-d'))->get();

        foreach($appointments as $appointment)
        {
            $assignees=Project::findOrfail( $appointment->project_id)->assignees()->get();

            foreach ($assignees as $assignee){

                $employee = Employee::where('id',$appointment->employee_id)->first();
                $from_name =  $employee->name;
                $from_email = $employee->email;
                $from_phone =  $employee->phone;
                $from_id =  $employee->id;
                $data['company_id'] = $from_id;
                $data['company_name'] = $from_name;
                $data['from_id'] = $from_id;
                $data['to_id'] = $assignee->id;
                $data['from_name'] = $from_name;
                $data['from_email'] = $from_email;
                $data['from_phone'] = $from_phone;
                $data['subject'] = __('Reminder').":".$appointment->event_name;
                $data['message_txt'] = $appointment->description;
                $data['to_email'] = $assignee->email;
                $data['to_name'] = $assignee->name;
                $data['is_event'] = 1;
                $data['project_id'] =$appointment->project_id;
                $data['start_date'] =$appointment->start_date ;
                $data['end_date'] =$appointment->end_date ;

                $msg_save = CompanyMessage::create($data);
                Mail::send(new UserEventMail($data));


            }
        }



    }
}
