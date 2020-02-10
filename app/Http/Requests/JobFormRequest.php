<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class JobFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'PUT':
            case 'POST': {
                    $id = (int) $this->input('id', 0);
                    $job_unique = '';
                    if ($id > 0) {
                        $job_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "",
                        "project_id" => "required",
                        "title" => "required",
                        "description" => "required",
                        "skills" => "required",
//                        "country_id" => "required",
                        "state_id" => "required",
                        "city_id" => "required",
                        "employee_id" => "required",
                        "salary_from" => "required",
                        "salary_to" => "required",
//                        "salary_currency" => "required",
//                        "salary_period_id" => "required",
//                        "hide_salary" => "required",
                        "functional_area_id" => "required",
//                        "job_type_id" => "required",
//                        "job_shift_id" => "required",
//                        "num_of_positions" => "required",
                        //"gender_id" => "required",
                        "expiry_date" => "required",
                        "degree_level_id" => "required",
                        "job_experience_id" => "required",
                        "is_active" => "required",
//                        "is_featured" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'project_id.required' => 'برجاء اختيار المشروع',
            'title.required' => 'برجاء إدخال اسم المشروع',
            'description.required' => 'برجاء إدخال شروط الالتحاق بالوظيفة',
            'skills.required' => 'برجاء اختيار مهارات الوظيفة',
//            'country_id.required' => 'Please select Country.',
//            'state_id.required' => 'Please select State.',
            'city_id.required' => 'برجاء اختيار المدينة',
//            'is_freelance.required' => 'Is this freelance Job?',
//            'career_level_id.required' => 'Please select Career level.',
            'salary_from.required' => 'برجاء اختيار الحد الأدنى للراتب',
            'salary_to.required' => 'برجاء اختيار الحد الأقصى للراتب',
//            'salary_currency.required' => 'Please select salary currency.',
//            'salary_period_id.required' => 'Please select salary period.',
//            'hide_salary.required' => 'Is salary hidden?',
            'functional_area_id.required' => 'برجاء اختيار المجال الوظيفي',
//            'job_type_id.required' => 'Please select job type.',
//            'job_shift_id.required' => 'Please select job shift.',
//            'num_of_positions.required' => 'Please select number of positions.',
            'employee_id.required' => 'برجاء اختيار الموظف',
            'expiry_date.required' => 'برجاء اختيار آخر موعد للتسجيل في المبادرة',
            'degree_level_id.required' => 'برجاء اختيار الدرجة العلمية',
            'job_experience_id.required' => 'برجاء اختيار الخبرة الوظيفية',
            'is_active.required' => 'Is this Job active?',
//            'is_featured.required' => 'Is this Job featured?',
        ];
    }

}
