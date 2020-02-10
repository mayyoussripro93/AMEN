<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //safety_consultant
        Gate::define('safety-consultant', function ($employee) {
            if(in_array($employee->employee_role_id,[3]))
            {
                return true;
            }
            return false;
        });
        //
        Gate::define('project-consultant', function ($employee) {
            if(in_array($employee->employee_role_id,[4]))
            {
                return true;
            }
            return false;
        });
        //
        Gate::define('amen-employee', function ($employee) {
            if(in_array($employee->employee_role_id,[3,4,5,1]))
            {
                return true;
            }
            return false;
        });
        //
        Gate::define('amen-state-admin', function ($employee) {
            if(in_array($employee->employee_role_id,[2]))
            {
                return true;
            }
            return false;
        });
        //
        Gate::define('amen-admin', function ($employee) {
            if(in_array($employee->employee_role_id,[1]))
            {
                return true;
            }
            return false;
        });
        Gate::define('is_manager', function ($employee) {
            if($employee->is_manager==1 && $employee->employee_role_id!=1)
            {
                return true;
            }
            return false;
        });
    }

}
