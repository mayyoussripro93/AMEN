<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeEvaluation extends Model
{
    //
    use SoftDeletes;
    protected $table='employee_evaluations';
    protected $fillable=['project_id','employee_id','performance','initiative','collaboration','participation','supervisory','year_month','created_by'];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
}
