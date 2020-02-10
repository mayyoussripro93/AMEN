<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Project;
use App\State;
use App\User;
use App\Job;
use App\Violation;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::join('employees', 'employees.state_id', '=', 'states.state_id')
            ->select('states.state_id')
            ->where('employees.employee_role_id','=',2)
            ->where('states.country_id', '=', 191)
            ->isDefault()->count();
        $projects=Project::all()->count();
        $managers=Employee::where('is_manager',1)->where('is_active',1)->whereIn('employee_role_id',[3,4,5])->count();
        $employees=Employee::where('is_manager','!=',1)->where('is_active',1)->whereIn('employee_role_id',[3,4,5])->count();
        $violations=Violation::where('objection_status','!=','1')->count();
        $jobs=Job::where('is_active', 1)->count();
        $recentJobs = Job::orderBy('id', 'DESC')->take(25)->get();
        return view('admin.home')
                        ->with('states', $states)
                        ->with('projects', $projects)
                        ->with('managers', $managers)
                        ->with('employees', $employees)
                        ->with('violations', $violations)
                        ->with('jobs', $jobs)
                        ->with('recentJobs', $recentJobs)
            ;
    }

}
