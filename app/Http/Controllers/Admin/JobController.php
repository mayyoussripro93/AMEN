<?php

namespace App\Http\Controllers\Admin;

use App\Project;
use Auth;
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

class JobController extends Controller
{

    use JobTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexJobs()
    {
        $companies = DataArrayHelper::companiesArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $query_project=Project::select('*');

//        if (Auth::guard('employee')->user()->employee_role_id==1) {
//
//        }
//        elseif(Auth::guard('employee')->user()->employee_role_id==2){
//            $query_project->where('state_id', Auth::guard('employee')->user()->state_id);
//        }
//        else{
//            $query_project->join('projects_assigns', 'projects_assigns.project_id', '=', 'projects.id')
//                ->select('projects.*', 'projects_assigns.employee_id')
//                ->where('projects_assigns.employee_id', [Auth::guard('employee')->user()->id])
//            ;
//        }

        $projects= $query_project->pluck('name', 'id')->toArray();

        return view('admin.job.index')
                        ->with('companies', $companies)
                         ->with('projects',$projects)
                        ->with('countries', $countries);
    }

    public function fetchJobsData(Request $request)
    {
//        $jobs = Job::select([
//                    'jobs.id', 'jobs.company_id', 'jobs.title', 'jobs.description', 'jobs.country_id', 'jobs.state_id', 'jobs.city_id', 'jobs.is_freelance', 'jobs.career_level_id', 'jobs.salary_from', 'jobs.salary_to', 'jobs.hide_salary', 'jobs.functional_area_id', 'jobs.job_type_id', 'jobs.job_shift_id', 'jobs.num_of_positions', 'jobs.gender_id', 'jobs.expiry_date', 'jobs.degree_level_id', 'jobs.job_experience_id', 'jobs.is_active', 'jobs.is_featured',
//        ]);

        $jobs = Job::select([
            'jobs.id', 'jobs.company_id','jobs.company_organize_name', 'jobs.project_id', 'jobs.title', 'jobs.description', 'jobs.country_id', 'jobs.state_id', 'jobs.city_id', 'jobs.is_freelance', 'jobs.career_level_id', 'jobs.salary_from', 'jobs.salary_to', 'jobs.hide_salary', 'jobs.functional_area_id', 'jobs.job_type_id', 'jobs.job_shift_id', 'jobs.num_of_positions', 'jobs.gender_id', 'jobs.expiry_date', 'jobs.degree_level_id', 'jobs.job_experience_id', 'jobs.is_active', 'jobs.duration_course',
            'jobs.islamic_data', 'jobs.islamic_data_detail', 'jobs.gregorian_data', 'jobs.islamic_data_to', 'jobs.islamic_data_detail_to', 'jobs.gregorian_data_to', 'jobs.Initiatives_type', 'jobs.slug', 'jobs.logo',
        ]);
        return Datatables::of($jobs)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('project_id') && !empty($request->project_id)) {
                                $query->where('jobs.project_id', '=', "{$request->get('project_id')}");
                            }
                            if ($request->has('title') && !empty($request->title)) {
                                $query->where('jobs.title', 'like', "%{$request->get('title')}%");
                            }
                            if ($request->has('description') && !empty($request->description)) {
                                $query->where('jobs.description', 'like', "%{$request->get('description')}%");
                            }
                            if ($request->has('country_id') && !empty($request->country_id)) {
                                $query->where('jobs.country_id', '=', "{$request->get('country_id')}");
                            }
                            if ($request->has('state_id') && !empty($request->state_id)) {
                                $query->where('jobs.state_id', '=', "{$request->get('state_id')}");
                            }
                            if ($request->has('city_id') && !empty($request->city_id)) {
                                $query->where('jobs.city_id', '=', "{$request->get('city_id')}");
                            }
                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('jobs.is_active', '=', "{$request->get('is_active')}");
                            }
                            if ($request->has('is_featured') && $request->is_featured != -1) {
                                $query->where('jobs.is_featured', '=', "{$request->get('is_featured')}");
                            }
                            $query->where('jobs.Initiatives_type', 0);
                        })
                        ->addColumn('project_id', function ($jobs) {
                           $proj_name= Project::where('id',$jobs->project_id)->first();
                            return $proj_name->name;
                        })

                        ->addColumn('city_id', function ($jobs) {
                            return $jobs->getCity('city') . '(' . $jobs->getState('state') . '-' . $jobs->getCountry('country') . ')';
                        })
                        ->addColumn('description', function ($jobs) {
                            return strip_tags(str_limit($jobs->description, 50, '...'));
                        })
                        ->addColumn('action', function ($jobs) {
                            /*                             * ************************* */
//                            $activeTxt = 'Make Active';
//                            $activeHref = 'makeActive(' . $jobs->id . ');';
//                            $activeIcon = 'square-o';
//                            if ((int) $jobs->is_active == 1) {
//                                $activeTxt = 'Make InActive';
//                                $activeHref = 'makeNotActive(' . $jobs->id . ');';
//                                $activeIcon = 'check-square-o';
//                            }
//                            $featuredTxt = 'Make Featured';
//                            $featuredHref = 'makeFeatured(' . $jobs->id . ');';
//                            $featuredIcon = 'square-o';
//                            if ((int) $jobs->is_featured == 1) {
//                                $featuredTxt = 'Make Not Featured';
//                                $featuredHref = 'makeNotFeatured(' . $jobs->id . ');';
//                                $featuredIcon = 'check-square-o';
//                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.job', ['id' => $jobs->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteJob(' . $jobs->id . ', ' . $jobs->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						

																																							
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'project_id', 'city_id', 'description'])
                        ->setRowId(function($jobs) {
                            return 'jobDtRow' . $jobs->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_active = 1;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_active = 0;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }
    public function ProjectStates(Request $request)
    {
       $project= Project::where('id',$request->project_id)->first();
return $project->state_id ;
    }
    public function makeFeaturedJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_featured = 1;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotFeaturedJob(Request $request)
    {
        $id = $request->input('id');
        try {
            $job = Job::findOrFail($id);
            $job->is_featured = 0;
            $job->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function ProjectEmployeeDropdown(Request $request)
    {
        $project_id = $request->input('project_id');
        $state_id = $request->input('employee_id');
        $new_state_id = $request->input('new_state_id', 'employee_id');

        $assignees=Project::findOrfail($project_id)->assignees()->get();
        $safeties=$assignees->where('employee_role_id',3)->toArray();
        $project_managers=$assignees->where('employee_role_id',4)->toArray();

        $contractor_managers=$assignees->where('employee_role_id',5)->toArray();

//        $dd = Form::select('employee_id', ['' => __('Select Employee').' *'] + $assignees, $state_id, array('id' => $new_state_id, 'class' => 'form-control'));
        if (count($assignees )==0  ){
            $dd='<select   id="employee_id"  name="employee_id"   class="form-control "style="width: 100%"  required="true" >';
            $dd .='<option value=" "> '.__('NO Employee').'</option></select>';

        }else{
            $dd ='<select  id="employee_id"  name="employee_id"  class="form-control"  style="width: 100%"  required="true" >' ;
            if (count($safeties ) !=0  ){
                $dd .='<optgroup label= "استشاري السلامة" >';
                        foreach ($safeties as $safetie){
                            if($safetie['id']== $state_id)
                            $dd .='<option value="'.$safetie['id'].'"  selected  > '.$safetie['name'].'</option>';
                            else
                                $dd .='<option value="'.$safetie['id'].'"    > '.$safetie['name'].'</option>';

                        }
                    }
                    if (count($project_managers ) !=0  ) {

                        $dd .= ' </optgroup><optgroup label= "استشاري المشروع" >';

                        foreach ($project_managers as $project_manager) {
                            if($project_manager['id']== $state_id)
                                $dd .='<option value="'.$project_manager['id'].'"  selected  > '.$project_manager['name'].'</option>';
                            else
                            $dd .= '<option value="' . $project_manager['id'] . '"> ' . $project_manager['name'] . '</option>';
                        }
                    }
                    if (count($contractor_managers ) !=0  ) {
                        $dd .= ' </optgroup><optgroup label= ' . __('Contractor') . ' >';
                        foreach ($contractor_managers as $contractor_manager) {
                            if($contractor_manager['id']== $state_id)
                                $dd .='<option value="'.$contractor_manager['id'].'"  selected  > '.$contractor_manager['name'].'</option>';
                            else


                            $dd .= '<option value="' . $contractor_manager['id'] . '"> ' . $contractor_manager['name'] . '</option>';
                        }
                    }
                    $dd .=' </optgroup>';
                    $dd .='</select>'  ;
                }

        echo $dd;

    }

}
