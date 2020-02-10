<?php

namespace App\Http\Controllers\Admin;

use App\Job;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use ImgUploader;
use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;

use App\Country;
use App\State;
use App\City;
use App\EmployeeRole;
use App\Employee;
use App\EmployeeRelation;
use App\DeleteRequest;
use App\Package;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Traits\ProfileCvsTrait;
use App\Traits\ProfileEducationTrait;
use App\Helpers\DataArrayHelper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class EmployeeController extends Controller
{

    use ProfileCvsTrait;
    use ProfileEducationTrait;
    use SoftDeletes;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUsers()
    {
        $roles = EmployeeRole::select('role_name', 'id')->orderBy('role_name')->pluck('role_name', 'id')->toArray();
        for ($i=1;$i<=count($roles);$i++)
        {
            $roles[$i]=__($roles[$i]);
        }

        return view('admin.employee.index')
               ->with('roles',$roles)
            ;
    }

    public function indexDeletedUsers()
    {
        return view('admin.employee.deleted');
    }

    public function createUser()
    {
        $nationalities = DataArrayHelper::defaultNationalitiesArray();
        $countries = DataArrayHelper::langCountriesArray();
        $roles = EmployeeRole::select('role_name', 'id')->orderBy('role_name')->pluck('role_name', 'id')->toArray();
        for ($i=1;$i<=count($roles);$i++)
        {
            $roles[$i]=__($roles[$i]);
        }
//        $report_to= Employee::select('name', 'id')->where('is_active', 1)
//                                                  ->where('is_manager', 1)
//                                                  ->pluck('name', 'id')->toArray();

        return view('admin.employee.add')

                        ->with('nationalities', $nationalities)
                        ->with('countries', $countries)
                        ->with('roles', $roles)
//                        ->with('report_to', $report_to)
                        ->with('employee_report_to',null)
                        ->with('is_have_employee',0)
                        ->with('is_have_project',0)
            ;
            ;


    }

    public function storeUser(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:employees',
            'email' => 'required|string|email|max:255|unique:employees',
            'password' => 'required|string|min:6'
        ]);
        $user = new Employee();
        /*         * **************************************** */
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = ImgUploader::UploadImage('employee_images', $image, $request->input('name'), 300, 300, false);
            $user->image = $fileName;
        }
        /*         * ************************************** */
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if (!empty($request->input('password'))) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->date_of_birth = $request->input('date_of_birth');
        $user->nationality_id = $request->input('nationality_id');
        $user->national_id_card_number = $request->input('national_id_card_number');
        $user->country_id = $request->input('country_id');
        $user->state_id = $request->input('state_id');
        $user->city_id = $request->input('city_id');
        $user->phone = $request->input('phone');
        $user->mobile_num = $request->input('mobile_num');

        $user->street_address = $request->input('street_address');
        $user->employee_role_id=$request->input('employee_role_id');
        $user->is_manager=$request->input('is_manager');
        //$user->report_to=$request->input('report_to');
        $user->is_active = 1;
        $user->verified = 1;

        $user->save();

        $user->slug = str_slug($user->name, '-') . '-' . $user->id;
        $user->update();
        /*         * *********************** */
        $relation= New EmployeeRelation();
        $relation->employee_id=$request->input('report_to');
        $relation->employee_child_id=$user->id;
        $relation->save();
        /*         * *********************** */
        /*         * ************************************ */
        /*         * ************************************ */

        flash('Employee has been added!')->success();
     return \Redirect::route('list.employees', array($user->id));
    }

    public function editUser($id)
    {
        $nationalities = DataArrayHelper::defaultNationalitiesArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $roles = EmployeeRole::select('role_name', 'id')->orderBy('role_name')->pluck('role_name', 'id')->toArray();
        for ($i=1;$i<=count($roles);$i++)
        {
            $roles[$i]=__($roles[$i]);
        }
        $report_to= Employee::select('name', 'id')->where('is_active', 1)
                                                  ->where('is_manager', 1)
                                                  ->pluck('name', 'id')->toArray();

        $user = Employee::findOrFail($id);
        $employee_report_to=EmployeeRelation::select('employee_id')->where('employee_child_id', $id) ->pluck('employee_id')->toArray();
        //dd($employee_report_to);
        $is_have_employee=EmployeeRelation::where('employee_id','=',$id)->count();
        $is_have_project=Employee::find($id)->projects()->count();
        return view('admin.employee.edit')
            ->with('nationalities', $nationalities)
            ->with('countries', $countries)
            ->with('roles', $roles)
            ->with('report_to', $report_to)
            ->with('employee_report_to', $employee_report_to)
            ->with('user', $user)
            ->with('is_have_employee',$is_have_employee)
            ->with('is_have_project',$is_have_project)
    ;

    }

    public function updateUser($id, Request $request)
    {
        $user = Employee::find($id);
        /*         * **************************************** */
        $this->validate($request, [
            'name' => ['required','string','max:255','max:255',
                Rule::unique('employees')->ignore($user->id),
            ] ,
            'email' =>['required','string','max:255','email',
                Rule::unique('employees')->ignore($user->id),
                ]
        ]);

        /*         * **************************************** */
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = ImgUploader::UploadImage('employee_images', $image, $request->input('name'), 300, 300, false);
            $user->image = $fileName;
        }
        /*         * ************************************** */
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if (!empty($request->input('password'))) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->date_of_birth = $request->input('date_of_birth');
        $user->nationality_id = $request->input('nationality_id');
        $user->national_id_card_number = $request->input('national_id_card_number');
        $user->country_id = $request->input('country_id');
        $user->state_id = $request->input('state_id');
        $user->city_id = $request->input('city_id');
        $user->phone = $request->input('phone');
        //$user->mobile_num = $request->input('mobile_num');
        $user->street_address = $request->input('street_address');
        $user->employee_role_id=$request->input('employee_role_id');
        $user->is_manager=$request->input('is_manager');
        //$user->report_to=$request->input('report_to');
        $user->slug = str_slug($user->name, '-') . '-' . $user->id;
        $user->update();

        /*         * *********************** */
        if($request->input('report_to')!='')
        {
            EmployeeRelation::updateOrCreate(['employee_child_id' => $id,'employee_id'=>$request->input('report_to')]);
        }


        /*         * *********************** */
        /*         * ************************************ */
        /*         * ************************************ */

        flash('Employee has been Updated!')->success();
        return \Redirect::route('list.employees');

    }

    public function fetchUsersData(Request $request)
    {
        $users = Employee::select(
                        [
                            'employees.id',
                            'employees.name',
                            'employees.email',
                            'employees.password',
                            'employees.phone',
                            'employees.country_id',
                            'employees.state_id',
                            'employees.city_id',
                            'employees.is_active',
                            'employees.verified',
                            'employees.delete_request',
                            'employees.employee_role_id',
                            'employees.is_manager',
                            'employees.created_at',
                            'employees.updated_at'
        ]);
        return Datatables::of($users)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('employees.id', 'like', "{$request->get('id')}");
                            }
                            if ($request->has('name') && !empty($request->name)) {
                                $query->where(function($q) use ($request) {
                                    $q->where('employees.name', 'like', "%{$request->get('name')}%");
                                });
                            }
                            if ($request->has('email') && !empty($request->email)) {
                                $query->where('employees.email', 'like', "%{$request->get('email')}%");
                            }
                            if ($request->has('delete_request') && !empty($request->delete_request)) {
                                if($request->get('delete_request')=='yes')
                                $query->where('employees.delete_request', '=', $request->get('delete_request'));
                                else
                                $query->where('employees.delete_request', '=', '');
                            }
                            if ($request->has('employee_role_id') && !empty($request->employee_role_id)) {
                                    $query->where('employees.employee_role_id', '=', $request->get('employee_role_id'));

                            }
                        })
                        ->addColumn('name', function ($users) {
                            return $users->name ;
                        })
                        ->addColumn('employee_role_id', function ($users) {
                            return __($users->role->role_name);
                           })

                        ->addColumn('action', function ($users) {
                            /*                             * ************************* */
                            $active_txt = 'Make Active';
                            $active_href = 'make_active(' . $users->id . ');';
                            $active_icon = 'square-o';
                            if ((int) $users->is_active == 1) {
                                $active_txt = 'Make InActive';
                                $active_href = 'make_not_active(' . $users->id . ');';
                                $active_icon = 'check-square-o';
                            }
                            /*                             * ************************* */
                            /*                             * ************************* */
                            $verified_txt = 'Not Verified';
                            $verified_href = 'make_verified(' . $users->id . ');';
                            $verified_icon = 'square-o';
                            if ((int) $users->verified == 1) {
                                $verified_txt = 'Verified';
                                $verified_href = 'make_not_verified(' . $users->id . ');';
                                $verified_icon = 'check-square-o';
                            }
                           if(((int) $users->employee_role_id===1)|| ((int) $users->employee_role_id===2 && $users->is_manager===1))

                            {
                             $show_delete='';
                            }
                           else{
                             $show_delete= '<li><a href="javascript:void(0);" onclick="delete_employee(' . $users->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a></li>';
                               }
                            /*                             * ************************* */
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.employee', ['id' => $users->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>'
                        . $show_delete .
                       '<li>
						<a href="javascript:void(0);" onClick="' . $active_href . '" id="onclick_active_' . $users->id . '"><i class="fa fa-' . $active_icon . '" aria-hidden="true"></i>' . $active_txt . '</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $verified_href . '" id="onclick_verified_' . $users->id . '"><i class="fa fa-' . $verified_icon . '" aria-hidden="true"></i>' . $verified_txt . '</a>
						</li>																																							
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'name'])
                        ->setRowId(function($users) {
                            return 'user_dt_row_' . $users->id;
                        })
                        ->make(true);
    }

    public function fetchUsersDeletedData(Request $request)
    {
        $users = Employee::onlyTrashed()->select(
            [
                'employees.id',
                'employees.name',
                'employees.email',
                'employees.password',
                'employees.phone',
                'employees.country_id',
                'employees.state_id',
                'employees.city_id',
                'employees.is_active',
                'employees.verified',
                'employees.delete_request',
                'employees.created_at',
                'employees.updated_at'
            ]);
        return Datatables::of($users)
            ->filter(function ($query) use ($request) {
                if ($request->has('id') && !empty($request->id)) {
                    $query->where('employees.id', 'like', "{$request->get('id')}");
                }
                if ($request->has('name') && !empty($request->name)) {
                    $query->where(function($q) use ($request) {
                        $q->where('employees.name', 'like', "%{$request->get('name')}%");
                    });
                }
                if ($request->has('email') && !empty($request->email)) {
                    $query->where('employees.email', 'like', "%{$request->get('email')}%");
                }

            })
            ->addColumn('name', function ($users) {
                return $users->name ;
            })
            ->addColumn('action', function ($users) {

                /*                             * ************************* */
                return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false" onclick="restore_employee(' . $users->id . ');" >Restore</button>
				</div>';
            })
            ->rawColumns(['action', 'name'])
            ->setRowId(function($users) {
                return 'user_dt_row_' . $users->id;
            })
            ->make(true);
    }

    public function makeActiveUser(Request $request)
    {
        $id = $request->input('id');
        try {
            $user = Employee::findOrFail($id);
            $user->is_active = 1;
            $user->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveUser(Request $request)
    {
        $id = $request->input('id');
        try {
            $user = Employee::findOrFail($id);
            $user->is_active = 0;
            $user->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function deleteUser(Request $request)
    {
        $id = $request->input('id');
        try {
            $employees= EmployeeRelation::where('employee_id','=',$id)
                ->join('employees', 'employee_relations.employee_child_id', '=', 'employees.id')
                ->select('employees.email','employees.id')
                ->pluck('employees.id','employees.email')
                ->toArray()
//            ->get()
            ;

            $my_employees=Employee::where('id','=',$id)
                ->pluck('employees.id','employees.email')
                ->toArray();
            $employees=array_merge($employees, $my_employees);

            $employee_jobs_query=Employee::whereIn('id',array_values($employees))->withCount('jobs')->with('jobs');
            $employee_jobs=$employee_jobs_query->get();
            $employee_Count =Job::whereIn('company_id',array_values($employees))->get()->count();

            if($employee_Count== 0)
            {
                $emails = array_keys($employees);

                Mail::send('emails.employee.deleted-account', [], function($message) use ($emails)
                {
                    $message->to($emails)->subject(__('Amen Account Inquiry'));
                });
                $users = Employee::whereIn('id', array_values($employees))->delete();

                echo 'ok';

            }
            else{
                echo __("employees has associated jobs")."\n";

                foreach($employee_jobs as $persone)
                {
                    if($persone->jobs_count>0)
                    {
                        echo $persone->name."\n";
                    }

                }
            }

        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeRestoreUser(Request $request){
        $id = $request->input('id');
        try {
            $my_employees=Employee::withTrashed()->where('id','=',$id)
                ->pluck('employees.id','employees.email')
                ->toArray();
            $employees= EmployeeRelation::where('employee_id','=',$id)
                ->join('employees', 'employee_relations.employee_child_id', '=', 'employees.id')
                ->select('employees.email','employees.id')
                ->pluck('employees.id','employees.email')
                ->toArray();
            $employees=array_merge($employees, $my_employees);

            $emails = array_keys($employees);

            Mail::send('emails.employee.restore-account', [], function($message) use ($emails)
            {
                $message->to($emails)->subject(__('Amen Account Inquiry'));
            });
            $users = Employee::whereIn('id', array_values($employees))->restore();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }
    /*     * ******************************************** */
}
