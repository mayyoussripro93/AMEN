<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DangerCategories;
use App\Mail\ViolationNotificationMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\City;
use App\Comment;
use App\Helpers\DataArrayHelper;
use App\Objection;
use App\ProjectUpload;
use App\State;
use App\Project;
use App\ProjectAssign;
use App\Violation;
use App\ViolationHistory;
use App\ViolationUploads;
use App\EmployeeEvaluation;
use Illuminate\Http\Request;
use App\EmployeeRole;
use App\Employee;
use App\EmployeeRelation;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;
use Validator;
use ImgUploader;
use Redirect;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Mail;
use Form;
use App\Traits\CommonProjectFunctions;

class ProjectController extends Controller
{
    use CommonProjectFunctions;

    public function indexProjects()
    {
        $states = State::join('employees', 'employees.state_id', '=', 'states.state_id')
            ->select('states.state', 'states.state_id')
            ->where('employees.employee_role_id','=',2)
            ->where('states.country_id', '=', 191)
            ->isDefault()->sorted()->pluck('states.state', 'states.state_id')->toArray();

        return view('admin.project.index')
                ->with('states',$states)
            ;
    }

    public function fetchProjectsData(Request $request){
        $projects= Project::select(
                [
                    'projects.id',
                    'projects.name',
                    'projects.date_gregorian',
                    'projects.code',
                    'projects.state_id',
                    'projects.city_id',
                    'projects.is_active',
                    'projects.created_at',
                    'projects.updated_at'
                ]);
        return Datatables::of($projects)
            ->filter(function ($query) use ($request) {
                if ($request->has('id') && !empty($request->id)) {
                    $query->where('projects.id', 'like', "{$request->get('id')}");
                }
                if ($request->has('name') && !empty($request->name)) {
                    $query->where('projects.name', 'like', "%{$request->get('name')}%");
                }

                if ($request->has('start_date') && !empty($request->start_date)) {

                    $query->whereBetween('projects.date_gregorian',  explode(' - ',$request->start_date));
                }

                if ($request->has('state_id') && !empty($request->state_id)) {
                    $query->where(function($q) use ($request) {
                        $q->where('projects.state_id', '=', $request->get('state_id'));
                    });
                }
                if ($request->has('city_id') && !empty($request->city_id)) {
                    $query->where(function($q) use ($request) {
                        $q->where('projects.city_id', '=', $request->get('city_id'));
                    });
                }
                if ($request->has('is_active') && $request->is_active!='') {

                    $query->where('projects.is_active', '=', $request->get('is_active'));
                }


            })
            ->addColumn('date_gregorian', function ($projects) {
                return '<p class="text-display">'.\Arabic\Arabic::adate(' j F Y ', strtotime($projects->date_gregorian)).'</p>';
            })
            ->addColumn('name', function ($projects) {
                return '<p class="text-display">'.$projects->name.'</p>';
            })
            ->addColumn('state', function ($projects) {
                return $projects->state->state;
            })
            ->addColumn('city', function ($projects) {
               return $projects->city->city;
            })
            ->addColumn('is_active', function ($projects) {
                $p_status= $projects->is_active==1 ? "Work On":"Completed";
                return __($p_status) ;
            })

            ->addColumn('action', function ($projects) {
                return '
				<div class="btn-group">
					<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
					    <li>
							<a href="' . route('edit.project',['id' => $projects->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>تعديل</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteProject('. $projects->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>حذف</a>
						</li>
						<li>
							<a href="' . route('list.violations',['project_id' => $projects->id]) . '" target="_blank"><i class="fa fa-list" aria-hidden="true"></i>قائمة المخالفات</a>
						</li>
					    <li>
							<a href="' . route('create.violation',['project_id' => $projects->id]) . '" target="_blank"><i class="fa fa-list" aria-hidden="true"></i>إضافة مخالفة</a>
						</li>
						 <li>
							<a href="' . route('list.Evaluations',['project_id' => $projects->id]) . '" target="_blank"><i class="fa fa-list" aria-hidden="true"></i>التقييمات</a>
						</li>
						 <li>
							<a href="' . route('list.studies',['project_id' => $projects->id]) . '" target="_blank"><i class="fa fa-list" aria-hidden="true"></i>قائمة الدراسات</a>
						</li>
						 <li>
							<a href="' . route('add.studies',['project_id' => $projects->id]) . '" target="_blank"><i class="fa fa-list" aria-hidden="true"></i>إضافة دراسة</a>
						</li>
						
				</ul>
				</div>';
            })
            ->rawColumns(['is_active','action','name','date_gregorian'])
            ->setRowId(function($projects) {
                return  'projectDtRow'.$projects->id;
            })
            ->make(true);
        // dd($projects);
    }

