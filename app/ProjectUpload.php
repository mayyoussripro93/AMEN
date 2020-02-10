<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProjectUpload extends Model
{
    //
    use SoftDeletes;
    protected $table='project_uploads';
    protected $dates = ['deleted_at'];

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }
}
