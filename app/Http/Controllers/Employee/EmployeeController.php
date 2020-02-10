<?php

namespace App\Http\Controllers\Employee;


use App\ApplicantMessage;
use App\City;
use App\ContactMail;
use App\ContactMessage;
use App\Contacts;
use App\Employee;
use App\EmployeeEducation;
use App\EmployeeEvaluation;
use App\EmployeeRole;
use App\EmployeeUpload;
use App\EmployeeRelation;
use App\Http\Requests\Front\ContactFormRequest;
use App\Job;
use App\Mail\ApplicantContactMail;
use App\Mail\ContactUs;
use App\Mail\NewUserContactMail;
use App\Project;
use App\CompanyMessage;
use App\ProjectAssign;
use App\Helpers\DataArrayHelper;
use App\Mail\RegisterVerify;
use App\Role;
use App\State;
use App\Traits\CountryStateCity;
use App\Traits\EmplyeeTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mail;
use App\Mail\NewEmployeeAdded;
use Hash;
use File;
use ImgUploader;
use Auth;
use Validator;
use DB;
use Input;
use Redirect;
use Newsletter;
use App\Http\Controllers\Controller;
use App\Traits\Cron;
use Carbon\Carbon;
use Form;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use DataTables;
use App\Http\Requests\EmployeeFormRequest;
use App\Traits\CommonProjectFunctions;
use Cache;


class EmployeeController extends Controller
{

protected $etebtion_error=false;protected $upload_error=false;

