<?php

namespace App\Traits;

use App\CompanyMessage;
use App\Employee;
use App\Http\Requests\Front\ReportAbuseFormRequest;
use App\Http\Requests\Front\JoinInitiativsFormRequest;

use App\JoinInitiatives;
use App\Mail\CompanyContactMail;
use App\Mail\ReportAbuse;
use App\Project;
use App\ReportAbuseMessage;
use File;
use ImgUploader;
use Auth;
use DB;
use Input;
use Redirect;
use Carbon\Carbon;
use App\Job;
use App\Company;
use App\JobSkill;
use App\JobSkillManager;
use App\Country;
use App\CountryDetail;
use App\State;
use App\City;
use App\CareerLevel;
use App\FunctionalArea;
use App\JobType;
use App\JobShift;
use App\Gender;
use App\JobExperience;
use App\DegreeLevel;
use App\SalaryPeriod;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\JobFormRequest;
use App\Http\Requests\InitiativesBackFormRequest;
use App\Http\Requests\Front\InitiativesFrontFormRequest;
use App\Http\Controllers\Controller;
use App\Traits\Skills;
use App\Events\JobPosted;
use Mail;
trait InitiativesTrait
{
    use Skills;

    public function deleteJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            JobSkillManager::where('job_id', '=', $id)->delete();
            $job->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    private function updateFullTextSearch($job)
    {
        $str = '';
        $str .= ' ' . $job->getCountry('country');
        $str .= ' ' . $job->getState('state');
        $str .= ' ' . $job->getCity('city');
        $str .= ' ' . $job->title;
        $str .= ' ' . $job->company_organize_name;
        $str .= ' ' . $job->description;
//        $str .= ' ' . $job->islamic_data;
//        $str .= ' ' . $job->islamic_data_detail;
//        $str .= ' ' . $job->islamic_data_to;
        $str .= ' ' . $job->gregorian_data;
//        $str .= ' ' . $job->islamic_data_detail_to;
        $str .= ' ' . $job->gregorian_data_to;
//        $str .= ' ' . $job->gregorian_data_detail_to;
//        $str .= ' ' . $job->gregorian_data_detail;
        $str .= ' ' . $job->expiry_date;
        $str .= ' ' . $job->Duration_course;
        $job->search = $str;
        $job->update();
    }

    private function assignJobValues($job, $request)
    {


            $job->title = $request->input('title');
            $job->company_organize_name = $request->input('company_organize_name');
            $job->description = $request->input('description');
            $job->country_id = $request->input('country_id');
            $job->state_id = $request->input('state_id');
            $job->city_id = $request->input('city_id');
        $job->is_active = 1;
//            $job->islamic_data = $request->input('islamic_data');
//            $job->islamic_data_detail = $request->input('islamic_data_detail');
            $job->gregorian_data =  $request->input('gregorian_data');
//            $job->gregorian_data_detail =  $request->input('gregorian_data_detail');
//            $job->islamic_data_to= $request->input('islamic_data_to') ;
//            $job->islamic_data_detail_to =$request->input('islamic_data_detail_to');
            $job->gregorian_data_to=  $request->input('gregorian_data_to');
//            $job->gregorian_data_detail_to=  $request->input('gregorian_data_detail_to');
            $job->duration_course =  $request->input('duration_course');
            $job->Initiatives_type	 = $request->input('Initiatives_type');
            $job->expiry_date = $request->input('expiry_date');

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                if (!empty($image)) {
                    \Storage::disk('s3')->delete('company_logos' . $image);
                    // File::delete(ImgUploader::real_public_path() . 'amen_project/logo' . $image);
                }
                $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('title'), false);