    public function fetchStateEmployee(Request $request){
        $state_id=$request->input('state_id');
        $projectconsultant = Employee::where('is_manager','=',1)->where('employee_role_id','=',4)->where('state_id','=',$state_id)->active()->pluck('name', 'id')->toArray();
        $projectsafety = Employee::where('is_manager','=',1)->where('employee_role_id','=',3)->where('state_id','=',$state_id)->active()->pluck('name', 'id')->toArray();
        $projectcontractor = Employee::where('is_manager','=',1)->where('employee_role_id','=',5)->where('state_id','=',$state_id)->active()->pluck('name', 'id')->toArray();

        $projectcontractor_str="<select name='contractor[]' class='form-control select5-multiple' multiple='multiple'>";
        foreach ($projectcontractor as $key=>$value )
        {
            $projectcontractor_str.="<option value='$key'>$value</option>";
        }
        $projectcontractor_str.="</select>";
        $data['projectcontractor']=$projectcontractor_str;

        $projectconsultant_str="<select name='consultant[]' class='form-control select4-multiple' multiple='multiple'>";
        foreach ($projectconsultant as $key=>$value )
        {
            $projectconsultant_str.="<option value='$key'>$value</option>";
        }
        $projectconsultant_str.="</select>";
        $data['projectconsultant']=$projectconsultant_str;

        $projectsafety_str="<select name='safety[]' class='form-control select3-multiple' multiple='multiple'>";
        foreach ($projectsafety as $key=>$value )
        {
            $projectsafety_str.="<option value='$key'>$value</option>";
        }
        $projectsafety_str.="</select>";
        $data['projectsafety']=$projectsafety_str;
        echo json_encode($data);

    }

    public function createProject()
    {
        $states = State::join('employees', 'employees.state_id', '=', 'states.state_id')
            ->select('states.state', 'states.state_id')
            ->where('employees.employee_role_id','=',2)
            ->where('states.country_id', '=', 191)
            ->isDefault()->sorted()->pluck('states.state', 'states.state_id')->toArray();

        $projectconsultant = array();
        $consultantIds = array();
        $projectsafety = array();
        $safetyIds = array();
        $projectcontractor = array();
        $contractorIds = array();
        return view('admin.project.add')
            ->with('projectconsultant',$projectconsultant)
            ->with('consultantIds',$consultantIds)
            ->with('projectsafety',$projectsafety)
            ->with('safetyIds',$safetyIds)
            ->with('projectcontractor',$projectcontractor)
            ->with('contractorIds',$contractorIds)
            ->with('states',$states)
            ;
    }

    public function storeProject(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:projects',
            'owner' => 'required|string|max:255',
            'state_id' => 'required',
            'city_id' => 'required',
            'description'=>'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            //
            return Redirect::back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            $project=new Project();
//        /*         ***************************************** */
            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $fileName = ImgUploader::UploadImage('amen_project/logo', $image, $request->input('name'), 100, 100, false);

                $project->logo = $fileName;
            }
            /*         *************************************** */
            $project->employee_id = 1;
            $project->state_id =$request->input('state_id');
            $project->city_id =$request->input('city_id');
            $project->name = $request->input('name');
            $project->owner =$request->input('owner');
            $project->code=0;
            $project->description = $request->input('description');
            $project->date_gregorian = $request->input('date_gregorian') ? $request->input('date_gregorian'):date('y-m-d') ;
          //  $project->date_gregorian_txt = $request->input('date_gregorian_txt');
            $project->address = $request->input('location');
            $project->project_type = $request->input('project_type');
            $project->latitude = $request->input('latitude');
            $project->longitude = $request->input('longitude');
            $project->end_date = $request->input('end_date');
            $project->Traffic_Accidents = $request->input('Traffic_Accidents');
            $project->Injuries = $request->input('Injuries');
            $project->Fire = $request->input('Fire');
            $project->Deaths = $request->input('Deaths');
            $project->is_active = 1;

            $project->save();
            $project->code =$this->GenerateProjectCode(3) .' - '.$project->id ;
            $project->update();

            $safety_arr=!empty($request->input('safety')) ? $request->input('safety'): array();
            $consultant_arr=!empty($request->input('consultant')) ? $request->input('consultant'): array();
            $contractor_arr=!empty($request->input('contractor')) ? $request->input('contractor'): array();

