<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DangerSubCatFormRequest extends Request
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
                    $state_unique = '';
                    if ($id > 0) {
                        $state_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "state" => "required", "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.', 'country_id.required' => 'Please select Danger Sub Category.', 'state.required' => 'Please enter State Name.', 'is_default.required' => 'Is this state default/fallback ?.', 'state_id.required_if' => 'Please select default/fallback State.', 'is_active.required' => 'Is this State active?',
        ];
    }

}
