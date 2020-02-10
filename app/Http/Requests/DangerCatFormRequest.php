<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DangerCatFormRequest extends Request
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
                    $country_unique = '';
                    if ($id > 0) {
                        $country_unique = ',id,' . $id;
                    }
                    return [
                        'country' => 'required|unique:countries' . $country_unique,
//                        'country_id' => 'required_if:is_default,0',
//                        'country_id' => 'required',
                        'is_active' => 'required',
                        'is_default' => 'required',
                        'lang' => 'required',
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
//            'country.required' => 'Please enter danger Categories .',
//            'country_id.required_if' => 'Please select  danger Categories.',
            'is_default.required' => 'Is this danger Categories default?',
            'is_active.required' => 'Please select status.',
            'lang.required' => 'Please select language.',
        ];
    }

}
