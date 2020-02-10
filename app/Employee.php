<?php

namespace App;

use App\Traits\CountryStateCity;
use App\Traits\JobTrait;
use App\Traits\Lang;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\EmployeeResetPassword;
use Auth;
use App\EmployeeRelation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Employee extends Authenticatable
{
    //

    use SoftDeletes;
    use Notifiable;
    use Lang;
    use JobTrait;
    use CountryStateCity;
    protected $table = 'employees';

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'name', 'email', 'password',

    ];



    /**

     * The attributes that should be hidden for arrays.

     *

     * @var array

     */

    protected $hidden = [

        'password', 'remember_token',

    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function scopeActive($query)
    {
        return $query->where('is_active','=',1);
    }


    public function printUserImage($width = 0, $height = 0)
    {
        $image = (string) $this->image;
        $image = (!empty($image)) ? $image : 'no_image.jpg';
        return \ImgUploader::print_image("employee_images/$image", $width, $height, '/admin_assets/no_image.jpg', $this->getName());
    }

    public function getName()
    {
        $html = '';
        if (!empty($this->name))
            $html .= $this->name;

        return $html;
    }
    public function jobs()
    {
        return $this->hasMany('App\Job', 'company_id', 'id');
    }

    public function openJobs()
    {
        return Job::where('company_id', '=', $this->id)->notExpire();
    }

    public function getOpenJobs()
    {
        return $this->openJobs()->get();
    }

    public function countOpenJobs()
    {
        return $this->openJobs()->count();
    }
    public function printCompanyImage($width = 0, $height = 0)
    {
        $logo = (string) $this->image;
        $logo = (!empty($logo)) ? $logo : 'no_image.jpg';
        return \ImgUploader::print_image("employee_images/$logo", $width, $height, '/admin_assets/no_image.jpg', $this->name);
    }

    public function role()
    {
        return $this->belongsTo('App\EmployeeRole', 'employee_role_id','id');
    }

    public function followers()
    {
        return $this->hasMany('App\EmployeeRelation','employee_id','id');
    }



    public function projects()
    {
        $query_project=Project::select('*');

        if ($this->employee_role_id==1) {

        }
        elseif($this->employee_role_id==2){
            $query_project->where('state_id', $this->state_id);
        }
        else{

            $query_project=$this->belongsToMany('App\Project', 'projects_assigns', 'employee_id', 'project_id');

        }
       return $query_project;
       // return $this->belongsToMany('App\Project', 'projects_assigns', 'employee_id', 'project_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmployeeResetPassword($token));
    }

    public function getCachedMessgeCount()
    {
        return
            Cache::remember($this->id.'messages_count', 600, function() {
                return  \App\CompanyMessage::where('to_id','=', $this->id)->where('from_id','!=', $this->id)
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'desc')
                    ->count();
            });


    }
    public function getCachedEventsCount()
    {
        return
            \Cache::remember($this->id.'count_new_event', 600, function() {

                $projects_all=$this->projects()->get();
                $appointments = [];
//                dd($projects_all);
                foreach ($projects_all as $project){
                    $appointments[] = \App\Event::where('project_id',$project->id)->get();
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

                    };}
                return     $count_new_event;

            });


    }
    public function getCachedNewRegister()
    {
        return
            \Cache::remember($this->state_id.'newRegister', 600, function() {
                return Employee::where('verified','=',0)->where('state_id','=',$this->state_id)->count();
            });

    }
}
