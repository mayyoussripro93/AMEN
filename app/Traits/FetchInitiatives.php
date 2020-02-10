<?php

namespace App\Traits;

use App\Employee;
use DB;
use App\Job;
use App\Company;
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
use App\Traits\InitiativesTrait;

trait FetchInitiatives
{

    use InitiativesTrait;

    private $fields = array(
        'jobs.id',
        'jobs.company_id',
        'jobs.title',
        'jobs.company_organize_name',
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
        'jobs.duration_course',
        'jobs.islamic_data',
        'jobs.islamic_data_detail',
        'jobs.gregorian_data',
        'jobs.islamic_data_to',
        'jobs.islamic_data_detail_to',
        'jobs.gregorian_data_to',
        'jobs.is_featured',
        'jobs.Initiatives_type',
        'jobs.slug',
        'jobs.created_at',
        'jobs.updated_at',
        'jobs.logo'
    );

    public function fetchJobs($search = '', $job_titles = array(),  $company_ids = array(), $industry_ids = array(), $job_skill_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $is_freelance = -1, $career_level_ids = array(), $job_type_ids = array(), $job_shift_ids = array(), $gender_ids = array(), $degree_level_ids = array(), $job_experience_ids = array(), $salary_from = 0, $salary_to = 0, $salary_currency = '', $is_featured = -1, $gregorian_data = '', $gregorian_data_to = '', $duration_course = '',$Initiatives_type='', $orderBy = 'id', $limit = 10)
    {

        $asc_desc = 'DESC';
        $query = Job::select($this->fields);
        $query = $this->createQuery($query, $search, $job_titles,  $company_ids, $industry_ids, $job_skill_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $is_freelance, $career_level_ids, $job_type_ids, $job_shift_ids, $gender_ids, $degree_level_ids, $job_experience_ids, $salary_from, $salary_to, $salary_currency,$gregorian_data,$gregorian_data_to,$duration_course,$Initiatives_type,$is_featured);

//        $query->orderBy('jobs.is_featured', 'DESC');
        $query->orderBy('jobs.created_at', 'DESC');

//        echo $query->toSql();exit;
        return $query->paginate($limit);
    }

    public function fetchIdsArray($search = '', $job_titles = array(),  $company_ids = array(), $industry_ids = array(), $job_skill_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $is_freelance = -1, $career_level_ids = array(), $job_type_ids = array(), $job_shift_ids = array(), $gender_ids = array(), $degree_level_ids = array(), $job_experience_ids = array(), $salary_from = 0, $salary_to = 0,$is_featured = -1, $salary_currency = '', $gregorian_data = '', $gregorian_data_to= '',$duration_course = '',$Initiatives_type='',$field = 'jobs.id')
    {
        $query = Job::select($field);
        $query = $this->createQuery($query, $search, $job_titles,  $company_ids, $industry_ids, $job_skill_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $is_freelance, $career_level_ids, $job_type_ids, $job_shift_ids, $gender_ids, $degree_level_ids, $job_experience_ids, $salary_from, $salary_to, $salary_currency,$gregorian_data,$gregorian_data_to,$duration_course,$Initiatives_type,$is_featured);

        $array = $query->pluck($field)->toArray();
        return array_unique($array);
    }

