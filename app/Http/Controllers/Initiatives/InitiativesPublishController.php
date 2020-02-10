<?php

namespace App\Http\Controllers\Initiatives;

use Auth;
use DB;
use Input;
use Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Traits\InitiativesTrait;

class InitiativesPublishController extends Controller
{

    use InitiativesTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employee')->except('joinInitiatives','joinInitiativesPost');
//        $this->middleware('company');
    }

}
