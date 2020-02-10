<?php


namespace App\Http\Controllers;
require_once('TCPDF/tcpdf.php');

use App\DangerCategories;
use App\Mail\ViolationNotificationMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\City;
use App\Comment;
use App\Helpers\DataArrayHelper;
use App\Objection;
use App\ProjectUpload;
use App\State;
use Auth;
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
use TCPDF;
use Validator;
use ImgUploader;
use Redirect;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Mail;
use App\Traits\CommonProjectFunctions;
use App\Http\Requests\ProjectFormRequest;
use App\Http\Requests\ViolationFormRequest;
use App\Http\Requests\ConfirmationViolationFormRequest;

class ProjectController extends Controller
{
    //
    use CommonProjectFunctions;

    protected $etebtion_error=false;protected $upload_error=false;
    protected $storage_url= 'https://amen-project.s3.us-east-2.amazonaws.com/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function index()
    {
        $query_project=Employee::find(Auth::guard('employee')->user()->id)->projects();
        $projects=$query_project->get();
        $states = State::join('employees', 'employees.state_id', '=', 'states.state_id')
            ->select('states.state', 'states.state_id')
            ->where('employees.employee_role_id','=',2)
//            ->where('states.is_active','=',1)
            ->where('states.country_id', '=', 191)
            ->isDefault()->sorted()->pluck('states.state', 'states.state_id')->toArray();
            return view('projects.projects')
            ->with('project_count',$projects->count())
            ->with('states',$states)
            ;
    }

    public function fetchProjectsData(Request $request){
        $query_project=Employee::find(Auth::guard('employee')->user()->id)->projects();
        $projects= $query_project->orderBy('id', 'DESC')->with('violations')->withCount('violations')
            ->select(
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
            ->addColumn('violation_no', function ($projects) {

                return count($projects->violations->toArray())!=0 ? count($projects->violations->toArray()) : '' ;

            })
            ->addColumn('show', function ($projects) {
                $encrypted_id = Crypt::encryptString($projects->id);
                return '<a href="'.route('project.detail',['id'=>$encrypted_id]).'"><i class="fa fa-eye"></i></a>';
            })
            ->rawColumns(['is_active','show','name','date_gregorian'])
            ->setRowId(function($projects) {
                return  $projects->id;
            })
            ->make(true);
        // dd($projects);
    }

    public function ProjectForEvaluation()
    {

        $query_project=Employee::find(Auth::guard('employee')->user()->id)->projects();
        $projects=$query_project->get();
        $states = State::join('employees', 'employees.state_id', '=', 'states.state_id')
            ->select('states.state', 'states.state_id')
            ->where('employees.employee_role_id','=',2)
//            ->where('states.is_active','=',1)
            ->where('states.country_id', '=', 191)
            ->isDefault()->sorted()->pluck('states.state', 'states.state_id')->toArray();
        return view('projects.projects_for_evaluation')
            ->with('project_count',$projects->count())
            ->with('states',$states)
            ;
    }

    public function fetchProjectsDataForEvaluation(Request $request){
        $query_project=Employee::find(Auth::guard('employee')->user()->id)->projects();
        $projects= $query_project->orderBy('id', 'DESC')->with('violations')->withCount('violations')
            ->select(
                [
                    'projects.id',
                    'projects.name',
                    'projects.date_gregorian',
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
            ->addColumn('violation_no', function ($projects) {

                return count($projects->violations->toArray())!=0 ? count($projects->violations->toArray()) : '' ;

            })
            ->addColumn('show', function ($projects) {
                $encrypted_id = Crypt::encryptString($projects->id);
                return '<a href="'.route('project.staff.evaluation',['id'=>$encrypted_id]).'"><i class="fa fa-list-ol"></i></a>';
            })
            ->rawColumns(['is_active','show','name','date_gregorian'])
            ->setRowId(function($projects) {
                return  $projects->id;
            })
            ->make(true);
        // dd($projects);
    }

    public function ProjectEvaluationPage($id,$yearmonth=null)
    {

        $id= Crypt::decryptString($id);
        $yearmonth=!empty($yearmonth)? $yearmonth:date('Y-m-d');
        $date_data=explode('-',$yearmonth);
        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($id);
        $assignees=Project::findOrfail($id)->assignees()->get();
        $safety_managers=$assignees->where('is_manager',1)->where('employee_role_id',3);
        $project_managers=$assignees->where('is_manager',1)->where('employee_role_id',4);
        $contractor_managers=$assignees->where('is_manager',1)->where('employee_role_id',5);

       $evaluation=EmployeeEvaluation::where('project_id','=',$id)->whereMonth('evaluation_date',$date_data[1])->whereYear('evaluation_date',$date_data[0])->get()->keyBy('employee_id');

        return view('projects.project_staff_evaluation')
            ->with('project',$project)
            ->with('assignees',$assignees)
            ->with('safety_managers',$safety_managers)
            ->with('project_managers',$project_managers)
            ->with('contractor_managers',$contractor_managers)
            ->with('safety_managers_count',$safety_managers->count())
            ->with('project_managers_count',$project_managers->count())
            ->with('contractor_managers_count',$contractor_managers->count())
            ->with('evaluation',$evaluation)
            ->with('yearmonth',$yearmonth)
            ;

    }

    public function ProjectEvaluationFetch(Request $request)
    {
        $id= Crypt::decryptString($request->input('id'));
        $date_data=explode('-',$request->input('year_month'));
//        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($id);
        $assignees=Project::findOrfail($id)->assignees()->get();
        $safety_managers=$assignees->where('is_manager',1)->where('employee_role_id',3);
        $project_managers=$assignees->where('is_manager',1)->where('employee_role_id',4);
        $contractor_managers=$assignees->where('is_manager',1)->where('employee_role_id',5);

        $evaluation=EmployeeEvaluation::where('project_id','=',$id)->whereMonth('evaluation_date',$date_data[1])->whereYear('evaluation_date',$date_data[0])->get()->keyBy('employee_id');

        return view('projects.inc.evaluation')
            ->with('assignees',$assignees)
            ->with('safety_managers',$safety_managers)
            ->with('project_managers',$project_managers)
            ->with('contractor_managers',$contractor_managers)
            ->with('safety_managers_count',$safety_managers->count())
            ->with('project_managers_count',$project_managers->count())
            ->with('contractor_managers_count',$contractor_managers->count())
            ->with('evaluation',$evaluation)
            ;
    }

    public function ProjectEvaluationStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year_month' => 'required|date',

        ]);

        if ($validator->fails()) {
            //
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $project_id=Crypt::decryptString($request->input('project_id'));
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
          $evaluation->created_by=Auth::guard('employee')->user()->id;
          $evaluation->save();
      }

        }