    public function createQuery($query, $search = '', $job_titles = array(),  $company_ids = array(), $industry_ids = array(), $job_skill_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $is_freelance = -1, $career_level_ids = array(), $job_type_ids = array(), $job_shift_ids = array(), $gender_ids = array(), $degree_level_ids = array(), $job_experience_ids = array(), $salary_from = 0, $salary_to = 0, $salary_currency = '', $gregorian_data = '', $gregorian_data_to = '',$duration_course = '',$Initiatives_type='',$is_featured = -1)
    {
    
        $active_company_ids_array = Employee::where('is_active', 1)->pluck('id')->toArray();
        if (isset($company_ids[0]) && isset($active_company_ids_array[0])) {
            $company_ids = array_intersect($active_company_ids_array, $company_ids);
        }
        if (isset($industry_ids[0])) {
            $company_ids_array = Employee::whereIn('industry_id', $industry_ids)->pluck('id')->toArray();
            if (isset($company_ids[0]) && isset($company_ids_array[0])) {
                $company_ids = array_intersect($company_ids_array, $company_ids);
            }
        }
        $company_ids = array_values($company_ids);

        if ($Initiatives_type == 'Training'){
            $query->where('jobs.Initiatives_type', 2);
        }
        elseif($Initiatives_type == 'all') {
        }
        elseif($Initiatives_type == 'Learning'){
        $query->where('jobs.Initiatives_type', 1);
    };
//            $query->where('jobs.is_active', 1);
        if ($search != '') {
            $query = $query->whereRaw("MATCH (`search`) AGAINST ('$search*' IN BOOLEAN MODE)");
        }
        if (isset($job_titles[0])) {
            $query = $query->where('title', 'like', $job_titles[0]);
        }
        if (isset($company_ids[0])) {
            $query->whereIn('jobs.company_id', $company_ids);
        }

        if (isset($country_ids[0])) {
            $query->whereIn('jobs.country_id', $country_ids);
        }
        if (isset($state_ids[0])) {
            $query->whereIn('jobs.state_id', $state_ids);
        }

        if (isset($city_ids[0])&& !empty($city_ids[0])) {
            $query->whereIn('jobs.city_id', $city_ids);
        }

        if ($is_featured == 1) {
            $query->where('jobs.is_featured', '=', $is_featured);
        }
//        if (isset($islamic_date[0])) {
//            $date= date( 'Y-m-d H:i:s', strtotime($islamic_date) );
//            $query = $query->whereDate('jobs.islamic_data', '>=', $date);
//
//        }
        if (isset($gregorian_data[0])) {

           $date= date( 'Y-m-d H:i:s', strtotime($gregorian_data) );

            $query = $query->whereDate('jobs.gregorian_data', '>=', $date);

        }
//        if (isset($islamic_data_to[0])) {
//            $date= date( 'Y-m-d H:i:s', strtotime($islamic_data_to) );
//
//            $query = $query->whereDate('jobs.islamic_data_to', '>=', $date);
//
//        }

        if (isset($gregorian_data_to[0])) {
            $date= date( 'Y-m-d H:i:s', strtotime($gregorian_data_to) );
            $query = $query->where('jobs.gregorian_data_to', '<=', $date);
//            $query = $query->whereDate('UNIX_TIMESTAMP(jobs.gregorian_data_to)', '<=', $gregorian_data_to);
        }
        if (isset($duration_course[0])) {
        $query = $query->where('jobs.duration_course', 'like', $duration_course);
    }

        $query->notExpire();
        return $query;
    }

    public function fetchSkillIdsArray($jobIdsArray = array())
    {
        $query = JobSkillManager::select('job_skill_id');
        $query->whereIn('job_id', $jobIdsArray);

        $array = $query->pluck('job_skill_id')->toArray();
        return array_unique($array);
    }

    public function fetchIndustryIdsArray($companyIdsArray = array())
    {
        $query = Employee::select('industry_id');
        $query->whereIn('id', $companyIdsArray);

        $array = $query->pluck('industry_id')->toArray();
        return array_unique($array);
    }

    private function getSEO($functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $career_level_ids = array(), $job_type_ids = array(), $job_shift_ids = array(), $gender_ids = array(), $degree_level_ids = array(), $job_experience_ids = array())
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

        if (isset($career_level_ids[0])) {
            foreach ($career_level_ids as $career_level_id) {
                $career_level = CareerLevel::where('career_level_id', $career_level_id)->lang()->first();
                if (null !== $career_level) {
                    $description .= ' ' . $career_level->career_level;
                    $keywords .= $career_level->career_level . ',';
                }
            }
        }
        if (isset($job_type_ids[0])) {
            foreach ($job_type_ids as $job_type_id) {
                $job_type = JobType::where('job_type_id', $job_type_id)->lang()->first();
                if (null !== $job_type) {
                    $description .= ' ' . $job_type->job_type;
                    $keywords .= $job_type->job_type . ',';
                }
            }
        }
        if (isset($job_shift_ids[0])) {
            foreach ($job_shift_ids as $job_shift_id) {
                $job_shift = JobShift::where('job_shift_id', $job_shift_id)->lang()->first();
                if (null !== $job_shift) {
                    $description .= ' ' . $job_shift->job_shift;
                    $keywords .= $job_shift->job_shift . ',';
                }
            }
        }
        if (isset($gender_ids[0])) {
            foreach ($gender_ids as $gender_id) {
                $gender = Gender::where('gender_id', $gender_id)->lang()->first();
                if (null !== $gender) {
                    $description .= ' ' . $gender->gender;
                    $keywords .= $gender->gender . ',';
                }
            }
        }
        if (isset($degree_level_ids[0])) {
            foreach ($degree_level_ids as $degree_level_id) {
                $degree_level = DegreeLevel::where('degree_level_id', $degree_level_id)->lang()->first();
                if (null !== $degree_level) {
                    $description .= ' ' . $degree_level->degree_level;
                    $keywords .= $degree_level->degree_level . ',';
                }
            }
        }
        if (isset($job_experience_ids[0])) {
            foreach ($job_experience_ids as $job_experience_id) {
                $job_experience = JobExperience::where('job_experience_id', $job_experience_id)->lang()->first();
                if (null !== $job_experience) {
                    $description .= ' ' . $job_experience->job_experience;
                    $keywords .= $job_experience->job_experience . ',';
                }
            }
        }
        return ['keywords' => $keywords, 'description' => $description];
    }

}
