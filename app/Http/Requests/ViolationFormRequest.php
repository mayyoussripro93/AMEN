<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViolationFormRequest extends FormRequest
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
            'gregorian_date_str' => 'required',
            'axles'=>'required|string|max:255',
            'floor'=>'required|string|max:255',
            'area'=>'required|string|max:255',
            'special_marque'=>'string|max:255',
            'description'=>'required|string|max:500',
            'danger_status'=>'required'
        ];
    }
}
