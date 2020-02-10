<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ViolationHistory extends Model
{
    //
    use SoftDeletes;
    protected $table = 'violation_history';
    protected $dates = ['deleted_at'];

    public function violation()
    {
        return $this->belongsTo('App\Violation', 'violation_id', 'id');
    }
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }
    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id')->withTrashed();
    }
}