        flash(__('Evaluation has been updated'))->success();
        $encrypted_id = Crypt::encryptString($project_id);
        return Redirect::route('project.staff.evaluation',['id'=> $encrypted_id,'yearmonth'=>$request->input('year_month')]);

    }

    public function CreateProjectGet()
    {


        $auther_state_id=(!empty(Auth::guard('employee')->user()->state_id)) ? Auth::guard('employee')->user()->state_id : 4122;
        $auther_state_details=State::find($auther_state_id);
        $projectconsultant = Employee::where('is_manager','=',1)->where('employee_role_id','=',4)->where('state_id','=',$auther_state_id)->active()->pluck('name', 'id')->toArray();
        $consultantIds = array();
        $projectsafety = Employee::where('is_manager','=',1)->where('employee_role_id','=',3)->where('state_id','=',$auther_state_id)->active()->pluck('name', 'id')->toArray();
        $safetyIds = array();
        $projectcontractor = Employee::where('is_manager','=',1)->where('employee_role_id','=',5)->where('state_id','=',$auther_state_id)->active()->pluck('name', 'id')->toArray();
        $contractorIds = array();
        $cities=City::select('cities.city', 'cities.city_id')->where('cities.state_id', '=', $auther_state_id)->lang()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();
        return view('projects.create_project')

                   ->with('projectconsultant',$projectconsultant)
                   ->with('consultantIds',$consultantIds)
                   ->with('projectsafety',$projectsafety)
                   ->with('safetyIds',$safetyIds)
                   ->with('projectcontractor',$projectcontractor)
                   ->with('contractorIds',$contractorIds)
                   ->with('auther_state_details',$auther_state_details)
                   ->with('cities',$cities)

            ;
    }

    public function store(ProjectFormRequest $request)
    {

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
        $project->employee_id = Auth::guard('employee')->user()->id;
        $project->state_id =Auth::guard('employee')->user()->state_id;
        $project->city_id =$request->input('city_id');
        $project->name = $request->input('name');
        $project->owner =$request->input('owner');
        $project->code =0 ;
        $project->description = $request->input('description');
//        $project->higri_start_date = $request->input('higri_start_date');
//        $project->higri_start_txt = $request->input('higri_start_txt');
        $project->date_gregorian = $request->input('date_gregorian') ? $request->input('date_gregorian'):date('y-m-d') ;
        $project->date_gregorian_txt = $request->input('date_gregorian_txt');
        $project->address = $request->input('address');
        $project->project_type = $request->input('project_type');
        $project->latitude = $request->input('latitude');
        $project->longitude = $request->input('longitude');
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
        return Redirect::route('project.projects');
        }
        catch(\Exception $e){
            DB::rollback();
            flash(__('Something Went Wrong'))->error();
        }
    }

    public function show($id)
    {
        $id= Crypt::decryptString($id);
        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($id);
        $assignees=Project::findOrfail($id)->assignees()->get();
        $violations=Project::find($id)->violations()->where('objection_status','!=','1')->orderBy('id', 'DESC')->offset(0)->limit(3)->get();
        $violations_statistics=Project::find($id)->violations()->where('objection_status','!=','1')->get()->groupBy('danger_cat_id')->toArray();
        $columnchart_data='';

        for($x=1;$x<=12;$x++)
        {
            $Paied=DB::table('violations')->where('objection_status','!=','1')->where('project_id','=',$id)->whereMonth('created_at','=',$x)->where('payment_status','=',1)->count();
            $NotPaied=DB::table('violations')->where('objection_status','!=','1')->where('project_id','=',$id)->whereMonth('created_at','=',$x)->where('payment_status','=',NULL)->count();
            $columnchart_data.= "['".$x."',".$Paied.",".$NotPaied."],";
        }

        $pie_data='';
        foreach ($violations_statistics as $key=>$value){
            $dangercat= DangerCategories::findOrFail($key);
          $pie_data.=  "['".$dangercat->country."', ".count($value)."],";
        }



        $safety_managers=$assignees->where('is_manager',1)->where('employee_role_id',3);
        $sub_safeties=$assignees->wherein('pivot.employee_head_id',$safety_managers->pluck('id')->toArray());
        $project_managers=$assignees->where('is_manager',1)->where('employee_role_id',4);
        $sub_projects=$assignees->wherein('pivot.employee_head_id',$project_managers->pluck('id')->toArray());
        $contractor_managers=$assignees->where('is_manager',1)->where('employee_role_id',5);
        $sub_contractors=$assignees->wherein('pivot.employee_head_id',$contractor_managers->pluck('id')->toArray());
        $uploads=Project::find($id)->uploads()->orderBy('id', 'DESC')->get();
        //dd($uploads);
        $uploads_count=$uploads->count();
        $fires=$uploads->where('title','Fire and Alarm')->take(3);
        $evacuations=$uploads->where('title','Evacuation and Rescue')->take(3);
        $dangerous_areas=$uploads->where('title','Dangerous Areas')->take(3);
        $surroundings=$uploads->where('title','Surrounding Environment')->take(3);

        $total_employees=$assignees->where('is_manager','')->count();

        return view('projects.project_detail')
            ->with('project',$project)
            ->with('violations',$violations)
            ->with('assignees',$assignees)
            ->with('assignees_count',$assignees->count())
            ->with('safety_managers',$safety_managers)
            ->with('project_managers',$project_managers)
            ->with('contractor_managers',$contractor_managers)
            ->with('sub_safeties',$sub_safeties)
            ->with('sub_projects',$sub_projects)
            ->with('sub_contractors',$sub_contractors)
            ->with('safety_managers_count',$safety_managers->count())
            ->with('project_managers_count',$project_managers->count())
            ->with('contractor_managers_count',$contractor_managers->count())
            ->with('total_employees',$total_employees)
            ->with('uploads_count',$uploads_count)
            ->with('fires',$fires)
            ->with('evacuations',$evacuations)
            ->with('dangerous_areas',$dangerous_areas)
            ->with('surroundings',$surroundings)
            ->with('pie_data',$pie_data)
            ->with('columnchart_data',$columnchart_data)
            ;
    }

    public function edit($id)
    {
        $id=Crypt::decryptString($id);
        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($id);

        $auther_state_id=(!empty(Auth::guard('employee')->user()->state_id)) ? Auth::guard('employee')->user()->state_id : 4122;
        $auther_state_details=State::find($auther_state_id);
        $assignees=Project::findOrfail($id)->assignees()->get();

        $projectconsultant = Employee::where('is_manager','=',1)->where('employee_role_id','=',4)->where('state_id','=',$auther_state_id)->active()->pluck('name', 'id')->toArray();
        $consultantIds = $assignees->where('is_manager',1)->where('employee_role_id',4);
        $projectsafety = Employee::where('is_manager','=',1)->where('employee_role_id','=',3)->where('state_id','=',$auther_state_id)->active()->pluck('name', 'id')->toArray();
        $safetyIds = $assignees->where('is_manager',1)->where('employee_role_id',3);
        $projectcontractor = Employee::where('is_manager','=',1)->where('employee_role_id','=',5)->where('state_id','=',$auther_state_id)->active()->pluck('name', 'id')->toArray();
        $contractorIds = $assignees->where('is_manager',1)->where('employee_role_id',5);
        $cities=City::select('cities.city', 'cities.city_id')->where('cities.state_id', '=', $auther_state_id)->lang()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();

        return view('projects.edit')
            ->with('project',$project)
            ->with('projectconsultant',$projectconsultant)
            ->with('consultantIds',$consultantIds)
            ->with('projectsafety',$projectsafety)
            ->with('safetyIds',$safetyIds)
            ->with('projectcontractor',$projectcontractor)
            ->with('contractorIds',$contractorIds)
            ->with('auther_state_details',$auther_state_details)
            ->with('cities',$cities)
            ;
    }

    public function update(ProjectFormRequest $request)
{
    $project=Project::find($request->input('id'));


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
    $project->employee_id = Auth::guard('employee')->user()->id;
    $project->name = $request->input('name');
    $project->owner =$request->input('owner');
    $project->city_id =$request->input('city_id');
    $project->description = $request->input('description');
    $project->higri_start_date = $request->input('higri_start_date');
    $project->higri_start_txt = $request->input('higri_start_txt');
    $project->date_gregorian = $request->input('date_gregorian') ? $request->input('date_gregorian'):date('y-m-d') ;
    $project->date_gregorian_txt = $request->input('date_gregorian_txt');
    $project->address = $request->input('address');
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

//    flash(__('Project has been updated'))->success();
        $encrypted_id = Crypt::encryptString($project->id);
    return Redirect::route('project.detail',['id'=> $encrypted_id]);
}

    public function StudyUploads(Request $request){

//        $request->validate([
//            'fire' => 'file|max:500000',
//            'evacuation' => 'file|max:500000',
//            'dangerous_areas'=> 'file|max:500000',
//            'surrounding'=>'file|max:500000'
//        ]);

        if($request->hasFile('fire'))
        {

     $original_name=explode('.',$request->fire->getClientOriginalName())[0];

     $fire=new ProjectUpload();
     $fire->project_id=$request->input('id');
     $fire->employee_id=Auth::guard('employee')->user()->id;
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
             $fire->employee_id=Auth::guard('employee')->user()->id;
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
             $fire->employee_id=Auth::guard('employee')->user()->id;
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
            $fire->employee_id=Auth::guard('employee')->user()->id;
            $fire->title='Surrounding Environment';
            $fire->upload_file = ImgUploader::UploadDoc('amen_project/studies', $request->file('surrounding'),$original_name);
            $fire->save();
        }
        $encrypted_id = Crypt::encryptString($request->input('id'));
        flash(__('Studies Has Been Uploaded'))->success();
        return Redirect::route('project.detail',[$encrypted_id]);
        ///////////////////////////////////////////////////////////  projects.project_detail
    }

    public function ShowStudyUploads($id)
    {
        $id=Crypt::decryptString($id);
        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($id);
       return view('projects.studies')
              ->with('project',$project)
           ;
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
    public function fetchProjectStudies(Request $request)
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
            ->addColumn('show', function ($studies) {

                return '<a href="'.$this->storage_url.'amen_project/studies/'.$studies->upload_file.'" target="_blank"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('download', function ($studies) {

                return '<a href="\download_s3?path=amen_project/studies&&name='.$studies->upload_file.'" download=""><i class="fa fa-download"></i></a>';
            })
            ->addColumn('delete', function ($studies) {
                if(Auth::guard('employee')->user()->id == $studies->employee_id)
                {
                    return '<a href="javascript:void(0);" onclick="deleteStudy(' . $studies->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

                }

            })
            ->rawColumns(['download','show','delete'])

            ->setRowId(function($studies) {
                return 'study_dt_row_' . $studies->id;
            })
            ->make(true);
      //  dd($projects);
    }

    ///////////////violation part//////////////////////////////////////////////////////////////

    public function add_violation($id)
    {
        $id=Crypt::decryptString($id);
        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($id);
        $danger_cat = DataArrayHelper::defaultDangerCategoriesArray();
        //dd($danger_cat);
        return view('projects.add_violation')
            ->with('project',$project)
            ->with('danger_cat',$danger_cat)
            ;
    }

    public function store_violation(ViolationFormRequest $request)
    {
        $gregorian_date_str=explode(' ',$request->input('gregorian_date_str'));
        DB::beginTransaction();

        try{


        $violation=new Violation();

        $Date = $gregorian_date_str[0];
        if($request->input('danger_status')=='High')
        {
//            $cost=150;
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 3 days'));
        }

        elseif($request->input('danger_status')=='Medium')
          {
//              $cost=100;
              $removement_duration= date('Y-m-d', strtotime($Date. ' + 5 days'));
          }

        else
        {
//            $cost=50;
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 7 days'));
        }
        $cost=$request->input('cost');
        $violation->employee_id = Auth::guard('employee')->user()->id;
        $violation->project_id = $request->input('project_id');
        $violation->code =0 ;
//        $violation->higri_date = $request->input('higri_date');
//        $violation->higri_txt = $request->input('higri_txt');

        $violation->gregorian_date = $gregorian_date_str[0];
//        $violation->gregorian_txt = $request->input('gregorian_txt');
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
        $Amens_emails=Employee::where('state_id','=',$project->state_id)->where('employee_role_id','=',2)->where('is_active','=',1)->get()->pluck('email')->toArray();

        if(is_array( $Amens_emails))
        $total_emails=array_merge($assignees_emails, $Amens_emails);

        Mail::to($total_emails)->send(new ViolationNotificationMail(['violation'=>$violation,'status_message'=>__('Violation has been Created'),'type'=>'violation']));

       flash(__('Violation has been Created'))->success();
        return Redirect::route('project.project_violations',[Crypt::encryptString($violation->project_id)]);


        }
        catch(\Exception $e)
        {
            DB::rollback();
        flash(__('Something Went Wrong'))->error();
        }
    }

    public function show_violations($id)
    {
        $id=Crypt::decryptString($id);
        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($id);

        $danger_cat = DataArrayHelper::defaultDangerCategoriesArray();
       // dd($violations);
        // dd($violations);
        return view('projects.project_violations')
            ->with('project',$project)
            ->with('danger_cat',$danger_cat)
             ;
    }

    public function fetchViolationsData(Request $request){

        $violations = Violation::with(['objection','project'])->where('violations.project_id',$request->input('project_id'))->where('violations.objection_status','!=','1')->orderby('gregorian_date','DESC')
           ->select(
            [
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
                'violations.objection_status',
                'violations.created_at',
                'violations.updated_at'
            ]);
     //   dd($violations->get());
        return Datatables::of($violations)->filter(function ($query) use ($request) {

                if ($request->has('id') && !empty($request->id)) {
                    $query->where('violations.id', 'like', "{$request->get('id')}");
                }
                if ($request->has('date_txt') && !empty($request->date_txt)) {

                    $query->whereBetween('violations.gregorian_date',  explode(' - ',$request->date_txt));
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

                return $text;
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
//            ->addColumn('objection_status', function ($violations) {
//
//            })
            ->addColumn('show', function ($violations) {

                return '<a href="'.route('project.violation.detail',['id1'=>Crypt::encryptString($violations->project_id),'id2'=>Crypt::encryptString($violations->id)]).'"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('invoice', function ($violations) {
                $htmldata='<a href="#" data-toggle="modal" data-target="#invoiceModal'.$violations->id.'"><i class="fa fa-dollar"></i></a>';
                $htmldata.=  '<div class="modal fade invoiceModal" id="invoiceModal'.$violations->id.'" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title green-color" id="invoiceModalLabel">'.__('Invoice').'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="border: 1px solid #dadada;border-radius: 2px; padding: 10px; margin-bottom: 15px;">
                    <table width="100%" dir="rtl" style="text-align: right">
                        <tbody>
                        <tr><td style="text-align: right;"><strong>'.__('Date').':</strong> '.\Arabic\Arabic::adate(' j F Y ', strtotime(date('y-m-d'))).' </td> </tr>
                        <tr><td style="text-align: right;"> <strong>'.__('Project Name').':</strong> '.$violations->project->name.'</td><td style="text-align: right;"> <strong>'.__('Owner').':</strong> '.$violations->project->owner.' / '.__($violations->project->project_type).' </td> </tr>
                        <tr><td colspan="2"  style="text-align: right;"><strong>'.__('Danger Category').': </strong>'.$violations->danger_cat->country.' / '.$violations->sub_cat->state.' </td></tr><tr><td style="text-align: right;"><strong>'.__('Violation Code').' :</strong> '.$violations->project->code .' - '.$violations->code.' </td> </tr>

                        </tbody>
                    </table>
                </div>
                <div style="border: 1px solid #dadada;border-radius: 2px; padding: 10px;">
                    <h6>'.__('Invoice Details').'</h6>
                    <table class="table table-striped table-hover">
                        <tbody>
                        <tr>
                            <th style="text-align: right;">'.__('Main Fine').'
                                ('.__('SAR').')
                            </th>
                            <td style="text-align: right;">'.\Arabic\Arabic::adate(' j F Y ', strtotime($violations->gregorian_date)).'</td>
                            <td style="text-align: right;">'.$violations->cost.'</td>
                        </tr>';


                foreach($violations->history as $trial)
                {
                    $htmldata.=  '<tr><th style="text-align: right;">'.__('Violation Follow Up').'('.__('SAR').') </th><td style="text-align: center;">'.\Arabic\Arabic::adate(' j F Y ', strtotime($trial->created_at)).'</td><td style="text-align: center;">'.$trial->cost.'</td></tr>';
                }


                $htmldata.=  '<tr><th style="text-align: right;"><strong>'.__('Total').' ('.__('SAR').')</strong></th><td colspan="2" style="text-align: center;"><strong id="net_amount_span">'.$violations->current_cost.'</strong></td></tr>
</tbody>
</table>

</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default print-btn" data-dismiss="modal"><i class="fa fa-print"></i> '.__('Print').'</button>
    <form action="'.route('generate.pdf.Invoice').'" method="post"  style="display: inline-block;">
   <input type="hidden" value="'.$violations->id.'" id="pdf-data" name="pdf-data">
   <input type="hidden" name="_token" value="'.csrf_token().'">
<button type="submit" class="btn btn-default-focus"><i class="fa fa-download"></i> '.__('Download').'</button>
</form>
  
</div>
</div>
</div>
</div>';
                return $htmldata;
            })
            ->rawColumns(['payment_status','show','invoice','danger_cat_id','gregorian_date'])
            ->setRowId(function($violations) {
                return  $violations->id;
            })
            ->make(true);
    }

    public function violation_details($id1,$id2)
    {
        $id1=Crypt::decryptString($id1);
        $id2=Crypt::decryptString($id2);
        $project=Project::withCount(['assignees','violations','uploads'])->findOrfail($id1);

        $violation=Violation::withCount(['history','objection'])->findOrfail($id2);

        $date1=date_create($violation->gregorian_date);
        $date2=date_create(date('y-m-d'));
        $diff=date_diff($date1,$date2);
        $violation_pass_days= abs($diff->format("%R%a days"));
        $comments=Comment::where('violation_id','=',$id2)->orderBy('id', 'DESC')->get();
        $uploads=ViolationUploads::where('violation_id','=',$id2)->get();
        return view('projects.project_violation_details')
            ->with('project',$project)
            ->with('violation',$violation)
            ->with('uploads',$uploads)
            ->with('violation_pass_days',$violation_pass_days)
            ->with('comments',$comments)
            ;
    }

    public function change_payment_violation(Request $request)

    {
     $violation=Violation::find($request->input('violation_id')) ;
     $violation->payment_status=$request->input('payment');
     $violation->update();

   // $alert = $request->input('payment')==1 ? 'alert-success' :'alert-danger';
    $dd='<div class="alert alert-success">'.__('Violation has been Updated').'</div>';
     return $dd;
    }

    public function add_violation_cost(Request $request)

    {
        $type=$request->input('type');
        $violation_id=$request->input('violation_id');
        $id=$request->input('id');
        $cost=$request->input('cost');

        $violation=Violation::find($violation_id) ;

        if($type=='confirmation')
        {
            $confirmation= ViolationHistory::find($id) ;
            $confirmation->cost=$cost;
            $confirmation->update();
            $type_email='confirm';
        }
        else{
            $violation->cost=$cost;
            $type_email='violation';
        }
       $confirmation_costs= ViolationHistory::where('violation_id',$violation_id)->sum('cost');
       $violation->current_cost=$confirmation_costs+$violation->cost;
       $violation->update();

        $project=Project::find($violation->project_id);
        $assignees_emails=Project::find($violation->project_id)->assignees()->active()->get()->pluck('email')->toArray();
        $Amens_emails=Employee::where('state_id','=',$project->state_id)->where('employee_role_id','=',2)->where('is_active','=',1)->get()->pluck('email')->toArray();
        if(is_array( $Amens_emails))
        {
            $total_emails=array_merge($assignees_emails, $Amens_emails);
        }
        Mail::to($total_emails)->send(new ViolationNotificationMail(['violation'=>$violation,'status_message'=>__('Violation Cost has been Updated'),'type'=>$type_email]));

        flash(__('Violation has been Updated'))->success();
        return Redirect::route('project.violation.detail',['id1'=>Crypt::encryptString($violation->project_id),'id2'=>Crypt::encryptString($violation->id)]);

    }

    public function violation_confirm_store(ConfirmationViolationFormRequest $request){



        $violation=Violation::find($request->input('violation_id'));
        $Date=date('y-m-d') ;

        if($request->input('danger_status')=='High')
        {
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 3 days'));
        }
        elseif($request->input('danger_status')=='Medium')
        {
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 5 days'));
        }
        else
        {
            $removement_duration= date('Y-m-d', strtotime($Date. ' + 7 days'));
        }
//        $cost=0;
//        $cost=($request->input('danger_status_last')=='exist') ? $violation->cost:$cost;
//        $cost=($request->input('danger_status_last')=='work on') ?$violation->cost * 0.5: $cost;

        DB::beginTransaction();

        try{

        $violation_history=new ViolationHistory();

        $violation_history->employee_id = Auth::guard('employee')->user()->id;
        $violation_history->project_id = $request->input('project_id');
        $violation_history->violation_id = $request->input('violation_id');
        $violation_history->removement_duration=$removement_duration;
        $violation_history->area_status =$request->input('area_status_last') ;

        $violation_history->danger_status = $request->input('danger_status_last') ;
        $violation_history->notes = $request->input('notes') ;
        $violation_history->save();

        $violation->danger_status_last=$request->input('danger_status_last') ;
        $violation->area_status_last=$request->input('area_status_last') ;

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
        return Redirect::route('project.violation.detail',['id1'=>Crypt::encryptString($violation_history->project_id),'id2'=>Crypt::encryptString($violation_history->violation_id)]);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            flash(__('Something Went Wrong'))->error();
        }
        }

    public function violation_object_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'objection_txt'=>'required'

        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $Objection=new Objection();

        $Objection->employee_id_create = Auth::guard('employee')->user()->id;
        $Objection->project_id = $request->input('project_id');
        $Objection->violation_id = $request->input('id');
        $Objection->objection_txt=$request->input('objection_txt');
        $Objection->save();
        $violation=Violation::find($request->input('id'));
        $violation->objection_status='hold';
        $violation->update();

        flash(__('Objection has been Created'))->success();
        return Redirect::route('project.violation.detail',['id1'=>Crypt::encryptString($Objection->project_id),'id2'=>Crypt::encryptString($Objection->violation_id)]);
    }

    public function violation_object_reply(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'objection_reply'=>'required',
            'is_accepted'=>'required'

        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $Objection= Objection::find($request->input('id'));

        $Objection->employee_id_reply = Auth::guard('employee')->user()->id;

        $Objection->objection_reply=$request->input('objection_reply');
        $Objection->is_accepted=$request->input('is_accepted');
        $Objection->update();
        $violation=Violation::find($Objection->violation_id);
        $violation->objection_status=$request->input('is_accepted');
        $violation->update();

        flash(__('Objection has been Updated'))->success();
        return Redirect::route('project.violation.detail',['id1'=>Crypt::encryptString($Objection->project_id),'id2'=>Crypt::encryptString($Objection->violation_id)]);
    }

    public function violation_comment_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'body'=>'required'

        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $project_id=$request->input('project_id');
        $coment=new Comment();
        $coment->employee_id = Auth::guard('employee')->user()->id;
        $coment->violation_id = $request->input('id');
        $coment->body=$request->input('body');
        $coment->save();

        flash(__('Comment has been added'))->success();
        return Redirect::route('project.violation.detail',['id1'=>Crypt::encryptString($project_id),'id2'=>Crypt::encryptString($coment->violation_id)]);
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

    public function GeneratePdfProjects(Request $request)
    {


        $projects=Project::whereIn('id', explode(',' ,$request->input('pdf-data')))->get();
        $html='<style>td {border: 1px dotted #ddd; }</style>';

        $html.='<p class="am-label">'.__("Amen Projects").'</p><table cellpadding="10">';
        $html.='<tr>';
        $html.='<td>'.__('Start Date').'</td>';
        $html.='<td>'.__('Name').'</td>';
        $html.='<td>'.__('State').'</td>';
        $html.='<td>'.__('City').'</td>';
        $html.='<td>'.__('Project Status').'</td>';
        $html.='</tr>';

        foreach ($projects as $project)
        {
            $p_status= $project->is_active==1 ? "Work On":"Completed";
            $html.='<tr class="project">';
            $html.='<td>'.\Arabic\Arabic::adate(' j F Y ', strtotime($project->date_gregorian)).'</td>';
            $html.='<td>'.$project->name.'</td>';
            $html.='<td>'.$project->state->state.'</td>';
            $html.='<td>'.$project->city->city.'</td>';
            $html.='<td>'.__($p_status).'</td>';
            $html.='</tr>';

        }

$html.='</table>';


// create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
        $pdf->SetHeaderData('print-header.png', '180', '', '');

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

// set some language-dependent strings (optional)
        $pdf->setLanguageArray($lg);

// ---------------------------------------------------------

// set font
        $pdf->SetFont('dejavusans', '', 12);

// add a page
        $pdf->AddPage();

        $pdf->WriteHTML($html, true, 0, true, 0);



// set LTR direction for english translation
        $pdf->setRTL(false);

        $pdf->SetFontSize(10);

// print newline
        $pdf->Ln();

//Close and output PDF document


        $pdf->Output("projects.pdf",'D');

//============================================================+
// END OF FILE
//============================================================+

    }

    public function GeneratePdfViolations(Request $request)
    {
        $violations=Violation::whereIn('id', explode(',' ,$request->input('pdf-data')))->get();

        $html='<style>td {border: 1px dotted #ddd; }</style>';

        $html.='<p class="am-label">'.__("Project Violations").'</p><table cellpadding="10">';
        $html.='<table cellpadding="10"><tr>';
        $html.='<td>'.__('Date').'</td>';
        $html.='<td>'.__('Code').'</td>';
        $html.='<td>'.__('Danger Category').'</td>';
        $html.='<td>'.__('Danger Level').'</td>';
        $html.='<td>'.__('Paid').'</td>';
        $html.='<td>'.__('Violation Status').'</td>';
        $html.='</tr>';

foreach ($violations as $violation)
{
    $p_status= $violation->payment_status==1 ? "Yes":"No";
    $html.='<tr>';
    $html.='<td>'.\Arabic\Arabic::adate(' j F Y ', strtotime($violation->gregorian_date)).'</td>';
    $html.='<td>'.$violation->code.'</td>';
    $html.='<td>'.$violation->danger_cat->country.' / ' .$violation->sub_cat->state.'</td>';
    $html.='<td>'.__($violation->danger_status).'</td>';
    $html.='<td>'.__($p_status).'</td>';
    $html.='<td>'.__($violation->danger_status_last).'</td>';
    $html.='</tr>';
    $hader_project='<table class="header-table" cellpadding="10"><tr><td width="25%">'.__('State').':</td>
                                                                <td width="25%">'.$violation->project->state->state.'</td>
                                                                <td width="25%">'.__('City').':</td>
                                                                <td width="25%">'.$violation->project->city->city.'</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="25%">'.__('Project Name').':</td>
                                                                <td width="25%">'.$violation->project->name.'</td>
                                                                <td width="25%">'.__('Owner').':</td>
                                                                <td width="25%">'.$violation->project->owner.'</td>
                                                            </tr>
                                                        </table>';
}
        $html.='</table>';


// create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
//       $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);
        $pdf->SetHeaderData('print-header.png', '180', '', '');


// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

// set some language-dependent strings (optional)
        $pdf->setLanguageArray($lg);

// ---------------------------------------------------------

// set font
        $pdf->SetFont('dejavusans', '', 12);

// add a page
        $pdf->AddPage();

        $pdf->WriteHTML($hader_project.$html, true, 0, true, 0);



// set LTR direction for english translation
        $pdf->setRTL(false);

        $pdf->SetFontSize(10);

// print newline
        $pdf->Ln();

//Close and output PDF document
        $pdf->Output("violations.pdf",'D');

//============================================================+
// END OF FILE
//============================================================+

    }

    public function GeneratePdfOneViolation(Request $request)
    {
        $violation=Violation::find($request->input('pdf-data'));

        $payment=($violation->payment_status==1)? 'Yes' :'No' ;

        $html='<style>td {border: 1px dotted #ddd;}</style>';
        $html.='<p class="am-label">'.__("Violation Details").'</p><table cellpadding="10">';
        $html.='<tr><td width="30%">'.__('Created By').':</td><td width="70%">'.$violation->employee->name.'</td></tr>';
        $html.='<tr><td>'.__('Date').':</td><td>'.\Arabic\Arabic::adate(' j F Y ', strtotime($violation->gregorian_date)).'</td></tr>';
        $html.='<tr><td>'.__('Time').':</td><td>'.$violation->violation_time.'</td></tr>';
        $html.='<tr><td>'.__('Violation Code').':</td><td>'.$violation->project->code.' - '.$violation->code.'</td></tr>';
        $html.='<tr><td>'.__('Danger Category').':</td><td>'.$violation->danger_cat->country.' / '.$violation->sub_cat->state.'</td></tr>';
        $html.='<tr><td>'.__('axles').':</td><td>'.$violation->axles.'</td></tr>';
        $html.='<tr><td>'.__('floor').':</td><td>'.$violation->floor.'</td></tr>';
        $html.='<tr><td>'.__('area').':</td><td>'.$violation->area.'</td></tr>';
        $html.='<tr><td>'.__('Special Marque').':</td><td>'.$violation->special_marque.'</td></tr>';
        $html.='<tr><td>'.__('Danger Description').':</td><td>'.$violation->description.'</td></tr>';
//        $html.='<tr class="trial-hidden"><td>'.__('Main Fine').':</td><td>'.$violation->cost.'</td></tr>';
        $html.='<tr><td>'.__('Danger Status').':</td><td>'.__($violation->danger_status_last).'</td></tr>';
        $html.='<tr><td>'.__('Area Status').':</td><td>'.__($violation->area_status_last).'</td></tr>';
//        $html.='<tr class="trial-hidden"><td>'.__('Total').':</td><td>'.$violation->current_cost.'</td></tr>';
//        $html.='<tr class="trial-hidden"><td>'.__('Payment Status').':</td><td>'.__($payment).'</td></tr>';

        $html.='</table>';


// create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
//        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);
        $pdf->SetHeaderData('print-header.png', '180', '', '');

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

// set some language-dependent strings (optional)
        $pdf->setLanguageArray($lg);

// ---------------------------------------------------------

// set font
        $pdf->SetFont('dejavusans', '', 12);

// add a page
        $pdf->AddPage();

        $pdf->WriteHTML($html, true, 0, true, 0);



// set LTR direction for english translation
        $pdf->setRTL(false);

        $pdf->SetFontSize(10);

// print newline
        $pdf->Ln();

//Close and output PDF document
        $pdf->Output("one_violation.pdf",'D');

//============================================================+
// END OF FILE
//============================================================+

    }

    public function GeneratePdfInvoice(Request $request)
    {
        $violation=Violation::find($request->input('pdf-data'));

        $payment=($violation->payment_status==1)? 'Yes' :'No' ;
        $html='<style>td {border: 1px dotted #ddd; }</style>';
        $html.='<p class="am-label">'.__('Invoice Details').'</p>';
        $html.='<table cellpadding="10">';
        $html.='<tr><td>'.__('Date').': </td><td colspan="2">'.\Arabic\Arabic::adate(' j F Y ', strtotime(date('y-m-d'))).'</td></tr>';
        $html.='<tr><td>'.__('Project Name').': </td><td colspan="2">'.$violation->project->name.'</td></tr>';
        $html.='<tr><td>'.__('Owner').': </td><td colspan="2">'.$violation->project->owner.' / '.$violation->project->project_type.'</td></tr>';
        $html.='<tr><td>'.__('Danger Category').': </td><td colspan="2">'.$violation->danger_cat->country.' / '.$violation->sub_cat->state.'</td></tr>';
        $html.='<tr><td>'.__('Violation Code').': </td><td colspan="2">'.$violation->project->code.' - '.$violation->code.'</td></tr>';
        $html.='<tr><td>'.__('Main Fine').' ('.__('SAR').') : </td><td style="text-align: center;">'.\Arabic\Arabic::adate(' j F Y ', strtotime($violation->removement_duration)).'</td><td style="text-align: center;">'.$violation->cost.'</td></tr>';
        $hader_project='<table class="header-table" cellpadding="10"><tr><td width="25%">'.__('State').':</td>
                                                                <td width="25%">'.$violation->project->state->state.'</td>
                                                                <td width="25%">'.__('City').':</td>
                                                                <td width="25%">'.$violation->project->city->city.'</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="25%">'.__('Project Name').':</td>
                                                                <td width="25%">'.$violation->project->name.'</td>
                                                                <td width="25%">'.__('Owner').':</td>
                                                                <td width="25%">'.$violation->project->owner.'</td>
                                                            </tr>
                                                        </table>';
        foreach($violation->history as $trial)
        {
            $html.='<tr><td>'.__('Violation Follow Up').' ('.__('SAR').') : </td><td style="text-align: center;">'.\Arabic\Arabic::adate(' j F Y ', strtotime($trial->removement_duration)).'</td><td style="text-align: center;">'.$trial->cost.'</td></tr>';
        }
        $html.='</table>';


// create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
//        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);
        $pdf->SetHeaderData('print-header.png', '180', '', '');

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

// set some language-dependent strings (optional)
        $pdf->setLanguageArray($lg);

// ---------------------------------------------------------

// set font
        $pdf->SetFont('dejavusans', '', 12);

// add a page
        $pdf->AddPage();

//        $pdf->WriteHTML($html, true, 0, true, 0);
        $pdf->WriteHTML($hader_project.$html, true, 0, true, 0);


// set LTR direction for english translation
        $pdf->setRTL(false);

        $pdf->SetFontSize(10);

// print newline
        $pdf->Ln();

//Close and output PDF document
        $pdf->Output("invoice.pdf",'D');

//============================================================+
// END OF FILE
//============================================================+

    }

    public function GeneratePdfEvaluation(Request $request)
    {

        $evaluations=EmployeeEvaluation::whereIn('id', explode(',' ,$request->input('pdf-data')))->get();
        $html='<style>td {border: 1px dotted #ddd; }</style>';

        if($request->input('pdf-data-type')=='')
        {
            $html.='<p>'.__('Name').':'.Auth::guard('employee')->user()->name.'</p>';
            $html.='<p>'.__('Role').':'.__(Auth::guard('employee')->user()->role->role_name).'</p>';
        }
        $html.='<p class="am-label">'.__("Evaluation").'</p>';
        $html.='<table cellpadding="10">';
        $html.='<tr>';
        $html.='<td>'.__('Date').'</td>';
        $html.='<td>'.__('Project').'</td>';
        if($request->input('pdf-data-type')=='all')
        {
            $html.='<td>'.__('Name').'</td>';
            $html.='<td>'.__('Role').'</td>';
        }
        $html.='<td>'.__('Performance And Achievement').'</td>';
        $html.='<td>'.__('Initiative And Invention').'</td>';
        $html.='<td>'.__('Collaboration And Career Commitment').'</td>';
        $html.='<td>'.__('Participation And Responsibility').'</td>';
        $html.='<td>'.__('Supervisory Skills').'</td>';
        $html.='</tr>';

        foreach ($evaluations as $evaluation)
        {

            $html.='<tr class="project">';
            $html.='<td>'.\Arabic\Arabic::adate(' F Y ', strtotime($evaluation->evaluation_date)).'</td>';
            $html.='<td>'.$evaluation->project->name.'</td>';
            if($request->input('pdf-data-type')=='all')
            {
                $html.='<td>'.$evaluation->employee->name.'</td>';
                $html.='<td>'.__($evaluation->employee->role->role_name).'</td>';
            }
            $html.='<td>'.$evaluation->performance.'</td>';
            $html.='<td>'.$evaluation->initiative.'</td>';
            $html.='<td>'.$evaluation->collaboration.'</td>';
            $html.='<td>'.$evaluation->participation.'</td>';
            $html.='<td>'.$evaluation->supervisory.'</td>';
            $html.='</tr>';

        }

        $html.='</table>';


// create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
      // $pdf->SetHeaderData('amen_logo.png', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);
        $pdf->SetHeaderData('print-header.png', '180', '', '');

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

// set some language-dependent strings (optional)
        $pdf->setLanguageArray($lg);

// ---------------------------------------------------------

// set font
        $pdf->SetFont('dejavusans', '', 12);

// add a page
        $pdf->AddPage();

        $pdf->WriteHTML($html, true, 0, true, 0);



// set LTR direction for english translation
        $pdf->setRTL(false);

        $pdf->SetFontSize(10);

// print newline
        $pdf->Ln();

//Close and output PDF document


        $pdf->Output("evaluations.pdf",'D');

//============================================================+
// END OF FILE
//============================================================+

    }

    public function DownloadFiles(Request $request)
    {


        try {
            $file_path=$request->input('path');
            $file_name  = $request->input('name');
            $mime = Storage::disk('s3')->getDriver()->getMimetype($file_path);
            $headers = [
                'Content-Type'        => $mime,
                'Content-Disposition' => 'attachment; filename="'. $file_name .'"',
            ];

            return \Response::make(Storage::disk('s3')->get($file_path.'/'.$file_name), 200, $headers);

        }
        catch (Exception $e)
        {
            abort(404);
        return $this->respondInternalError($e->getMessage(), 'object', 500);
        }
    }
 }