    use EmplyeeTrait;
    use CountryStateCity;
    use CommonProjectFunctions;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employee', ['except' => ['sendContactForm']]);

    }

    public function index()
    {

        $query_project= Employee::find(Auth::guard('employee')->user()->id)->projects();
        $projects= $query_project->orderBy('id', 'DESC')
                ->offset(0)
                ->limit(3)
                ->get();
        $employee_count=EmployeeRelation::where('employee_id','=',Auth::guard('employee')->user()->id)->count();
        $evaluation_count=EmployeeEvaluation::where('employee_id','=',Auth::guard('employee')->user()->id)->count();
        $projects_count=$query_project->count();

        Employee::find(Auth::guard('employee')->user()->id)->getCachedMessgeCount();

        Employee::find(Auth::guard('employee')->user()->id)->getCachedEventsCount();


        return view('employee_home')
               ->with('employee_count',$employee_count)
               ->with('projects',$projects)
               ->with('evaluation_count',$evaluation_count)
               ->with('projects_count',$projects_count)
               ->with('messages_count',Cache::get(Auth::guard('employee')->user()->id.'messages_count'))
               ->with('count_new_event',Cache::get(Auth::guard('employee')->user()->id.'count_new_event'))

           ;
       
    }

    public function create()
    {

        $cities=City::select('cities.city', 'cities.city_id')->where('cities.state_id', '=', Auth::guard('employee')->user()->state_id)->lang()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();

        return view('employee.create')
                 ->with('cities',$cities)
                ;
    }

    public function store(EmployeeFormRequest $request)
    {
        $password=$this->GeneratePassword(7);
        DB::beginTransaction();
        try{
        $user = new Employee();
        /*         * **************************************** */
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = ImgUploader::UploadImage('employee_images', $image, $request->input('name'), 100, 100, false);
            $user->image = $fileName;
        }
        /*         * ************************************** */
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->job_title = $request->input('job_title');
        $user->job_employer = $request->input('job_employer');
        $user->password = \Illuminate\Support\Facades\Hash::make($password);

        // $user->date_of_birth = $request->input('date_of_birth');
        $user->nationality_id = $request->input('nationality_id');
        $user->national_id_card_number = $request->input('national_id_card_number');
        $user->country_id = $request->input('country_id');
        $user->state_id = Auth::guard('employee')->user()->state_id;
        $user->city_id = $request->input('city_id');
        $user->phone = $request->input('phone');
        //$user->mobile_num = $request->input('mobile_num');
        //$user->street_address = $request->input('street_address');
        $user->employee_role_id=$request->input('employee_role_id');
        $user->is_active = 1;
        $user->verified = 1;
        $user->save();
        /*         * ******************** */
        $user->slug = str_slug($user->name, '-') . '-' . $user->id;
        $user->update();
        /*         * ******************** */

        /*         * *********************** */
        $relation= New EmployeeRelation();
        $relation->employee_id= Auth::guard('employee')->user()->id;
        $relation->employee_child_id=$user->id;
        $relation->save();
        $projects=Employee::find(Auth::guard('employee')->user()->id)->projects()->get();

        $this->ProjectAssignNewEmployee($relation->employee_id,$relation->employee_child_id,$projects);
        /*         * *********************** */
        if($request->hasFile('uploads'))
        {
            //  `employee_id`, `title`, `upload_file`
            foreach ($request->file('uploads') as $upload) {
                $em_attache = New EmployeeUpload();
                $em_attache->employee_id = $user->id;
                $em_attache->upload_file = ImgUploader::UploadDoc('employee_uploads', $upload);

                //$em_attache->upload_file = $upload->store('uploads');
                $em_attache->save();
            }
        }
        //`employee_id`, `degree_title`, `country_id`, `state_id`, `city_id`, `date_completion`, `institution`, `degree_result
        foreach (array_combine($request->input('degree_title'), $request->input('date_completion')) as $title => $date) {
            if($title!='' )
            {
                $em_education = New EmployeeEducation();
                $em_education->employee_id = $user->id;
                $em_education->date_completion =$date;
                $em_education->degree_title =$title;
                $em_education->save();
            }

        }
        DB::commit();

        Mail::to([$user->email])->send(new NewEmployeeAdded(['user'=>$user,'generated_pass'=>$password]));
        flash(__('Employee has been added'))->success();
        return redirect()->route('employee.add');

        }
        catch(\Exception $e)
        {
            DB::rollback();

            flash(__('Something Went Wrong'))->error();
        }
    }

    public function edit($id)
    {
        $id=Crypt::decryptString($id);
        $employee=Employee::find($id);

        $role_name=EmployeeRole::find($employee->employee_role_id);

        $uploads=EmployeeUpload::where('employee_id','=',$id)->get();
        $cities=City::select('cities.city', 'cities.city_id')->where('cities.state_id', '=', Auth::guard('employee')->user()->state_id)->lang()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();

        $educations=EmployeeEducation::where('employee_id','=',$id)->get();
        return view('employee.edit')
                ->with('uploads',$uploads)
                ->with('educations',$educations)
                ->with('role_name',$role_name->role_name)
                ->with('employee',$employee)
                ->with('cities',$cities)
            ;
    }

    public function update(EmployeeFormRequest $request)
    {
        $employee=Employee::find($request->input('id'));
        /*         * **************************************** */
        if ($request->hasFile('image')) {

            $image = $employee->image;
            if (!empty($image)) {
                Storage::disk('s3')->delete('employee_images' . $image);
             //   File::delete(ImgUploader::real_public_path() . 'employee_images/' . $image);
            }
            $image = $request->file('image');
//            dd($image,$request->file('uploads'));
            $fileName = ImgUploader::UploadImage('employee_images', $image, $request->input('name'), 100, 100, false);

            $employee->image = $fileName;
        }
        /*         * ************************************** */

         $employee->name = $request->input('name');
         $employee->job_title = $request->input('job_title');
         $employee->job_employer = $request->input('job_employer');
         $employee->national_id_card_number = $request->input('national_id_card_number');
//         $employee->state_id = $request->input('state_id');
         $employee->city_id = $request->input('city_id');
         $employee->phone = $request->input('phone');
         $employee->slug = str_slug($employee->name, '-') . '-' . $employee->id;
         $employee->update();
        if($request->hasFile('uploads'))
        {
            //  `employee_id`, `title`, `upload_file`
            foreach ($request->file('uploads') as $upload) {
                $em_attache = New EmployeeUpload();
                $em_attache->employee_id = $employee->id;
                $em_attache->upload_file = ImgUploader::UploadDoc('employee_uploads', $upload);

                //$em_attache->upload_file = $upload->store('uploads');
                $em_attache->save();
            }
        }
        //`employee_id`, `degree_title`, `country_id`, `state_id`, `city_id`, `date_completion`, `institution`, `degree_result

        foreach (array_combine($request->input('degree_title'), $request->input('date_completion')) as $title => $date) {
            if($title!='' )
            {
                $em_education = New EmployeeEducation();
                $em_education->employee_id = $employee->id;
                $em_education->date_completion =$date;
                $em_education->degree_title =$title;
                $em_education->save();
            }
        }
        flash(__('Profile Has Been Updated'))->success();
        return redirect()->route('employee.edit1',[Crypt::encryptString($employee->id)]);

    }

    public function show($id)
    {
        $id=Crypt::decryptString($id);
        $employee=Employee::find($id);
        $uploads=EmployeeUpload::where('employee_id','=',$id)->get();
        $educations=EmployeeEducation::where('employee_id','=',$id)->get();
        return view('employee.show')
            ->with('uploads',$uploads)
            ->with('educations',$educations)
            ->with('user',$employee);
    }

    public function get_new_registers(){
        $new_registers = Employee::with('role')->where('verified', 0)->where('state_id', Auth::guard('employee')->user()->state_id)->paginate(15);

        return view('employee.new_registrations')
            ->with('users', $new_registers);
    }

    public function get_one_register($id)
    {
        $id=Crypt::decryptString($id);
        $new_register = Employee::findorfail($id);
        $uploads=EmployeeUpload::where('employee_id','=',$id)->get();

        return view('employee.new_registration')
            ->with('user', $new_register)
            ->with('uploads', $uploads)
            ;
    }

    public function verify_register(Request $request){
        $password=$this->GeneratePassword(7);
        $employee1=Employee::find($request->input('id'))->getState();
        $employee_res = Employee::join('employee_roles', 'employees.employee_role_id', '=', 'employee_roles.id')
            ->where('employees.id', '=', $request->input('id'))
            ->select('employees.*', 'employee_roles.role_name')
            ->get()
        ;
        $employee=$employee_res[0];
        $employee->verified=1;
        $employee->verification_token=sha1(time());
//        $employee->password = \Illuminate\Support\Facades\Hash::make($employee->national_id_card_number);
        $employee->password = \Illuminate\Support\Facades\Hash::make($password);
        $employee->slug = str_slug($employee->name, '-') . '-' . $employee->id;
        $employee->update();

        Cache::forget(Auth::guard('employee')->user()->state_id.'newRegister');
        Employee::find(Auth::guard('employee')->user()->id)->getCachedNewRegister();

        Mail::to([$employee->email])->send(new RegisterVerify([$employee,'state'=>$employee1->state,'generated_pass'=>$password]));
        flash(__('Email Has Been Sent'))->success();
        return redirect()->route('new-employees-view');
    }

    public function postedInitiatives(Request $request)
    {

        if( Auth::guard('employee')->user()->employee_role_id == 1 && Auth::guard('employee')->user()->is_manager ==1){
            $jobs = Job::where("state_id",Auth::guard('employee')->user()->state_id)->paginate(10);
            $jobs_1 = Job::where("Initiatives_type",'1')->where("state_id",Auth::guard('employee')->user()->state_id)->paginate(10);
            $jobs_2= Job::where("Initiatives_type",'2')->where("state_id",Auth::guard('employee')->user()->state_id)->paginate(10);
            $jobs_0 = Job::where("Initiatives_type",'0')->where("state_id",Auth::guard('employee')->user()->state_id)->paginate(10);
        }elseif (Auth::guard('employee')->user()->employee_role_id == 2 && Auth::guard('employee')->user()->is_manager ==1){
            $jobs = Job::where("state_id",Auth::guard('employee')->user()->state_id)->paginate(10);
            $jobs_1 = Job::where("Initiatives_type",'1')->where("state_id",Auth::guard('employee')->user()->state_id)->paginate(10);
            $jobs_2= Job::where("Initiatives_type",'2')->where("state_id",Auth::guard('employee')->user()->state_id)->paginate(10);
            $jobs_0 = Job::where("Initiatives_type",'0')->where("state_id",Auth::guard('employee')->user()->state_id)->paginate(10);
        }else{
            $jobs = Auth::guard('employee')->user()->jobs()->paginate(10);
            $jobs_1 = Auth::guard('employee')->user()->jobs()->where("Initiatives_type",'1')->paginate(10);
            $jobs_2= Auth::guard('employee')->user()->jobs()->where("Initiatives_type",'2')->paginate(10);
            $jobs_0 = Auth::guard('employee')->user()->jobs()->where("Initiatives_type",'0')->paginate(10);
        }


        return view('Initiatives.company_posted_jobs')
            ->with('jobs', $jobs)
            ->with('jobs_1', $jobs_1)
            ->with('jobs_2', $jobs_2)
            ->with('jobs_0', $jobs_0);
    }

    public function employeeDetail(Request $request, $company_slug)
    {
        $company =Employee::where('slug', 'like', $company_slug)->firstOrFail();
        /*         * ************************************************** */
        $seo = $this->getCompanySEO($company);

        /*         * ************************************************** */
        return view('employee.detail')
            ->with('company', $company)
            ->with('seo', $seo);
    }

    public function employeeMessages()
    {
        $company = Employee::findOrFail(Auth::guard('employee')->user()->id);

        $query_project=Employee::find(Auth::guard('employee')->user()->id)->projects()->get();

        $projects= $query_project->pluck('name', 'id')->toArray();

        $consultantIds = array();
//        dd($projects);
//        $assignees=Project::findOrfail($project->id)->assignees()->get();
//        die(dd($assignees));
//        $safety_managers=$assignees->where('is_manager',1)->where('employee_role_id',3);
//        $sub_safeties=$assignees->wherein('pivot.employee_head_id',$safety_managers->pluck('id')->toArray());
//        $project_managers=$assignees->where('is_manager',1)->where('employee_role_id',4);
//        $sub_projects=$assignees->wherein('pivot.employee_head_id',$project_managers->pluck('id')->toArray());
//        $contractor_managers=$assignees->where('is_manager',1)->where('employee_role_id',5);
//        $sub_contractors=$assignees->wherein('pivot.employee_head_id',$contractor_managers->pluck('id')->toArray());
//
//        $total_employees=$assignees->count();

        $messages = CompanyMessage::where('to_id','=', Auth::user()->id)->where('from_id','!=', Auth::user()->id)

            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'inbox');

        $messages_count = CompanyMessage::where('to_id','=', Auth::user()->id)->where('from_id','!=', Auth::user()->id)
            ->where('is_read', 0)
            ->orderBy('created_at', 'desc')
            ->count();

        $messages_send = CompanyMessage::where('company_id', '=', $company->id)->where('to_id','!=', Auth::user()->id)->where('from_id','=', Auth::user()->id)

            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'send');

        return view('employee.employee_messages')
            ->with('company', $company)
            ->with('messages', $messages)
            ->with('messages_send', $messages_send)
            ->with('projects',$projects)
            ->with('messages_count',$messages_count)
            ->with('consultantIds',$consultantIds);
    }

    public function employeeMessageDetail($message_id)
    {

        $company = Employee::findOrFail(Auth::guard('employee')->user()->id);
        $message = CompanyMessage::findOrFail($message_id);
        $message->update(['is_read' => 1]);
        $messages_count = CompanyMessage::where('to_id','=', Auth::user()->id)->where('from_id','!=', Auth::user()->id)
            ->where('is_read', 0)
            ->orderBy('created_at', 'desc')
            ->count();
        return view('employee.employee_message_detail')
            ->with('company', $company)
            ->with('messages_count',$messages_count)
            ->with('message', $message);
    }

    public function sendContactForm(Request $request)
    {

if (   $request->employee_id == 'null'){
    $requestData = $request->all();
    $requestData['employee_id'] = null;
}else{
    $requestData = $request->all();
}

        $msgresponse = Array();

        if($requestData['compose'] == 'compose'){


            $rules = array(
                'message' => 'required',

//            'g-recaptcha-response' => 'required|captcha',
            );
            $rules_messages = array(

                'message.required' => __('Message is required'),

//            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
//            'g-recaptcha-response.captcha' => __('Captcha error! try again'),
            );
            $validation = Validator::make($request->all(), $rules, $rules_messages);

            if ($validation->fails()) {
                $msgresponse = $validation->messages()->toJson();
                echo $msgresponse;
                exit;
            }
            else {




                $messages = CompanyMessage::where('id', '=', $request->input('massage_id'))->first();

                if (Auth::check()) {
                    $from_name = Auth::user()->name;
                    $from_email = Auth::user()->email;
                    $from_phone = Auth::user()->phone;
                    $from_id = Auth::user()->id;
                }
                ;
                $receiver_employee = Employee::findOrFail($request->input('empid'));
                $data['company_id'] = $request->input('company_id');
                $data['company_name'] = $request->input('company_name');
                $data['from_id'] = $from_id;
                $data['to_id'] = $request->input('empid');
                $data['from_name'] = $from_name;
                $data['from_email'] = $from_email;
                $data['from_phone'] = $from_phone;
                $data['subject'] = $messages->subject;
                $data['message_txt'] = $request->input('message');
                $data['to_email'] = $receiver_employee->email;
                $data['to_name'] = $receiver_employee->name;
                $data['is_replay']=1;

                $msg_save = CompanyMessage::create($data);

                $when = Carbon::now()->addMinutes(5);

//                Mail::send(new CompanyContactMail($data));
//
//                flash(__('Message sent successfully'))->success();
//                return redirect()->route('employee.messages');
                $msgresponse = ['success' => 'success', 'message' => __('Message sent successfully')];


                echo json_encode($msgresponse);
                exit;
            }
        }
        else{

            $rules = array(
                'subject' => 'required|max:200',
                'message' => 'required',
                'consultant'=>'required',
                'employee_id' => 'required|required_if:employee_id,==,"null"|nullable',
//            'g-recaptcha-response' => 'required|captcha',
            );
            $rules_messages = array(
                'subject.required' => __('Subject is required'),
                'message.required' => __('Message is required'),
                'employee_id.required_if' => __('Please Select Employee'),
                'employee_id.required' => __('Please Select Employee'),
                'employee_id.nullable' => __('Please Select Employee'),
                'consultant.required' => __('Please select project'),
//            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
//            'g-recaptcha-response.captcha' => __('Captcha error! try again'),
            );
            $validation = Validator::make($requestData, $rules, $rules_messages);



            if ($validation->fails()) {
                $msgresponse = $validation->messages()->toJson();
                echo $msgresponse;
                exit;
            }
            else {

                if (Auth::check()) {
                    $from_name = Auth::user()->name;
                    $from_email = Auth::user()->email;
                    $from_phone = Auth::user()->phone;
                    $from_id = Auth::user()->id;
                }

                $assignees  = explode(',', $request->input('employee_id'));
                foreach ($assignees as $assignee) {
                    $receiver_employee = Employee::findOrFail($assignee);
                    $data['company_id'] = $request->input('company_id');
                    $data['company_name'] = $request->input('company_name');
                    $data['from_id'] = $from_id;
                    $data['to_id'] =  $receiver_employee->id;
                    $data['from_name'] = $from_name;
                    $data['from_email'] = $from_email;
                    $data['from_phone'] = $from_phone;
                    $data['subject'] = $request->input('subject');
                    $data['message_txt'] = $request->input('message');
                    $data['to_email'] = $receiver_employee->email;
                    $data['to_name'] = $receiver_employee->name;
                    $msg_save = CompanyMessage::create($data);
                    $when = Carbon::now()->addMinutes(5);
                }
//            Mail::send(new CompanyContactMail($data));

//            flash(__('Message sent successfully'))->success();
//            return redirect()->route('employee.messages');
                $msgresponse = ['success' => 'success', 'message' => __('Message sent successfully')];


                echo json_encode($msgresponse);

                exit;

            }



        }
    }

    public function filterLangStates(Request $request)
    {
        $country_id = $request->input('country_id');

        $state_id = $request->input('employee_id');
        $new_state_id = $request->input('new_state_id', 'employee_id');

        $assignees=Project::findOrfail($country_id)->assignees()->where('employees.id','!=',  Auth::guard('employee')->user()->id)->get();
        $safeties=$assignees->where('employee_role_id',3)->toArray();
        $project_managers=$assignees->where('employee_role_id',4)->toArray();

        $contractor_managers=$assignees->where('employee_role_id',5)->toArray();

//        $dd = Form::select('employee_id', ['' => __('Select Employee').' *'] + $assignees, $state_id, array('id' => $new_state_id, 'class' => 'form-control'));
        if (count($assignees )==0  ){
            $dd='<select   id="employee_id"  name="employee_id[]"   class="form-control select2-multiple" multiple="multiple" style="width: 100%"  required="true" data-validation="required" >';

                $dd .='<option value=" "> '.__('NO Employee').'</option></select>';

        }else{
            $dd='<select  id="employee_id"  name="employee_id[]"  class="form-control select2-multiple"  multiple="multiple" style="width: 100%"  required="true" data-validation="required">';
            if (count($safeties ) !=0  ){
            $dd .='<optgroup label= "استشاري السلامة" >';
            foreach ($safeties as $safetie){
                $dd .='<option value="'.$safetie['id'].'"> '.$safetie['name'].'</option>';
            }
             }
            if (count($project_managers ) !=0  ) {
                $dd .= ' </optgroup><optgroup label= "استشاري المشروع" >';

                foreach ($project_managers as $project_manager) {
                    $dd .= '<option value="' . $project_manager['id'] . '"> ' . $project_manager['name'] . '</option>';
                }
            }
            if (count($contractor_managers ) !=0  ) {
                $dd .= ' </optgroup><optgroup label= ' . __('Contractor') . ' >';
                foreach ($contractor_managers as $contractor_manager) {
                    $dd .= '<option value="' . $contractor_manager['id'] . '"> ' . $contractor_manager['name'] . '</option>';
                }
            }
            $dd .=' </optgroup>';
            $dd .='</select>'  ;
        }

echo $dd;

    }

    public function sendApplicantContactForm(Request $request)
    {

        $msgresponse = Array();
        $rules = array(
            'from_name' => 'required|max:100|between:4,70',
            'from_email' => 'required|email|max:100',
            'subject' => 'required|max:200',
            'message' => 'required',
            'to_id' => 'required',
        );
        $rules_messages = array(
            'from_name.required' => __('Name is required'),
            'from_email.required' => __('E-mail address is required'),
            'from_email.email' => __('Valid e-mail address is required'),
            'subject.required' => __('Subject is required'),
            'message.required' => __('Message is required'),
            'to_id.required' => __('Recieving applicant details missing'),
            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
            'g-recaptcha-response.captcha' => __('Captcha error! try again'),
        );
        $validation = Validator::make($request->all(), $rules, $rules_messages);
        if ($validation->fails()) {
            $msgresponse = $validation->messages()->toJson();
            echo $msgresponse;
            exit;
        } else {
            $receiver_user = User::findOrFail($request->input('to_id'));
            $data['user_id'] = $request->input('user_id');
            $data['user_name'] = $request->input('user_name');
            $data['from_id'] = $request->input('from_id');
            $data['to_id'] = $request->input('to_id');
            $data['from_name'] = $request->input('from_name');
            $data['from_email'] = $request->input('from_email');
            $data['from_phone'] = $request->input('from_phone');
            $data['subject'] = $request->input('subject');
            $data['message_txt'] = $request->input('message');
            $data['to_email'] = $receiver_user->email;
            $data['to_name'] = $receiver_user->getName();
            $msg_save = ApplicantMessage::create($data);
            $when = Carbon::now()->addMinutes(5);
            Mail::send(new ApplicantContactMail($data));
            $msgresponse = ['success' => 'success', 'message' => __('Message sent successfully')];
            echo json_encode($msgresponse);
            exit;
        }
    }

    public function deleteMassage(Request $request)
    {
        $id = $request->input('id');
        try {
            $massage = CompanyMessage::findOrFail($id);

            $massage->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }

    }

    public function Delete_Account(Request $request){
    $employee=Employee::find(Auth::guard('employee')->user()->id);
        $employee->delete_request='yes';
        $employee->update();
        flash(__('Request Has Been Created'))->success();
        return redirect()->route('employee.home');
     }

    public function employeeContacts()
    {
        $company = Employee::findOrFail(Auth::guard('employee')->user()->id);

        $query_project=Employee::find(Auth::guard('employee')->user()->id)->projects()->get();

        $projects= $query_project->pluck('name', 'id')->toArray();
        $consultantIds = array();


        $contacts = Contacts::where('employee_id','=', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $messages_count = CompanyMessage::where('to_id','=', Auth::user()->id)->where('from_id','!=', Auth::user()->id)
//            ->where('is_read', 0)
            ->orderBy('created_at', 'desc')
            ->count();

        $messages_send = ContactMail::where('employee_id', '=', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $contactsArray = Contacts::where('employee_id', '=', Auth::user()->id)->select('contacts.email', 'contacts.id')->pluck('contacts.email', 'contacts.id')->toArray();
        $contactsArrayId= array();
        return view('employee.employee_contacts')
            ->with('company', $company)
            ->with('contacts', $contacts)
            ->with('contactsArray', $contactsArray)
            ->with('contactsArrayId', $contactsArrayId)
            ->with('messages_send', $messages_send)
            ->with('projects',$projects)
            ->with('messages_count',$messages_count)
            ->with('consultantIds',$consultantIds);
    }

    public function deleteContacts(Request $request)
    {
        $id = $request->input('id');
        try {
            $contacts = Contacts::findOrFail($id);

            $contacts->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }

    }

    public function sendContactMail(Request $request)
    {

        $rules = array(

            'subject' => 'required|max:200',
            'message' => 'required',
            'contact' => 'required',
//            'g-recaptcha-response' => 'required|captcha',
        );
        $rules_messages = array(
            'subject.required' => __('Subject is required'),
            'message.required' => __('Message is required'),
            'contact.required' => __('Please Select contact'),
//            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
//            'g-recaptcha-response.captcha' => __('Captcha error! try again'),
        );
        $validation = Validator::make($request->all(), $rules, $rules_messages);

        if ($validation->fails()) {
            $msgresponse = $validation->messages();

            echo $msgresponse;
            exit;
        }
        $contacts=$request->input('contact');

        foreach ($contacts as $contact){
            $contact_mail = Contacts::where('employee_id','=', Auth::user()->id)->where('id','=', $contact)
                ->orderBy('created_at', 'desc')
                ->first();

            $data['employee_id'] = Auth::guard('employee')->user()->id;
        $data['email'] = $contact_mail->email;
        $data['subject'] = $request->input('subject');
        $data['message'] = $request->input('message');
            $data['contact_id'] = $contact_mail->id;
        $msg_save = ContactMail::create($data);
            $data1['first_name'] = $contact_mail->first_name;
            $data1['last_name'] = $contact_mail->last_name;
            $data1['from_email'] = Auth::guard('employee')->user()->email;
            $data1['from_name'] = Auth::guard('employee')->user()->name;
            $data1['message_txt'] = $request->input('message');
//        $when = Carbon::now()->addMinutes(5);
        Mail::send(new NewUserContactMail($data,$data1));
        }
        return __('Message sent successfully');
//        return Redirect::route('contact.us.thanks');
    }

    public function addContactMail(Request $request)
    {

        if($join_init=Contacts::where('employee_id', Auth::guard('employee')->user()->id)->where('email', $request->email)->count()>0){

            $rules = array(

                'first_name' => 'required|max:200',
                'last_name' => 'required',
                'email' => 'required|email|max:255|unique:contact_mail',
//            'g-recaptcha-response' => 'required|captcha',
            );
        }else {

            $rules = array(

                'first_name' => 'required|max:200',
                'last_name' => 'required',
                'email' => 'required|email|max:255',
//            'g-recaptcha-response' => 'required|captcha',
            );
        }

        $rules_messages = array(
            'first_name.required' => __('First Name is required'),
            'last_name.required' => __('Last Name is required'),
            'email.required' => __('Email is required'),
            'email.unique' =>__('This Email has already been taken'),
            'email.email' =>__('Your Valid e-mail address is required'),
//            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
//            'g-recaptcha-response.captcha' => __('Captcha error! try again'),
        );
        $validation = Validator::make($request->all(), $rules, $rules_messages);

        if ($validation->fails()) {
            $msgresponse = $validation->messages();

            echo $msgresponse;
            exit;
        }
        $data['employee_id'] =  Auth::guard('employee')->user()->id;
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] =$request->input('last_name');
        $data['email'] = $request->input('email');

        $msg_save = Contacts::create($data);

//        $when = Carbon::now()->addMinutes(5);
//            Mail::send(new NewUserContactMail($data));
//        }
        return __('Contacts added successfully');
//        return Redirect::route('contact.us.thanks');
    }

    public function deleteMassageContacts(Request $request)
    {
        $id = $request->input('id');
        try {
            $contactmail = ContactMail::findOrFail($id);

            $contactmail->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }

    }

    public function employeeContactsMessageDetail($message_id)
    {

        $company = Employee::findOrFail(Auth::guard('employee')->user()->id);
        $message = ContactMail::findOrFail($message_id);
        $contact_mail = Contacts::where('employee_id','=', Auth::user()->id)->where('id','=', $message->contact_id)
            ->orderBy('created_at', 'desc')
            ->first();

//
        return view('employee.employee__contacts_message_detail')
            ->with('contact_mail', $contact_mail)

            ->with('message', $message);
    }

    public function EvaluationShowAll(){
        $query_project=Employee::find(Auth::guard('employee')->user()->id)->projects();
        $projects=$query_project->pluck('projects.name', 'projects.id')->toArray();
//dd($projects);
        return view('employee.all_evaluation_show')
            ->with('projects',$projects)
            ;
    }
    public function EvaluationShowFetchAll(Request $request){
        $query_project=Employee::find(Auth::guard('employee')->user()->id)->projects();
        $projects=$query_project->pluck( 'projects.id')->toArray();
        $evaluations= EmployeeEvaluation::with(['employee','project'])
            ->whereIn('project_id',$projects)
            ->join('employees', 'employee_evaluations.employee_id', '=', 'employees.id')
            ->join('employee_roles', 'employees.employee_role_id', '=', 'employee_roles.id')
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
                    'employee_roles.role_name',
                    'employees.name'
                ]);