            $head_employee=array_merge($safety_arr, $consultant_arr,$contractor_arr);
            $this->ProjectAssignEmployee($head_employee,$project->id);
            DB::commit();
            flash(__('Project has been Created'))->success();
            return Redirect::route('list.projects');
        }
        catch(\Exception $e){
            DB::rollback();
            flash(__('Something Went Wrong'))->error();
        }

    }

    public function editProject($id){

        $project=Project::findOrfail($id);
        //dd($project);
        $assignees=Project::findOrfail($id)->assignees()->get();
        $projectconsultant = Employee::where('is_manager','=',1)->where('employee_role_id','=',4)->where('state_id','=',$project->state_id)->active()->pluck('name', 'id')->toArray();
        $consultantIds = $assignees->where('is_manager',1)->where('employee_role_id',4);
        $projectsafety = Employee::where('is_manager','=',1)->where('employee_role_id','=',3)->where('state_id','=',$project->state_id)->active()->pluck('name', 'id')->toArray();
        $safetyIds = $assignees->where('is_manager',1)->where('employee_role_id',3);
        $projectcontractor = Employee::where('is_manager','=',1)->where('employee_role_id','=',5)->where('state_id','=',$project->state_id)->active()->pluck('name', 'id')->toArray();
        $contractorIds = $assignees->where('is_manager',1)->where('employee_role_id',5);
        $states = State::join('employees', 'employees.state_id', '=', 'states.state_id')
            ->select('states.state', 'states.state_id')
            ->where('employees.employee_role_id','=',2)
            ->where('states.country_id', '=', 191)
            ->isDefault()->sorted()->pluck('states.state', 'states.state_id')->toArray();
        return view('admin.project.edit')
            ->with('project',$project)
            ->with('projectconsultant',$projectconsultant)
            ->with('consultantIds',$consultantIds)
            ->with('projectsafety',$projectsafety)
            ->with('safetyIds',$safetyIds)
            ->with('projectcontractor',$projectcontractor)
            ->with('contractorIds',$contractorIds)
            ->with('states',$states)
            ;
    }

    public function updateProject(Request $request){
        $id=$request->input('id');
        $project=Project::find($request->input('id'));

        $validator = Validator::make($request->all(), [
            'name' => [
                'required','max:255',
                Rule::unique('projects')->ignore($project->id),
            ],
            'owner' => 'required|string|max:255',
            'description'=>'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            //
            return Redirect::back()->withErrors($validator)->withInput();
        }


//        /*         ***************************************** */
        if ($request->hasFile('logo')) {
            $image = $project->logo;
            if (!empty($image)) {
                \Storage::disk('s3')->delete('amen_project/logo' . $image);
                // File::delete(ImgUploader::real_public_path() . 'amen_project/logo' . $image);
            }
            $image = $request->file('logo');
            $fileName = ImgUploader::UploadImage('amen_project/logo', $image, $request->input('name'), 100, 100, false);

            $project->logo = $fileName;
        }
        /*         *************************************** */
//        $project->employee_id = '';
        $project->name = $request->input('name');
        $project->owner =$request->input('owner');
        $project->state_id =$request->input('state_id');
        $project->city_id =$request->input('city_id');
        $project->description = $request->input('description');
        $project->higri_start_date = $request->input('higri_start_date');
        $project->higri_start_txt = $request->input('higri_start_txt');
        $project->date_gregorian = $request->input('date_gregorian') ? $request->input('date_gregorian'):date('y-m-d') ;
        $project->date_gregorian_txt = $request->input('date_gregorian_txt');
        $project->address = $request->input('location');
        $project->project_type = $request->input('project_type');
        $project->latitude = $request->input('latitude');
        $project->longitude = $request->input('longitude');
        $project->end_date = $request->input('end_date');
        $project->Traffic_Accidents = $request->input('Traffic_Accidents');
        $project->Injuries = $request->input('Injuries');
        $project->Fire = $request->input('Fire');
        $project->Deaths = $request->input('Deaths');
        $project->is_active = !empty($request->input('is_active'))? 0:1;

        $project->update();


        $safety_arr=!empty($request->input('safety')) ? $request->input('safety'): array();
        $consultant_arr=!empty($request->input('consultant')) ? $request->input('consultant'): array();
        $contractor_arr=!empty($request->input('contractor')) ? $request->input('contractor'): array();

        $head_employee=array_merge($safety_arr, $consultant_arr,$contractor_arr);
        $this->ProjectAssignEmployee($head_employee,$project->id);
        flash(__('Project has been updated'))->success();

        return Redirect::route('edit.project',['id'=> $id]);
    }

    public function deleteProject(Request $request)
    {
        $id = $request->input('id');
        try {

            $project = Project::findOrFail($id);
            $project_jobs=$project->jobs->count();
            if($project_jobs== 0)
            {
                \Storage::disk('s3')->delete('amen_project/logo' . $project->logo);
                $project->delete();
                echo 'ok';
            }
            else{
                echo __("Project has associated jobs")."\n";
            }

        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function indexViolations($project_id){
        $projects=Project::all()->pluck('name','id')->toArray();
        $danger_cat = DataArrayHelper::defaultDangerCategoriesArray();

        return view('admin.project.index-violations')
            ->with('project_id',$project_id)
            ->with('danger_cat',$danger_cat)
            ->with('projects',$projects)

            ;
    }

    public function fetchViolationsData(Request $request){

        $violations = Violation::with(['objection','project'])->where('violations.project_id',$request->input('project_id'))->where('violations.objection_status','!=','1')->orderby('id','DESC')
            ->select([
                    'violations.id',
                    'violations.project_id',
                    'violations.gregorian_date',
                    'violations.code',
                    'violations.danger_cat_id',
                    'violations.danger_sub_cat_id',
                    'violations.danger_status',
                    'violations.payment_status',
                    'violations.danger_status_last',
                    'violations.is_active',
                    'violations.removement_duration',
                    'violations.cost',
                    'violations.current_cost',
                    'violations.created_at',
                    'violations.updated_at'
                ]);
        return Datatables::of($violations)->filter(function ($query) use ($request) {

            if ($request->has('id') && !empty($request->id)) {
                $query->where('violations.id', 'like', "{$request->get('id')}");
            }
            if ($request->has('date_txt') && !empty($request->date_txt)) {

                $query->whereBetween('violations.gregorian_date',  explode(' - ',$request->date_txt));
            }

            if ($request->has('project_id') && !empty($request->project_id)) {
                $query->where('violations.project_id', '=', $request->get('project_id'));
            }

            if ($request->has('danger_cat_id') && !empty($request->danger_cat_id)) {
                $query->where('violations.danger_cat_id', '=', $request->get('danger_cat_id'));
            }
            if ($request->has('danger_status') && !empty($request->danger_status)) {
                $query->where('violations.danger_status', '=', $request->get('danger_status'));
            }
            if ($request->has('payment_status') && $request->payment_status!='') {
                if($request->payment_status=='1')
                    $query->where('violations.payment_status', '=', $request->get('payment_status'));
                else
                    $query->where('violations.payment_status', '=', Null);
            }
            if ($request->has('danger_status_last') && !empty($request->danger_status_last)) {
                $query->where('violations.danger_status_last', '=', $request->get('danger_status_last'));
            }


        })
            ->addColumn('gregorian_date', function ($violations) {
                if($violations->objection_status=='hold')
                {
                    $text=  '<i class="fa fa-warning red-color"></i>'.\Arabic\Arabic::adate(' j F Y ', strtotime($violations->gregorian_date));
                }
                else{
                    $text= \Arabic\Arabic::adate(' j F Y ', strtotime($violations->gregorian_date)) ;
                }

                return $text ;
            })
            ->addColumn('project_id', function ($violations) {
                return __($violations->project->name) ;
            })
            ->addColumn('danger_cat_id', function ($violations) {
                return '<p class="text-display">'.$violations->danger_cat->country.' / ' .$violations->sub_cat->state.'</p>' ;
            })
            ->addColumn('danger_status', function ($violations) {
                return __($violations->danger_status) ;
            })
            ->addColumn('payment_status', function ($violations) {
                $p_status= $violations->payment_status==1 ? "fa-check-circle green-color":"fa-times-circle red-color";
                return '<i class="fa '.$p_status.'"></i>' ;
            })
            ->addColumn('danger_status_last', function ($violations) {
                return __($violations->danger_status_last) ;
            })

            ->addColumn('action', function ($violations) {

                if(isset($violations->objection->id))
               {
                   $obiection_element='<li><a href="javascript:void(0);" onclick="deleteObjection(' . $violations->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete Objection</a></li>';
               }
               else{
                   $obiection_element='';
               }
                return '<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.violation', ['id' => $violations->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteViolation(' . $violations->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
							<a href="' . route('list.confirmations', ['violation_id' => $violations->id]) . '"><i class="fa fa-list" aria-hidden="true"></i>List Confirmation</a>
						</li>
						'.$obiection_element.'																																		
					</ul>
				</div>';
            })
            ->rawColumns(['payment_status','action','danger_cat_id','gregorian_date'])
            ->setRowId(function($violations) {
                return  'violationDtRow'.$violations->id;
            })
            ->make(true);
    }

    public function CreateViolation($id){
        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($id);

        $danger_cat = DataArrayHelper::defaultDangerCategoriesArray();
        $violation=new Violation();
        return view('admin.project.add-violation')
               ->with('project_id',$id)
               ->with('danger_cat',$danger_cat)
               ->with('violation',$violation)
               ->with('project',$project)
            ;
    }

    public function StoreViolation(Request $request){
        DB::beginTransaction();

        try{

            $validator = Validator::make($request->all(), [
                'gregorian_date_str' => 'required',
                'axles'=>'required|string|max:255',
                'floor'=>'required|string|max:255',
                'area'=>'required|string|max:255',
                'special_marque'=>'string|max:255',
                'description'=>'required|string|max:500',
                'danger_status'=>'required'

            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            $violation=new Violation();

            $Date = $request->input('gregorian_date');
            if($request->input('danger_status')=='High')
            {
//                $cost=150;
                $removement_duration= date('Y-m-d', strtotime($Date. ' + 3 days'));
            }

            elseif($request->input('danger_status')=='Medium')
            {
//                $cost=100;
                $removement_duration= date('Y-m-d', strtotime($Date. ' + 5 days'));
            }

            else
            {
//                $cost=50;
                $removement_duration= date('Y-m-d', strtotime($Date. ' + 7 days'));
            }
         $cost=$request->input('cost');
         $violation->employee_id = 1;
            $violation->project_id = $request->input('project_id');
            $gregorian_date_str=explode(' ',$request->input('gregorian_date_str'));
            $violation->gregorian_date = $gregorian_date_str[0];
//        $violation->gregorian_txt = $request->input('gregorian_txt');
            $violation->code=0;
            $violation->violation_time =$gregorian_date_str[1];
            $violation->axles =$request->input('axles');
            $violation->floor =$request->input('floor');
            $violation->area =$request->input('area');
            $violation->special_marque =$request->input('special_marque');
            $violation->description = $request->input('description');
            $violation->danger_cat_id = $request->input('danger_cat_id');
            $violation->danger_sub_cat_id = $request->input('danger_sub_cat_id');
            $violation->danger_status = $request->input('danger_status') ;
            $violation->cost =$cost;
            $violation->current_cost =$cost;
            $violation->removement_duration=$removement_duration;
            $violation->save();
            $violation->code =$violation->id ;
            $violation->update();
            if($request->hasFile('uploads'))
            {
                //  `employee_id`, `title`, `upload_file`

                foreach ($request->file('uploads') as $upload) {
                    $v_attache = New ViolationUploads();
                    $v_attache->violation_id = $violation->id;
                    $v_attache->title = $violation->id;
                    $v_attache->upload_file = ImgUploader::UploadDoc('amen_project/violation', $upload);

                    $v_attache->save();
                }
            }
           DB::commit();

            $project=Project::find($violation->project_id);
            $assignees_emails=Project::find($violation->project_id)->assignees()->get()->pluck('email')->toArray();
            $Amens_emails=Employee::where('state_id','=',$project->state_id)->where('employee_role_id','=',2)->active()->get()->pluck('email')->toArray();

            if(is_array( $Amens_emails))
                $total_emails=array_merge($assignees_emails, $Amens_emails);

            Mail::to($total_emails)->send(new ViolationNotificationMail(['violation'=>$violation,'status_message'=>__('Violation has been Created'),'type'=>'violation']));

            flash(__('Violation has been Created'))->success();

            return Redirect::route('list.violations',['id'=>$violation->project_id]);
        }
        catch(\Exception $e)
        {
            DB::rollback();

            flash(__('Something Went Wrong'))->error();
        }
    }

    public function EditViolation($id){
        $danger_cat = DataArrayHelper::defaultDangerCategoriesArray();
        $violation=Violation::findOrfail($id);
        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($violation->project_id);
        return view('admin.project.edit-violation')
            ->with('danger_cat',$danger_cat)
            ->with('violation',$violation)
            ->with('project',$project)
            ;
    }

    public function UpadteViolation(Request $request){
        $gregorian_date_str=explode(' ',$request->input('gregorian_date_str'));
        DB::beginTransaction();

        try{

            $validator = Validator::make($request->all(), [
                'gregorian_date_str' => 'required',
                'axles'=>'required|string|max:255',
                'floor'=>'required|string|max:255',
                'area'=>'required|string|max:255',
                'special_marque'=>'string|max:255',
                'description'=>'required|string|max:500',
                'danger_status'=>'required',
                'danger_sub_cat_id'=>'required',
                'danger_cat_id'=>'required'

            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            $violation=Violation::findOrfail($request->input('id'));

            $Date = $gregorian_date_str[0];
            if($request->input('danger_status')=='High')
            {
//                $cost=150;
                $removement_duration= date('Y-m-d', strtotime($Date. ' + 3 days'));
            }

            elseif($request->input('danger_status')=='Medium')
            {
//                $cost=100;
                $removement_duration= date('Y-m-d', strtotime($Date. ' + 5 days'));
            }

            else
            {
//                $cost=50;
                $removement_duration= date('Y-m-d', strtotime($Date. ' + 7 days'));
            }

            $violation->gregorian_date = $gregorian_date_str[0];
            $violation->violation_time =$gregorian_date_str[1];
            $violation->axles =$request->input('axles');
            $violation->floor =$request->input('floor');
            $violation->area =$request->input('area');
            $violation->special_marque =$request->input('special_marque');
            $violation->description = $request->input('description');
            $violation->danger_cat_id = $request->input('danger_cat_id');
            $violation->danger_sub_cat_id = $request->input('danger_sub_cat_id');
            $violation->danger_status = $request->input('danger_status') ;
            $violation->cost =$request->input('cost');
            $violation->current_cost =$request->input('cost');
            $violation->removement_duration=$removement_duration;
            $violation->update();

            if($request->hasFile('uploads'))
            {
                //  `employee_id`, `title`, `upload_file`
                foreach ($request->file('uploads') as $upload) {
                    $v_attache = New ViolationUploads();
                    $v_attache->violation_id = $violation->id;
                    $v_attache->title = $violation->id;
                    $v_attache->upload_file = ImgUploader::UploadDoc('amen_project/violation', $upload);

                    $v_attache->save();
                }
            }
            DB::commit();

            flash(__('Violation has been Updated'))->success();

            return Redirect::route('edit.violation',['id'=>$violation->project_id]);
        }
        catch(\Exception $e)
        {
            flash(__('Something Went Wrong'))->error();

            DB::rollback();


        }
    }

    public function deleteViolation(Request $request){
        $id = $request->input('id');
        try {
            $violation = Violation::findOrFail($id);
            $violation->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function deleteObjection(Request $request){
        $id = $request->input('id');
        try {
        $violation = Violation::findOrFail($id);
        $violation->objection_status='';
        $violation->update();
        $objection =Objection::where('violation_id','=',$id)->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function indexConfirmations($violation_id){

        return view('admin.project.confirm.index-confirmations')
               ->with('violation_id',$violation_id)
            ;
    }

    public function fetchConfirmationData(Request $request){

        $violation_histories = ViolationHistory::where('violation_id','=',$request->input('violation_id'))->orderby('id','DESC')
            ->select([
                'violation_history.id',
                'violation_history.cost',
                'violation_history.danger_status',
                'violation_history.area_status',
                'violation_history.removement_duration',
                'violation_history.created_at',
                'violation_history.updated_at'
            ]);

        return Datatables::of($violation_histories)->filter(function ($query) use ($request) {

            if ($request->has('id') && !empty($request->id)) {
                $query->where('violation_history.id', 'like', "{$request->get('id')}");
            }

            if ($request->has('danger_status') && !empty($request->danger_status)) {
                $query->where('violation_history.danger_status', '=', $request->get('danger_status'));
            }

            if ($request->has('area_status') && !empty($request->area_status)) {
                $query->where('violation_history.area_status', '=', $request->get('area_status'));
            }
        })

            ->addColumn('danger_status', function ($violation_histories) {
                return __($violation_histories->danger_status) ;
            })

            ->addColumn('area_status', function ($violation_histories) {
                return __($violation_histories->area_status) ;
            })

            ->addColumn('action', function ($violation_histories) {

                return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.violation.confirmation', ['id' => $violation_histories->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteConfirmation(' . $violation_histories->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						
																																								
					</ul>
				</div>';
            })
            ->rawColumns(['danger_status','area_status','action'])
            ->setRowId(function($violation_histories) {
                return  'confirmDtRow'.$violation_histories->id;
            })
            ->make(true);
    }

    public function deleteconfirmation(Request $request){
        $id = $request->input('id');
        try {
            $violation_history = ViolationHistory::findOrFail($id);
            $violation_history->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function CreateViolationConfrmation($violation_id)
    {
        return view('admin.project.confirm.add-confirmation')
            ->with('violation_id',$violation_id)
            ;
    }

    public function StoreViolationConfirmation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area_status'=>'required',
            'danger_status'=>'required'

        ]);



        if ($validator->fails()) {
            //
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $violation=Violation::find($request->input('violation_id'));
        $Date=date('y-m-d') ;
        if($violation->danger_status=='High')
        {
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 3 days'));
        }
        elseif($violation->danger_status=='Medium')
        {
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 5 days'));
        }
        else
        {
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 7 days'));
        }
        $cost=$request->input('cost');
//        $cost=($request->input('danger_status')=='exist') ? $violation->cost:$cost;
//        $cost=($request->input('danger_status')=='work on') ?$violation->cost * 0.5: $cost;
        DB::beginTransaction();
        try{
            $violation_history=new ViolationHistory();
            $violation_history->employee_id = 1;
            $violation_history->project_id = $violation->project_id;
            $violation_history->violation_id = $request->input('violation_id');
            $violation_history->removement_duration=$removement_duration;
            $violation_history->area_status =$request->input('area_status') ;
            $violation_history->cost=$cost;
            $violation_history->danger_status = $request->input('danger_status') ;
            $violation_history->notes = $request->input('notes') ;
            $violation_history->save();

            $violation->danger_status_last=$request->input('danger_status') ;
            $violation->area_status_last=$request->input('area_status') ;
            $violation->current_cost=$violation->current_cost+$cost;
            $violation->update();

            if($request->hasFile('uploads'))
            {
                //  `employee_id`, `title`, `upload_file`
                foreach ($request->file('uploads') as $upload) {
                    $v_attache = New ViolationUploads();
                    $v_attache->violation_id = $violation->id;
                    $v_attache->title = $violation->id."-".$violation_history->id;
                    $v_attache->upload_file = ImgUploader::UploadDoc('amen_project/violation', $upload);
                    $v_attache->save();
                }
            }
            DB::commit();
            $project=Project::find($violation_history->project_id);
            $assignees_emails=Project::find($violation_history->project_id)->assignees()->active()->get()->pluck('email')->toArray();
            $Amens_emails=Employee::where('state_id','=',$project->state_id)->where('employee_role_id','=',2)->where('is_active','=',1)->get()->pluck('email')->toArray();
            if(is_array( $Amens_emails))
            {
                $total_emails=array_merge($assignees_emails, $Amens_emails);
            }
            Mail::to($total_emails)->send(new ViolationNotificationMail(['violation'=>$violation,'status_message'=>__('Violation has been Confirmed'),'type'=>'confirm']));

            flash(__('Violation has been Confirmed'))->success();
            return Redirect::route('list.confirmations', ['violation_id' => $violation->id]) ;
        }
        catch(\Exception $e)
        {
            DB::rollback();

            flash(__('Something Went Wrong'))->error();
        }
    }

    public function EditViolationConfirmation($id){
        $violation_history=ViolationHistory::findOrfail($id);
        return view('admin.project.confirm.edit-confirmation')
              ->with('violation_history',$violation_history)
            ;
    }

    public function UpadteViolationConfirmation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area_status'=>'required',
            'danger_status'=>'required'

        ]);



        if ($validator->fails()) {
            //
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $violation_history=ViolationHistory::findOrfail($request->input('id'));
        $violation=Violation::find($violation_history->violation_id);
        $Date=date('y-m-d') ;
        if($violation->danger_status=='High')
        {
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 3 days'));
        }
        elseif($violation->danger_status=='Medium')
        {
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 5 days'));
        }
        else
        {
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 7 days'));
        }
        $cost=0;
        $cost=($request->input('danger_status')=='exist') ? $violation->cost:$cost;
        $cost=($request->input('danger_status')=='work on') ?$violation->cost * 0.5: $cost;
        DB::beginTransaction();
        try{

            // $violation_history->employee_id = '';
            $violation_history->project_id = $violation->project_id;
            $violation_history->violation_id = $violation_history->violation_id;
            $violation_history->removement_duration=$removement_duration;
            $violation_history->area_status =$request->input('area_status') ;
            $violation_history->cost=$cost;
            $violation_history->danger_status = $request->input('danger_status') ;
            $violation_history->notes = $request->input('notes') ;
            $violation_history->update();

            $violation->danger_status_last=$request->input('danger_status') ;
            $violation->area_status_last=$request->input('area_status') ;
            $violation->current_cost=$violation->current_cost+$cost;
            $violation->update();

            if($request->hasFile('uploads'))
            {
                //  `employee_id`, `title`, `upload_file`
                foreach ($request->file('uploads') as $upload) {
                    $v_attache = New ViolationUploads();
                    $v_attache->violation_id = $violation->id;
                    $v_attache->title = $violation->id."-".$violation_history->id;
                    $v_attache->upload_file = ImgUploader::UploadDoc('amen_project/violation', $upload);
                    $v_attache->save();
                }
            }
          DB::commit();
            flash(__('Violation has been Updated'))->success();
            return Redirect::route('list.confirmations', ['violation_id' => $violation->id]) ;
        }
        catch(\Exception $e)
        {
            DB::rollback();

            flash(__('Something Went Wrong'))->error();
        }
    }

    public function indexEvaluation($project_id){
        $project=Project::find($project_id);
        return view('admin.project.evaluation.index-evaluations')
            ->with('project_id',$project_id)
            ->with('project',$project)
            ;
    }

    public function fetchEvaluationsData(Request $request){

        $evaluations= EmployeeEvaluation::with(['employee','project'])
            ->join('employees', 'employee_evaluations.employee_id', '=', 'employees.id')
            ->orderBy('id', 'DESC')
            ->select(
                [
                    'employee_evaluations.id',
                    'employee_evaluations.employee_id',
                    'employee_evaluations.project_id',
                    'employee_evaluations.evaluation_date',
                    'employee_evaluations.performance',
                    'employee_evaluations.initiative',
                    'employee_evaluations.collaboration',
                    'employee_evaluations.participation',
                    'employee_evaluations.supervisory',
                    'employees.employee_role_id',
                    'employees.name'
                ]);

        return Datatables::of($evaluations)
            ->filter(function ($query) use ($request) {
                if ($request->has('id') && !empty($request->id)) {
                    $query->where('employee_evaluations.id', 'like', "{$request->get('id')}");
                }

                if ($request->has('date') && !empty($request->date)) {

                    $query->whereBetween('employee_evaluations.evaluation_date',  explode(' - ',$request->date));
                }
                if ($request->has('employee_role_id') && !empty($request->employee_role_id)) {

                    $query->where('employees.employee_role_id', '=' ,$request->employee_role_id);
                    //  dd($query->toSql());
                }

                if ($request->has('project_id') && !empty($request->project_id)) {

                    $query->where(function($q) use ($request) {
                        $q->where('employee_evaluations.project_id', '=', $request->project_id);
                    });
                }

                if ($request->has('name') && !empty($request->name)) {
                    $query->where('employees.name', 'like', "%{$request->get('name')}%");
                }

            })
            ->addColumn('name', function ($evaluations) {
                return $evaluations->employee->name;
            })
            ->addColumn('role_name', function ($evaluations) {
                return __($evaluations->employee->role->role_name);
            })
            ->addColumn('evaluation_date', function ($evaluations) {
                return \Arabic\Arabic::adate(' F Y ', strtotime($evaluations->evaluation_date));
            })
            ->addColumn('project_id', function ($evaluations) {
                return $evaluations->project->name;
            })
            ->addColumn('action', function ($evaluations) {

                return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">						
						<li>
							<a href="javascript:void(0);" onclick="deleteEvaluation(' . $evaluations->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
							<a href="' . route('edit.evaluation',['id' => $evaluations->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>																																	
					</ul>
				</div>';
            })
            ->rawColumns(['action'])
            ->setRowId(function($evaluations) {
                return  'evaluationDtRow'.$evaluations->id;
            })
            ->make(true);
    }

    public function deleteEvaluation(Request $request){
        $id = $request->input('id');
        try {
            $EmployeeEvaluation = EmployeeEvaluation::findOrFail($id);
            $EmployeeEvaluation->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function CreateEvaluation($project_id)
    {
        $yearmonth=!empty($yearmonth)? $yearmonth:date('Y-m-d');
        $date_data=explode('-',$yearmonth);
        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($project_id);
        $assignees=Project::findOrfail($project_id)->assignees()->get();
        $safety_managers=$assignees->where('is_manager',1)->where('employee_role_id',3);
        $project_managers=$assignees->where('is_manager',1)->where('employee_role_id',4);
        $contractor_managers=$assignees->where('is_manager',1)->where('employee_role_id',5);
        $evaluation=EmployeeEvaluation::where('project_id','=',$project_id)->whereMonth('evaluation_date',$date_data[1])->whereYear('evaluation_date',$date_data[0])->get()->keyBy('employee_id');

        return view('admin.project.evaluation.add-evaluation')
               ->with('project_id',$project_id)
            ->with('assignees',$assignees)
            ->with('safety_managers',$safety_managers)
            ->with('project_managers',$project_managers)
            ->with('contractor_managers',$contractor_managers)
            ->with('project',$project)
            ->with('evaluation',$evaluation)
            ;
    }

    public function StoreEvaluation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year_month' => 'required|date',
        ]);

        if ($validator->fails()) {
            //
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $project_id=$request->input('project_id');
        $evaluated_staff=$request->input('ids');
        $date_data=explode('-',$request->input('year_month'));
        EmployeeEvaluation::where('project_id','=',$project_id)->whereMonth('evaluation_date',$date_data[1])->whereYear('evaluation_date',$date_data[0])->delete();

        //dd($request->input('year_month'));
        foreach ($evaluated_staff as $assinee) {
            if($request->input('performance'.$assinee)!=''||$request->input('initiative'.$assinee)!=''||$request->input('collaboration'.$assinee)!=''||$request->input('participation'.$assinee)!=''||$request->input('supervisory'.$assinee))
            {
                $evaluation=new EmployeeEvaluation();
                $evaluation->project_id=$project_id;
                $evaluation->evaluation_date=$request->input('year_month');
                $evaluation->employee_id=$assinee;
                $evaluation->performance=$request->input('performance'.$assinee);
                $evaluation->initiative=$request->input('initiative'.$assinee);
                $evaluation->collaboration=$request->input('collaboration'.$assinee);
                $evaluation->participation=$request->input('participation'.$assinee);
                $evaluation->supervisory=$request->input('supervisory'.$assinee);
                $evaluation->created_by=1;
                $evaluation->save();
            }

        }
        flash(__('Evaluation has been Added'))->success();
        return Redirect::route('list.Evaluations',['project_id'=> $project_id]);

    }

    public function EditEvaluation($id){
        $evaluation=EmployeeEvaluation::findOrfail($id);
        return view('admin.project.evaluation.edit-evaluation')
            ->with('evaluation',$evaluation)
            ;
    }

    public function UpadteEvaluation(Request $request)
    {
        $evaluation=EmployeeEvaluation::findOrfail($request->input('id'));

        $evaluation->performance=$request->input('performance');
        $evaluation->initiative=$request->input('initiative');
        $evaluation->collaboration=$request->input('collaboration');
        $evaluation->participation=$request->input('participation');
        $evaluation->supervisory=$request->input('supervisory');
        $evaluation->update();
        flash(__('Evaluation has beenUpdated'))->success();
        return Redirect::route('list.Evaluations',['project_id'=> $evaluation->project_id]);

    }

    public function indexStudies($project_id){
        $project=Project::findOrfail($project_id);
        return view('admin.project.studies.index-studies')
            ->with('project',$project)
            ;
    }

    public function CreateStudy($project_id){
        $project=Project::findOrfail($project_id);
        return view('admin.project.studies.add-studies')
            ->with('project_id',$project_id)
            ->with('project',$project)
            ;
    }
    public function StoreStudy(Request $request){

        if($request->hasFile('fire'))
        {
          $employee_id=1;
            $original_name=explode('.',$request->fire->getClientOriginalName())[0];

            $fire=new ProjectUpload();
            $fire->project_id=$request->input('id');
            $fire->employee_id=$employee_id;
            $fire->title='Fire and Alarm';
            $fire->upload_file = ImgUploader::UploadDoc('amen_project/studies', $request->file('fire'),$original_name);

            $fire->save();
        }
        /////////////////////////////////////////////////////////
        if($request->hasFile('evacuation'))
        {
            $original_name=explode('.',$request->evacuation->getClientOriginalName())[0];
            $fire=new ProjectUpload();
            $fire->project_id=$request->input('id');
            $fire->employee_id=$employee_id;
            $fire->title='Evacuation and Rescue';
            $fire->upload_file = ImgUploader::UploadDoc('amen_project/studies', $request->file('evacuation'),$original_name);
            $fire->save();
        }
        ///////////////////////////////////////////////////////////
        if($request->hasFile('dangerous_areas'))
        {
            $original_name=explode('.',$request->dangerous_areas->getClientOriginalName())[0];
            $fire=new ProjectUpload();
            $fire->project_id=$request->input('id');
            $fire->employee_id=$employee_id;
            $fire->title='Dangerous Areas';
            $fire->upload_file = ImgUploader::UploadDoc('amen_project/studies', $request->file('dangerous_areas'),$original_name);
            $fire->save();
        }
        //        ///////////////////////////////////////////////////////////
        if($request->hasFile('surrounding'))
        {
            $original_name=explode('.',$request->surrounding->getClientOriginalName())[0];
            $fire=new ProjectUpload();
            $fire->project_id=$request->input('id');
            $fire->employee_id=$employee_id;
            $fire->title='Surrounding Environment';
            $fire->upload_file = ImgUploader::UploadDoc('amen_project/studies', $request->file('surrounding'),$original_name);
            $fire->save();
        }

        return Redirect::route('list.studies',['project_id' => $request->input('id')]);
    }
    public function fetchStudiesData(Request $request)
    {
        $studies= ProjectUpload::where('project_id',$request->input('project_id'))->select('*')->orderBy('id', 'DESC')
            ->select(
                [
                    'project_uploads.id',
                    'project_uploads.employee_id',
                    'project_uploads.title',
                    'project_uploads.upload_file',
                    'project_uploads.created_at',
                    'project_uploads.updated_at'
                ]);
        return Datatables::of($studies)
            ->filter(function ($query) use ($request) {
                if ($request->has('id') && !empty($request->id)) {
                    $query->where('project_uploads.id', 'like', "{$request->get('id')}");
                }


                if ($request->has('date') && !empty($request->date)) {

                    $query->whereBetween('project_uploads.created_at',  explode(' - ',$request->date));
                }

                if ($request->has('title') && !empty($request->title)) {
                    $query->where(function($q) use ($request) {
                        $q->where('project_uploads.title', '=', $request->get('title'));
                    });
                }


            })
            ->addColumn('created_at', function ($studies) {
                return \Arabic\Arabic::adate(' j F Y ', strtotime($studies->created_at));
            })
            ->addColumn('name', function ($studies) {
                return $studies->employee->name;
            })
            ->addColumn('title', function ($studies) {
                return __($studies->title);
            })
            ->addColumn('action', function ($studies) {

                return '<a href="javascript:void(0);" onclick="deleteStudy(' . $studies->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
';
            })

            ->rawColumns(['action'])

            ->setRowId(function($studies) {
                return 'study_dt_row_' . $studies->id;
            })
            ->make(true);
        //  dd($projects);
    }

    public function deleteStudy(Request $request){
        $id = $request->input('id');
        try {
            $Project_study = ProjectUpload::findOrFail($id);
            \Storage::disk('s3')->delete('amen_project/studies' .$Project_study->upload);
            $Project_study->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function fetchlatitudelongtiude(Request $request)
    {
//
        $city_id=$request->input('city_id');
        $state_id=$request->input('state_id');
        $cities=City::select('cities.latitude', 'cities.longitude')->where('cities.id', '=', $city_id)->get()->first();
        $states=State::select('states.latitude', 'states.longitude')->where('states.id', '=', $state_id)->get()->first();
        $XXX=$cities->toArray();

        if ($XXX['latitude'] !=null) {
            $array = $cities->toJson();
        }
        else{

            $array = $states->toJson();
        }
        return $array;
    }
}
