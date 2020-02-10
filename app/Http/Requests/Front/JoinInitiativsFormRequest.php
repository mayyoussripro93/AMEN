<?php



namespace App\Http\Requests\Front;

use App\Http\Requests\Request;
use App\JoinInitiatives;
use Illuminate\Validation\Rule;

class JoinInitiativsFormRequest extends Request
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
        $id = $this->Jop_id_2;

        if($join_init=JoinInitiatives::where('job_id', $this->Jop_id_2)->where('email', $this->email)->count()>0){

            return [
                'email' => 'required|email|max:100|unique:join_initiatives',
                'your_name' => 'required',
                'phone' => 'required|digits:10',
            ];
        }else{

            return [
                'email' => 'required|email|max:100',
                'your_name' => 'required',
                'phone' => 'required|digits:10',
            ];
        }
    }
    public function messages()
    {

        if($join_init=JoinInitiatives::where('job_id',$this->Jop_id_2)->where('email', $this->email)->count()>0){
            return [
                'your_name.required' => __('Your name is required'),
                'email.required' => __('Your email address is required'),
                'email.email' => __('Your Valid e-mail address is required'),
                'phone.required' => __('phone is required'),
                'phone.digits' => __('phone must be 10 digits'),
                'email.unique' =>__('This Email has already been taken.'),
            ];
        }else{
            return [
                'your_name.required' => __('Your name is required'),
                'email.required' => __('Your email address is required'),
                'email.email' => __('Your Valid e-mail address is required'),
                'phone.required' => __('phone is required'),
                'phone.digits' => __('phone must be 10 digits'),

            ];
        }

    }}