//->get();
//       dd($evaluations);
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
             return $evaluations->name;
                return 'sss';
            })
            ->addColumn('role_name', function ($evaluations) {
//               return __($evaluations->employee->role->role_name);
                return __($evaluations->role_name);
            })
            ->addColumn('evaluation_date', function ($evaluations) {
                return \Arabic\Arabic::adate(' F Y ', strtotime($evaluations->evaluation_date));
            })
            ->addColumn('project_id', function ($evaluations) {
                return $evaluations->project->name;
            })
            ->setRowId(function($evaluations) {
                return  $evaluations->id;
            })
            ->make(true);
    }

    public function EvaluationShow(){
        $query_project=Employee::find(Auth::guard('employee')->user()->id)->projects();
        $projects=$query_project->pluck('projects.name', 'projects.id')->toArray();
        return view('employee.evaluation_show')
            ->with('projects',$projects);
    }
    public function EvaluationShowFetch(Request $request){

        $evaluations= EmployeeEvaluation::with(['employee','project'])
            ->where('employee_id','=',Auth::guard('employee')->user()->id)
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
                ]);
//->get();
        //dd($evaluations);
        return Datatables::of($evaluations)
            ->filter(function ($query) use ($request) {
                if ($request->has('id') && !empty($request->id)) {
                    $query->where('employee_evaluations.id', 'like', "{$request->get('id')}");
                }
                if ($request->has('date') && !empty($request->date)) {

                    $query->whereBetween('employee_evaluations.evaluation_date',  explode(' - ',$request->date));
                }
                if ($request->has('project_id') && !empty($request->project_id)) {

                    $query->where(function($q) use ($request) {
                        $q->where('employee_evaluations.project_id', '=', $request->project_id);
                    });
                }

            })

            ->addColumn('evaluation_date', function ($evaluations) {
                return \Arabic\Arabic::adate(' F Y ', strtotime($evaluations->evaluation_date));
            })
            ->addColumn('project_id', function ($evaluations) {
                return $evaluations->project->name;
            })
            ->setRowId(function($evaluations) {
                return  $evaluations->id;
            })
            ->make(true);
    }

    public function EmployeesShow(){
        $cities=City::select('cities.city', 'cities.city_id')->where('cities.state_id', '=', Auth::guard('employee')->user()->state_id)->lang()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();
        return view('employee.followers-employees')
               ->with('cities',$cities)
            ;
    }
    public function EmployeesShowFetch(Request $request){

        $employees= EmployeeRelation::where('employee_id','=', Auth::guard('employee')->user()->id)
          ->join('employees', 'employee_relations.employee_child_id', '=', 'employees.id')
            ->select(
                [
                    'employees.id',
                    'employees.name',
                    'employees.email',
                    'employees.city_id',
                    'employees.phone',

                ])
            ;

        return Datatables::of( $employees)
            ->filter(function ($query) use ($request) {
                if ($request->has('id') && !empty($request->id)) {
                    $query->where('employees.id', 'like', "{$request->get('id')}");
                }
                if ($request->has('city_id') && !empty($request->city_id)) {

                    $query->where('employees.city_id', '=' ,$request->city_id);
                }

                if ($request->has('name') && !empty($request->name)) {
                    $query->where('employees.name', 'like', "%{$request->get('name')}%");
                }

            })
            ->addColumn('name', function ( $employees) {
             return  $employees->name;
            })
            ->addColumn('phone', function ( $employees) {
             return  $employees->phone;

            })
            ->addColumn('email', function ( $employees) {
             return  $employees->email;

            })
            ->addColumn('city_id', function ( $employees) {
             // return  $employees->city->city;
                if($employees->city_id!='')
                {
                    $city = City::where('cities.city_id', '=',$employees->city_id)->lang()->active()->first();
                    return  $city->city;
                }

            })
            ->addColumn('show', function ( $employees) {
                $encrypted_id = Crypt::encryptString($employees->id);
                return '<a href="'.route('employee.show',['id'=>$encrypted_id]).'"><i class="fa fa-eye"></i></a>';
            })
            ->rawColumns(['show'])
            ->setRowId(function($employees) {
                return  $employees->id;

            })
            ->make(true);
    }
}


