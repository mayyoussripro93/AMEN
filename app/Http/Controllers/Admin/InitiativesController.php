<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Traits\InitiativesTrait;
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

class InitiativesController extends Controller
{

//    use JobTrait;
use InitiativesTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexInitiatives()
    {
        $companies = DataArrayHelper::companiesArray();
        $countries = DataArrayHelper::langCountriesArray();
        return view('admin.initiatives.index')
                        ->with('companies', $companies)
                        ->with('countries', $countries);
    }
    public function employeeStates(Request $request)
    {

        $employee_id= $request->input('employee_id');

        $state_id = $request->input('state_id');
        $assignees=Employee::where('state_id',$state_id)->get();
        $safeties=$assignees->where('employee_role_id',3)->toArray();
        $project_managers=$assignees->where('employee_role_id',4)->toArray();

        $contractor_managers=$assignees->where('employee_role_id',5)->toArray();

//        $dd = Form::select('employee_id', ['' => __('Select Employee').' *'] + $assignees, $state_id, array('id' => $new_state_id, 'class' => 'form-control'));
        if (count($assignees )==0  ){
            $dd='<select   id="employee_id"  name="employee_id"   class="form-control " style="width: 100%"  required="true" >';

            $dd .='<option value=" "> '.__('NO Employee').'</option></select>';

        }else{
            $dd='<select  id="employee_id"  name="employee_id"  class="form-control " style="width: 100%"  required="true" >';
            if (count($safeties ) !=0  ){
                $dd .='     <optgroup label= "استشاري السلامة" >';
                foreach ($safeties as $safetie){
                    if($safetie['id']== $employee_id)
                        $dd .='<option value="'.$safetie['id'].'"  selected  > '.$safetie['name'].'</option>';
                    else
                        $dd .='<option value="'.$safetie['id'].'"    > '.$safetie['name'].'</option>';
                }
            }
            if (count($project_managers ) !=0  ) {
                $dd .= ' </optgroup><optgroup label= "استشاري المشروع" >';

                foreach ($project_managers as $project_manager) {
                    if($project_manager['id']== $employee_id)

                        $dd .='<option value="'.$project_manager['id'].'"  selected  > '.$project_manager['name'].'</option>';
                else

                    $dd .= '<option value="' . $project_manager['id'] . '"> ' . $project_manager['name'] . '</option>';
                }
            }
            if (count($contractor_managers ) !=0  ) {
                $dd .= ' </optgroup><optgroup label= ' . __('Contractor') . ' >';
                foreach ($contractor_managers as $contractor_manager) {

                    if($contractor_manager['id']== $employee_id)
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
    public function fetchInitiativesData(Request $request)
    {

        $jobs = Job::select([
                    'jobs.id', 'jobs.company_id','jobs.company_organize_name', 'jobs.title', 'jobs.description', 'jobs.country_id', 'jobs.state_id', 'jobs.city_id', 'jobs.expiry_date',  'jobs.is_active', 'jobs.duration_course',
     'jobs.gregorian_data','jobs.gregorian_data_to', 'jobs.Initiatives_type', 'jobs.slug', 'jobs.logo',
        ]);


        return Datatables::of($jobs)
                        ->filter(function ($query) use ($request) {
//                            if ($request->has('company_id') && !empty($request->company_id)) {
//                                $query->where('jobs.company_id', '=', "{$request->get('company_id')}");
//                            }
                            if ($request->has('company_name') && !empty($request->company_name)) {
                                $query->where('jobs.company_organize_name', 'like', "%{$request->get('company_name')}%");
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
                            if ($request->has('start_data') && !empty($request->start_data)) {
                                $query->where('jobs.gregorian_data', 'like', "%{$request->get('start_data')}%");
                            }
                            if ($request->has('end_data') && !empty($request->end_data)) {
                                $query->where('jobs.gregorian_data_to', 'like', "%{$request->get('end_data')}%");
                            }
                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('jobs.is_active', '=', "{$request->get('is_active')}");
                            }
                            if ($request->has('is_featured') && $request->is_featured != -1) {
                                $query->where('jobs.is_featured', '=', "{$request->get('is_featured')}");
                            }
                            if (urldecode($_GET["Initiatives_type"])== 'Training'){
                                $query->where('jobs.Initiatives_type', 2);
                            }
                            elseif(urldecode($_GET["Initiatives_type"]) == 'Learning'){
                            $query->where('jobs.Initiatives_type', 1);
                            };

                        })
//                        ->addColumn('company_id', function ($jobs) {
//                            return $jobs->getCompany('name');
//                        })
                        ->addColumn('company_name', function ($jobs) {
                            return strip_tags(str_limit($jobs->company_organize_name, 50, '...'));
                        })
                        ->addColumn('city_id', function ($jobs) {
                            return $jobs->getCity('city') . '(' . $jobs->getState('state') . '-' . $jobs->getCountry('country') . ')';
                        })
                        ->addColumn('description', function ($jobs) {
                            return strip_tags(str_limit($jobs->description, 15, '...'));
                        })
                        ->addColumn('start_data', function ($jobs) {
                            return strip_tags(str_limit(date('Y-m-d',strtotime($jobs->gregorian_data)), 30, '...'));
                        })    ->addColumn('end_data', function ($jobs) {
                            return strip_tags(str_limit(date('Y-m-d',strtotime($jobs->gregorian_data_to)), 30, '...'));
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
                              $output = '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>';
					          if (urldecode($_GET["Initiatives_type"])== "Training"){
             $output .='          	<a href="' . url("admin/edit-initiatives/$jobs->id"."?Initiatives_type=Training"). '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>';
                            }
                            elseif(urldecode($_GET["Initiatives_type"]) == "Learning"){
                                $output .='	<a href="' . url("admin/edit-initiatives/$jobs->id"."?Initiatives_type=Learning"). '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>';
                            }

                            $output .=' 	</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteJob(' . $jobs->id . ', ' . $jobs->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
																																						
					</ul>
				</div>';
                            return $output ;
                        })
                        ->rawColumns(['action', 'company_name','city_id', 'description','end_data','start_data'])
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

}
