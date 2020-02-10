<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;


class InitiativesFrontFormRequest extends Request
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

            $logo = ($id > 0) ? "" : "required";

            return [
                "company_organize_name" => "required|max:180",
                "description" => "required",
                "country_id" => "required",
                "state_id" => "required",
                "city_id" => "required",
//                "islamic_data_detail" => "required",
                "gregorian_data" => "required",
//                "islamic_data_detail_to" => "required",
                "gregorian_data_to" => "required",
                "expiry_date" =>"required",
                "title" =>"required",
                "logo" =>'image',
                "tab"=>"Learning"
            ];
        }


            default:break;
        }
    }

    public function messages()
    {
        if($this->Initiatives_type ==1){
            return [
                'company_organize_name.required' => __('Please enter Name of the organizing company'),
                'description.required' => __('Please enter required for Initiative'),
                'country_id.required' => __('Please select country'),
                'state_id.required' => __('Please select state'),
                'city_id.required' => __('Please select city'),
//                'islamic_data_detail.required' => __('Please choose date of the Initiative began'),
                'gregorian_data.required' => __('Please enter Gregorian date'),
//                'islamic_data_detail_to.required' => __('Please enter date of the Education Initiative End'),
                'gregorian_data_to.required' => __('Please enter Gregorian End date'),

                'expiry_date.required' => __('Please enter Expiry date of Initiative'),
                'title.required' =>__('Please enter Name of the Initiative'),
//                'logo.required' => __('Please enter logo of the organizing company'),
                'logo.image' => __('Only Images can be used as logo'),
            ];
        }
        elseif ($this->Initiatives_type ==2){
            return [
                'company_organize_name.required' => __('Please enter Name of the organizing company'),
                'description.required' => __('Please enter required for Initiative'),
                't_country_id.required' => __('Please select country'),
                'state_id.required' => __('Please select state'),
                'city_id.required' => __('Please select city'),
//                'islamic_data_detail.required' => __('Please choose date of the Initiative began'),
                'gregorian_data.required' => __('Please enter Gregorian date'),
//                'islamic_data_detail_to.required' => __('Please enter date of the Education Initiative End'),
                'gregorian_data_to.required' => __('Please enter Gregorian End date'),
                'v.required' => __('Please enter Expiry date of Initiative'),
                'title.required' =>__('Please enter Name of the Initiative'),
                'logo.required' => __('Please enter logo of the organizing company'),
                'logo.image' => __('Only Images can be used as logo'),

            ];
        }
    }

}