                $job->logo = $fileName;
            }


        return $job;
    }
    private function assignJobValuesBack($job, $request)
    {


        $job->title = $request->input('title');
        $job->company_organize_name = $request->input('company_organize_name');
        $job->description = $request->input('description');
        $job->country_id = $request->input('country_id');
        $job->state_id = $request->input('state_id');
        $job->city_id = $request->input('city_id');
        $job->is_active = 1;
//        $job->islamic_data = $request->input('islamic_data');
//        $job->islamic_data_detail = $request->input('islamic_data_detail');
        $job->gregorian_data =  $request->input('gregorian_data');
//        $job->gregorian_data_detail =  $request->input('gregorian_data_detail');
//        $job->islamic_data_to= $request->input('islamic_data_to') ;
//        $job->islamic_data_detail_to =$request->input('islamic_data_detail_to');
        $job->gregorian_data_to=  $request->input('gregorian_data_to');
//        $job->gregorian_data_detail_to=  $request->input('gregorian_data_detail_to');
        $job->duration_course =  $request->input('duration_course');
        $job->Initiatives_type	 = $request->input('Initiatives_type');
        $job->expiry_date = $request->input('expiry_date');

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            if (!empty($image)) {
                \Storage::disk('s3')->delete('company_logos' . $image);
                // File::delete(ImgUploader::real_public_path() . 'amen_project/logo' . $image);
            }
            $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('title'), false);
            $job->logo = $fileName;
        }

        return $job;
        }


    public function createJob()
    {
        $companies = DataArrayHelper::companiesArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $currencies = DataArrayHelper::currenciesArray();
        $careerLevels = DataArrayHelper::defaultCareerLevelsArray();
        $functionalAreas = DataArrayHelper::defaultFunctionalAreasArray();
        $jobTypes = DataArrayHelper::defaultJobTypesArray();
        $jobShifts = DataArrayHelper::defaultJobShiftsArray();
        $genders = DataArrayHelper::defaultGendersArray();
        $jobExperiences = DataArrayHelper::defaultJobExperiencesArray();
        $jobSkills = DataArrayHelper::defaultJobSkillsArray();
        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();
        $salaryPeriods = DataArrayHelper::defaultSalaryPeriodsArray();
        $jobSkillIds = array();
        return view('admin.initiatives.add')
                        ->with('companies', $companies)
                        ->with('countries', $countries)
                        ->with('currencies', array_unique($currencies))
                        ->with('careerLevels', $careerLevels)
                        ->with('functionalAreas', $functionalAreas)
                        ->with('jobTypes', $jobTypes)
                        ->with('jobShifts', $jobShifts)
                        ->with('genders', $genders)
                        ->with('jobExperiences', $jobExperiences)
                        ->with('jobSkills', $jobSkills)
                        ->with('jobSkillIds', $jobSkillIds)
                        ->with('degreeLevels', $degreeLevels)
                        ->with('salaryPeriods', $salaryPeriods);
    }

    public function storeJob(InitiativesBackFormRequest $request)
    {

        $job = new Job();
//        $company = Auth::guard('admin')->user();
        $job->company_id = $request->employee_id;
        $job = $this->assignJobValuesBack($job, $request);
        $job->is_active = $request->input('is_active');
        $job->is_featured = $request->input('is_featured');
        $job->save();
        /*         * ******************************* */
        $job->slug = str_slug($job->title, '-') . '-' . $job->id;
        /*         * ******************************* */
        $job->update();
        /*         * ************************************ */
        /*         * ************************************ */
//        $this->storeJobSkills($request, $job->id);
        /*         * ************************************ */
        $this->updateFullTextSearch($job);
        /*         * ************************************ */
        flash(__('Initiatives has been added!'))->success();
        $assign_employee = Employee::where('id',$request->employee_id)->first();
        $send_employee = Employee::where('id',1)->first();
        $data['company_id'] = $send_employee->id;
        $data['company_name'] = $send_employee->name;
        $data['from_id'] = $send_employee->id;
        $data['to_id'] =  $assign_employee->id;
        $data['from_name'] = $send_employee->name;
        $data['from_email'] = $send_employee->email;
        $data['from_phone'] = $send_employee->phone;
        $data['subject'] = __('Initiative Officer :');
        $data['message_txt'] = __('You have been added to be responsible for this initiative :'). $request->input('title');;
        $data['to_email'] = $assign_employee->email;
        $data['to_name'] = $assign_employee->name;
        $msg_save = CompanyMessage::create($data);


        Mail::send(new CompanyContactMail($data));
        if($request->Initiatives_type ==1)
        {
                return redirect('admin/list-initiatives'.'?Initiatives_type=Learning');
//            return \Redirect::route('edit.initiatives', array($job->id));
        }
        elseif ($request->Initiatives_type ==2)
        {
            return redirect('admin/list-initiatives'.'?Initiatives_type=Training');
//            return \Redirect::route('edit.initiatives', array($job->id));
        };


    }

    public function editJob($id)
    {
        $companies = DataArrayHelper::companiesArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $currencies = DataArrayHelper::currenciesArray();
        $careerLevels = DataArrayHelper::defaultCareerLevelsArray();
        $functionalAreas = DataArrayHelper::defaultFunctionalAreasArray();
        $jobTypes = DataArrayHelper::defaultJobTypesArray();
        $jobShifts = DataArrayHelper::defaultJobShiftsArray();
        $genders = DataArrayHelper::defaultGendersArray();
        $jobExperiences = DataArrayHelper::defaultJobExperiencesArray();
        $jobSkills = DataArrayHelper::defaultJobSkillsArray();
        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();
        $salaryPeriods = DataArrayHelper::defaultSalaryPeriodsArray();

        $job = Job::findOrFail($id);
        $job->employee_id= $job->company_id;
        $jobSkillIds = $job->getJobSkillsArray();
        return view('admin.initiatives.edit')
                        ->with('companies', $companies)
                        ->with('countries', $countries)
                        ->with('currencies', array_unique($currencies))
                        ->with('careerLevels', $careerLevels)
                        ->with('functionalAreas', $functionalAreas)
                        ->with('jobTypes', $jobTypes)
                        ->with('jobShifts', $jobShifts)
                        ->with('genders', $genders)
                        ->with('jobExperiences', $jobExperiences)
                        ->with('jobSkills', $jobSkills)
                        ->with('jobSkillIds', $jobSkillIds)
                        ->with('degreeLevels', $degreeLevels)
                        ->with('salaryPeriods', $salaryPeriods)
                        ->with('job', $job);
    }

    public function updateJob($id, InitiativesBackFormRequest $request)
    {

//        $company = Auth::guard('admin')->user();
        $job = Job::findOrFail($id);
        $job->company_id =$request->employee_id;
        $job = $this->assignJobValuesBack($job, $request);
        $job->is_active = $request->input('is_active');
        $job->is_featured = $request->input('is_featured');

        /*         * ******************************* */
        $job->slug = str_slug($job->title, '-') . '-' . $job->id;
        /*         * ******************************* */

        /*         * ************************************ */
        $job->update();
        /*         * ************************************ */
        $this->storeJobSkills($request, $job->id);
        /*         * ************************************ */
        $this->updateFullTextSearch($job);
        /*         * ************************************ */
        flash(__('Initiatives has been updated!'))->success();
        $assign_employee = Employee::where('id',$request->employee_id)->first();
        $send_employee = Employee::where('id',1)->first();
        $data['company_id'] = $send_employee->id;
        $data['company_name'] = $send_employee->name;
        $data['from_id'] = $send_employee->id;
        $data['to_id'] =  $assign_employee->id;
        $data['from_name'] = $send_employee->name;
        $data['from_email'] = $send_employee->email;
        $data['from_phone'] = $send_employee->phone;
        $data['subject'] = __('Initiative Officer :');
        $data['message_txt'] = __('You have been added to be responsible for this initiative :'). $request->input('title');;
        $data['to_email'] = $assign_employee->email;
        $data['to_name'] = $assign_employee->name;
        $msg_save = CompanyMessage::create($data);


        Mail::send(new CompanyContactMail($data));
        if ($job->Initiatives_type== "2"){
            return redirect(url("admin/edit-initiatives/$job->id"."?Initiatives_type=Training"));
        }
        elseif($job->Initiatives_type== "1"){
            return redirect(url("admin/edit-initiatives/$job->id"."?Initiatives_type=Learning"));

        }
//        return \Redirect::route('edit.Initiatives', array($job->id));
    }

    /*     * *************************************** */
    /*     * *************************************** */

    public function createFrontInitiatives()
    {

        $company = Auth::guard('employee')->user();

//
//		if ((bool)$company->is_active === false) {
//            flash(__('Your account is inactive contact site admin to activate it'))->error();
//            return \Redirect::route('company.home');
//            exit;
//        }
//		if((bool)config('company.is_company_package_active')){
//			if(
//				($company->package_end_date === null) ||
//				($company->package_end_date->lt(Carbon::now())) ||
//				($company->jobs_quota <= $company->availed_jobs_quota)
//				)
//			{
//				flash(__('Please subscribe to package first'))->error();
//				return \Redirect::route('company.home');
//				exit;
//			}
//		}
        
		$countries = DataArrayHelper::langCountriesArray();
        $currencies = DataArrayHelper::currenciesArray();
        $careerLevels = DataArrayHelper::langCareerLevelsArray();
        $functionalAreas = DataArrayHelper::langFunctionalAreasArray();
        $jobTypes = DataArrayHelper::langJobTypesArray();
        $jobShifts = DataArrayHelper::langJobShiftsArray();
        $genders = DataArrayHelper::langGendersArray();
        $jobExperiences = DataArrayHelper::langJobExperiencesArray();
        $jobSkills = DataArrayHelper::langJobSkillsArray();
        $degreeLevels = DataArrayHelper::langDegreeLevelsArray();
        $salaryPeriods = DataArrayHelper::langSalaryPeriodsArray();
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
        $jobSkillIds = array();
        return view('Initiatives.add_edit_job')
                        ->with('countries', $countries)
                        ->with('currencies', array_unique($currencies))
                        ->with('careerLevels', $careerLevels)
                        ->with('functionalAreas', $functionalAreas)
                        ->with('jobTypes', $jobTypes)
                        ->with('jobShifts', $jobShifts)
                        ->with('genders', $genders)
                        ->with('jobExperiences', $jobExperiences)
                        ->with('jobSkills', $jobSkills)
                        ->with('jobSkillIds', $jobSkillIds)
                        ->with('degreeLevels', $degreeLevels)
            ->with('projects',$projects)
                        ->with('salaryPeriods', $salaryPeriods);
    }

    public function storeFrontInitiatives (InitiativesFrontFormRequest $request)
    {

        $company = Auth::guard('employee')->user();
//        $company = Auth::guard('company')->user();

        $job = new Job();
        $job->company_id = $company->id;

        $job = $this->assignJobValues($job, $request);

        $job->save();

        /*         * ******************************* */
        $job->slug = str_slug($job->title, '-') . '-' . $job->id;
        /*         * ******************************* */
        $job->update();

        /*         * ************************************ */
//        $this->storeJobSkills($request, $job->id);
      /*         * ************************************ */

        $this->updateFullTextSearch($job);
        /*         * ************************************ */

        /*         * ******************************* */
//        $company->availed_jobs_quota = $company->availed_jobs_quota + 1;
//        $company->update();
        /*         * ******************************* */

//        event(new JobPosted($job));
        flash(__('Initiatives has been added!'))->success();
        if($job->Initiatives_type == 1){

            return redirect(url('/post-initiatives')."?Initiatives_type=Education");
        }



                                elseif($job->Initiatives_type== 2){
                                    return redirect(url('/post-initiatives')."?Initiatives_type=Training");

                                }

                                elseif($job->Initiatives_type== 0){
                                    return redirect( url('/post-initiatives')."?Initiatives_type=Recruiting");

                                }


    }

    public function editFrontInitiatives($id)
    {
        $countries = DataArrayHelper::langCountriesArray();
        $currencies = DataArrayHelper::currenciesArray();
        $careerLevels = DataArrayHelper::langCareerLevelsArray();
        $functionalAreas = DataArrayHelper::langFunctionalAreasArray();
        $jobTypes = DataArrayHelper::langJobTypesArray();
        $jobShifts = DataArrayHelper::langJobShiftsArray();
        $genders = DataArrayHelper::langGendersArray();
        $jobExperiences = DataArrayHelper::langJobExperiencesArray();
        $jobSkills = DataArrayHelper::langJobSkillsArray();
        $degreeLevels = DataArrayHelper::langDegreeLevelsArray();
        $salaryPeriods = DataArrayHelper::langSalaryPeriodsArray();

        $job = Job::findOrFail($id);
        $job->gregorian_data=  date('Y-m-d', strtotime($job->gregorian_data)) ;
        $job->gregorian_data_to= date('Y-m-d', strtotime($job->gregorian_data_to)) ;
        $job->expiry_date=  date('Y-m-d', strtotime($job->expiry_date)) ;

        $jobSkillIds = $job->getJobSkillsArray();
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
        return view('Initiatives.add_edit_job')
                        ->with('countries', $countries)
                        ->with('currencies', array_unique($currencies))
                        ->with('careerLevels', $careerLevels)
                        ->with('functionalAreas', $functionalAreas)
                        ->with('jobTypes', $jobTypes)
                        ->with('jobShifts', $jobShifts)
                        ->with('genders', $genders)
                        ->with('jobExperiences', $jobExperiences)
                        ->with('jobSkills', $jobSkills)
                        ->with('jobSkillIds', $jobSkillIds)
                        ->with('degreeLevels', $degreeLevels)
                        ->with('salaryPeriods', $salaryPeriods)
                         ->with('projects',$projects)
                        ->with('job', $job);

    }

    public function updateFrontInitiatives($id, InitiativesFrontFormRequest $request)
    {
        $job = Job::findOrFail($id);
		$job = $this->assignJobValues($job, $request);
        /*         * ******************************* */
        $job->slug = str_slug($job->title, '-') . '-' . $job->id;
        /*         * ******************************* */

        /*         * ************************************ */
        $job->update();
        /*         * ************************************ */
//        $this->storeJobSkills($request, $job->id);
        /*         * ************************************ */
        $this->updateFullTextSearch($job);
        /*         * ************************************ */
        flash(__('Initiatives has been updated!'))->success();



//        return \Redirect::route('edit.front.Initiatives', array($job->id));

        if($job->Initiatives_type == 1){

            return redirect(url('/posted-initiatives/')."?Initiatives_type=Education");
        }



        elseif($job->Initiatives_type== 2){
            return redirect(url('/posted-initiatives/')."?Initiatives_type=Training");

        }

        elseif($job->Initiatives_type== 0){
            return redirect( url('/posted-initiatives/')."?Initiatives_type=Recruiting");

        }

    }

    public static function countNumJobs($field = 'title', $value = '',$Initiatives_type='')
    {

        if (!empty($value)) {
            if ($field == 'title') {
                return DB::table('jobs')->where('title', 'like', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'company_id') {
                return DB::table('jobs')->where('company_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'industry_id') {
                $company_ids = Company::where('industry_id', '=', $value)->where('is_active', '=', 1)->pluck('id')->toArray();
                return DB::table('jobs')->whereIn('company_id', $company_ids)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'job_skill_id') {
                $job_ids = JobSkillManager::where('job_skill_id', '=', $value)->pluck('job_id')->toArray();
                return DB::table('jobs')->whereIn('id', array_unique($job_ids))->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'functional_area_id') {
                return DB::table('jobs')->where('functional_area_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'careel_level_id') {
                return DB::table('jobs')->where('careel_level_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'job_type_id') {
                return DB::table('jobs')->where('job_type_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'job_shift_id') {
                return DB::table('jobs')->where('job_shift_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'gender_id') {
                return DB::table('jobs')->where('gender_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'degree_level_id') {
                return DB::table('jobs')->where('degree_level_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'job_experience_id') {
                return DB::table('jobs')->where('job_experience_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'country_id') {
                return DB::table('jobs')->where('country_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'state_id') {
                return DB::table('jobs')->where('state_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'city_id') {
                return DB::table('jobs')->where('city_id', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
//            if ($field == 'islamic_data') {
//                return DB::table('jobs')->where('islamic_data', '=', $value)->where('is_active', '=', 1)->count('id');
//            }
//            if ($field == 'islamic_data_detail') {
//                return DB::table('jobs')->where('islamic_data_detail', '=', $value)->where('is_active', '=', 1)->count('id');
//            }
            if ($field == 'gregorian_data') {
                return DB::table('jobs')->where('gregorian_data', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
//            if ($field == 'islamic_data_to') {
//                return DB::table('jobs')->where('islamic_data_to', '=', $value)->where('is_active', '=', 1)->count('id');
//            }
//            if ($field == 'islamic_data_detail_to') {
//                return DB::table('jobs')->where('islamic_data_detail_to', '=', $value)->where('is_active', '=', 1)->count('id');
//            }
            if ($field == 'gregorian_data_to') {
                return DB::table('jobs')->where('gregorian_data_to', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'duration_course') {
                return DB::table('jobs')->where('duration_course', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'Initiatives_type') {
                return DB::table('jobs')->where('Initiatives_type', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
            if ($field == 'company_organize_name') {
                return DB::table('jobs')->where('company_organize_name', '=', $value)->where('is_active', '=', 1)->where('Initiatives_type', '=', $Initiatives_type)->count('id');
            }
//            if ($field == 'gregorian_data_detail') {
//                return DB::table('jobs')->where('gregorian_data_detail', '=', $value)->where('is_active', '=', 1)->count('id');
//            }
//            if ($field == 'gregorian_data_detail_to') {
//                return DB::table('jobs')->where('gregorian_data_detail_to', '=', $value)->where('is_active', '=', 1)->count('id');
//            }
        }
    }

    public function scopeNotExpire($query)
    {
        return $query->whereDate('expiry_date', '>', Carbon::now()); //where('expiry_date', '>=', date('Y-m-d'));
    }
    
    public function isJobExpired()
    {
        return ($this->expiry_date < Carbon::now())? true:false;
    }
    public function joinInitiatives($id)
    {
        $job = Job::where('id', $id)->first();
        return view('Initiatives.join_initiatives')->with('job', $job);
    }

    public function joinInitiativesPost(JoinInitiativsFormRequest $request, $id)
    {
        $JoinInitiatives = new JoinInitiatives;



        $JoinInitiatives->job_id   = $id;
        $JoinInitiatives->name = $request->input('your_name');
        $JoinInitiatives->email   = $request->input('email');
        $JoinInitiatives->phone     = $request->input('phone');

        $JoinInitiatives->save();
        $job = Job::where('id', $id)->first();
//        $msg_save = JoinInitiatives::create($data);
//        $when = Carbon::now()->addMinutes(5);
//        Mail::send(new \App\Mail\JoinInitiatives($JoinInitiatives));
        flash(__('The initiative has been successfully registered and you will be contacted later if you are accepted'))->success();
        return Redirect::route('Initiatives.detail', [$job->slug]);


    }
    public function joinInitiativesList($id)
    {
        $joininitiatives = JoinInitiatives::where('job_id', $id)->paginate(10);

        return view('Initiatives.join_list')->with('joininitiatives', $joininitiatives);
    }


}
