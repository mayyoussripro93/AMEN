<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectFormRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:projects,name'. $id_str,
            'owner' => 'required|string|max:255',
            'city_id' =>'required',
            'state_id' =>'sometimes|required',
            'description'=>'required|string|max:1000',
            'date_gregorian'=>'required',
        ];

    }

}
