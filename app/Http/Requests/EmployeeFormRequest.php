<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeFormRequest extends FormRequest
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
        $id = (int) $this->input('id', 0);

        $id_str = '';
        if ($id > 0) {
            $id_str = ',' . $id;
        }
        return [
            'email' => 'required|string|email|max:255|unique:employees,email' . $id_str ,
            'name' => 'required|string|max:250',
            'national_id_card_number'=>'digits:10|unique:employees,national_id_card_number'. $id_str,
            'job_title'=>'sometimes|required|max:255',
            'job_employer'=>'sometimes|required|max:255',
            'phone'=>'nullable|unique:employees,phone'. $id_str.'|digits:10',
            'city_id'=>'sometimes|required',
            'state_id'=>'sometimes|required',
//            'date_completion.*'=>'digits_between:4,10',
            'employee_role_id'=>'sometimes|required',
        ];

    }
    public function messages()
    {
        return [
            'name.required' => __('Name is required'),
            'name.string' => __('Name is String'),
            'name.max:250' =>  __('Name maximum 250 character'),
            'email.required' =>  __('Email is required'),
            'email.email' =>  __('The email must be a valid email address.'),
            'email.unique' =>  __('This Email has already been taken.'),
            'city_id.required' => __( 'Please select city'),
            'state_id.required' => __( 'Please select State'),
            'phone.unique' =>  __('This Phone already exist.'),
//            'phone.required' => __( 'Please enter phone'),
            'phone.digits:10' =>  __('Phone digits = 10 .'),
            'job_title.required' => __( 'Please enter Job title'),
            'job_title.max:255' =>  __('Job title maximum 255 character.'),
            'job_employer.required' => __( 'برجاء إدخال جهة العمل'),
            'job_employer.max:255' =>  __('Job employer maximum 255 character.'),
//            'national_id_card_number.required' =>  __('national id card number is required'),
            'national_id_card_number.digits:10' =>  __('The national id card number 10 digits.'),

        ];
    }
}
