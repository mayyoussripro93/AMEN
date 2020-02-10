<?php

namespace App\Traits;

use DB;
use App\Job;
use App\Company;
use App\Employee;
use App\JobSkill;
use App\JobSkillManager;
use App\Country;
use App\State;
use App\City;
use App\CareerLevel;
use App\FunctionalArea;
use App\JobType;
use App\JobShift;
use App\Gender;
use App\JobExperience;
use App\DegreeLevel;
use App\Traits\JobTrait;
use PHPUnit\Framework\Warning;

trait FetchInitiatives3
{

    use InitiativesTrait;

    private $fields = array(
        'jobs.id',
        'jobs.company_id',
        'jobs.title',
        'jobs.description',
        'jobs.country_id',
        'jobs.state_id',
        'jobs.city_id',
        'jobs.is_freelance',
        'jobs.career_level_id',
        'jobs.salary_from',
        'jobs.salary_to',
        'jobs.hide_salary',
        'jobs.functional_area_id',
        'jobs.job_type_id',
        'jobs.job_shift_id',
        'jobs.num_of_positions',
        'jobs.gender_id',
        'jobs.expiry_date',
        'jobs.degree_level_id',
        'jobs.job_experience_id',
        'jobs.is_active',
        'jobs.is_featured',
        'jobs.slug',
        'jobs.duration_course',
        'jobs.islamic_data',
        'jobs.islamic_data_detail',
        'jobs.gregorian_data',
        'jobs.created_at',
        'jobs.updated_at'
    );

