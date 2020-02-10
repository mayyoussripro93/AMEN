<?php

namespace App\Http\Controllers\Employee\Auth;

use App\EmployeeUpload;
use App\Http\Requests\EmployeeFormRequest;
use Auth;
use App\Employee;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use App\Http\Requests\Front\CompanyFrontRegisterFormRequest;
use Illuminate\Auth\Events\Registered;
use App\Events\CompanyRegistered;
use Hash;
use File;
use ImgUploader;
use DB;
use Input;
use Redirect;
use Cache;
class RegisterController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

    use RegistersUsers;
    use VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/after-register';
    protected $userTable = 'employees';
    protected $etebtion_error=false;
    protected $upload_error=false;
//    protected $redirectIfVerified = '/employee-home';
//    protected $redirectAfterVerification = '/employee-home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest', ['except' => ['getVerification', 'getVerificationError']]);
      //  $this->middleware('employee.guest', ['except' => ['getVerification', 'getVerificationError']]);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('employee');
    }

    public function register(EmployeeFormRequest $request)
    {
        DB::beginTransaction();
        try{
        $user = new Employee();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->nationality_id = $request->input('nationality_id');
        $user->national_id_card_number = $request->input('national_id_card_number');
        $user->country_id = $request->input('country_id');
        $user->state_id = $request->input('state_id');

        $user->phone = $request->input('phone');
        $user->employee_role_id=$request->input('employee_role_id');
        $user->is_active = 0;
        $user->verified = 0;
        $user->save();

            Cache::forget($user->state_id.'newRegister');
        if($request->hasFile('uploads'))
        {
            //  `employee_id`, `title`, `upload_file`
            foreach ($request->file('uploads') as $upload) {
                $em_attache = New EmployeeUpload();
                $em_attache->employee_id = $user->id;
                $em_attache->upload_file = ImgUploader::UploadDoc('employee_uploads', $upload);

                //$em_attache->upload_file = $upload->store('uploads');
                $em_attache->save();
            }
        }

           DB::commit();
        return redirect()->route('after-register');

        }
        catch(\Exception $e)
        {
           DB::rollback();
            flash(__('Something Went Wrong'))->error();
        }
    }

}
