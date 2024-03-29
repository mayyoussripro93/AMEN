<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;

class ReportAbuseCompanyFormRequest extends Request
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
        return [
            'your_name' => 'required|max:100',
            'your_email' => 'required|email|max:100',
            'company_url' => 'required|max:230',
           // 'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'your_name.required' => __('Your name is required'),
            'your_email.required' => __('Your email address is required'),
            'your_email.email' => __('Your Valid e-mail address is required'),
            'company_url.required' => __('Company url is required'),
            'company_url.url' => __('Company url must be a valid URL'),
            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
            'g-recaptcha-response.captcha' => __('Captcha error! try again later'),
        ];
    }

}