    public function fetchJobs($search = '', $job_titles = array(), $company_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $islamic_date = 0, $gregorian_data = 0, $duration_course = 0,$orderBy = 'id', $limit = 10)
    {

        $asc_desc = 'DESC';
        $query = Job::select($this->fields);
        $query = $this->createQuery($query, $search, $job_titles, $company_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $islamic_date,$gregorian_data, $duration_course);

        $query->orderBy('jobs.is_featured', 'DESC');
        $query->orderBy('jobs.id', 'DESC');
        //echo $query->toSql();exit;
        return $query->paginate($limit);
    }

//    public function fetchIdsArray($search = '', $job_titles = array(), $company_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(),$islamic_date = '', $gregorian_data = '', $duration_course = '', $field = 'jobs.id')
//    {
//
//        $query = Job::select($field);
//        $query = $this->createQuery($query, $search, $job_titles, $company_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $islamic_date,$gregorian_data, $duration_course );
//
//        $array = $query->pluck($field)->toArray();
//        return array_unique($array);
//    }
    public function fetchIdsArray($search = '', $job_titles = array(), $company_ids = array(), $industry_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $job_experience_ids = array(), $salary_from = 0, $salary_to = 0, $salary_currency = '', $is_featured = -1, $field = 'jobs.id')
    {
        $query = Job::select($field);
        $query = $this->createQuery($query, $search, $job_titles, $company_ids, $industry_ids, $job_skill_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $is_freelance, $career_level_ids, $job_type_ids, $job_shift_ids, $gender_ids, $degree_level_ids, $job_experience_ids, $salary_from, $salary_to, $salary_currency, $is_featured);

        $array = $query->pluck($field)->toArray();
        return array_unique($array);
    }
    public function createQuery($query, $search = '', $job_titles = array(), $company_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(),$islamic_date = 0, $gregorian_data = 0, $duration_course = 0 )
    {
    
        $active_company_ids_array = Employee::where('is_active', 1)->pluck('id')->toArray();
        if (isset($company_ids[0]) && isset($active_company_ids_array[0])) {
            $company_ids = array_intersect($active_company_ids_array, $company_ids);
        }
//        if (isset($industry_ids[0])) {
//            $company_ids_array = Employee::whereIn('industry_id', $industry_ids)->pluck('id')->toArray();
//            if (isset($company_ids[0]) && isset($company_ids_array[0])) {
//                $company_ids = array_intersect($company_ids_array, $company_ids);
//            }
//        }
        $company_ids = array_values($company_ids);
        
        $query->where('jobs.is_active', 1);
        if ($search != '') {
            $query = $query->whereRaw("MATCH (`search`) AGAINST ('$search*' IN BOOLEAN MODE)");
        }
        if (isset($job_titles[0])) {
            $query = $query->where('title', 'like', $job_titles[0]);
        }
        if (isset($company_ids[0])) {
            $query->whereIn('jobs.company_id', $company_ids);
        }        
//        if (isset($job_skill_ids[0])) {
//            $query->whereHas('jobSkills', function($query) use ($job_skill_ids) {
//                $query->whereIn('job_skill_id', $job_skill_ids);
//            });
            //$job_ids = JobSkillManager::whereIn('job_skill_id',$job_skill_ids)->pluck('job_id')->toArray();
            //$query->whereIn('jobs.id', $job_ids);
//        }
        if (isset($functional_area_ids[0])) {
            $query->whereIn('jobs.functional_area_id', $functional_area_ids);
        }
        if (isset($country_ids[0])) {
            $query->whereIn('jobs.country_id', $country_ids);
        }
        if (isset($state_ids[0])) {
            $query->whereIn('jobs.state_id', $state_ids);
        }
        if (isset($city_ids[0])) {
            $query->whereIn('jobs.city_id', $city_ids);
        }
        if (isset($islamic_date[0])) {
            $query = $query->where('title', 'like', $islamic_date[0]);
        }
        if (isset($gregorian_data[0])) {
        $query = $query->where('title', 'like', $gregorian_data[0]);
    }    if (isset($duration_course[0])) {
        $query = $query->where('title', 'like', $duration_course[0]);
    }
//        if ((int) $salary_from > 0) {
//            $query->where('jobs.salary_from', '>=', $salary_from);
//        }
//        if ((int) $salary_to > 0) {
//            $query = $query->whereRaw("(`jobs`.`salary_to` - $salary_to) >= 0");
//            //$query->where('jobs.salary_to', '<=', $salary_to);
//        }
//        if (!empty(trim($salary_currency))) {
//            $query->where('jobs.salary_currency', 'like', $salary_currency);
//        }
//        if ($is_featured == 1) {
//            $query->where('jobs.is_featured', '=', $is_featured);
//        }

        $query->notExpire();
        return $query;
    }

//    public function fetchSkillIdsArray($jobIdsArray = array())
//    {
//        $query = JobSkillManager::select('job_skill_id');
//        $query->whereIn('job_id', $jobIdsArray);
//
//        $array = $query->pluck('job_skill_id')->toArray();
//        return array_unique($array);
//    }
//
//    public function fetchIndustryIdsArray($companyIdsArray = array())
//    {
//        $query = Company::select('industry_id');
//        $query->whereIn('id', $companyIdsArray);
//
//        $array = $query->pluck('industry_id')->toArray();
//        return array_unique($array);
//    }

    private function getSEO($functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array())
    {
        $description = 'Jobs ';
        $keywords = '';
        if (isset($functional_area_ids[0])) {
            foreach ($functional_area_ids as $functional_area_id) {
                $functional_area = FunctionalArea::where('functional_area_id', $functional_area_id)->lang()->first();
                if (null !== $functional_area) {
                    $description .= ' ' . $functional_area->functional_area;
                    $keywords .= $functional_area->functional_area . ',';
                }
            }
        }
        if (isset($country_ids[0])) {
            foreach ($country_ids as $country_id) {
                $country = Country::where('country_id', $country_id)->lang()->first();
                if (null !== $country) {
                    $description .= ' ' . $country->country;
                    $keywords .= $country->country . ',';
                }
            }
        }
        if (isset($state_ids[0])) {
            foreach ($state_ids as $state_id) {
                $state = State::where('state_id', $state_id)->lang()->first();
                if (null !== $state) {
                    $description .= ' ' . $state->state;
                    $keywords .= $state->state . ',';
                }
            }
        }
        if (isset($city_ids[0])) {
            foreach ($city_ids as $city_id) {
                $city = City::where('city_id', $city_id)->lang()->first();
                if (null !== $city) {
                    $description .= ' ' . $city->city;
                    $keywords .= $city->city . ',';
                }
            }
        }
        return ['keywords' => $keywords, 'description' => $description];
    }

}
