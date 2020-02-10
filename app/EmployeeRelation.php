<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRelation extends Model
{
    //
    protected $fillable = ['employee_child_id'];

  public function managers_parent()
   {
       return $this->belongsTo('App\Employee','employee_id','id');

   }
   public function childs()
    {
        return $this->belongsTo('App\Employee','employee_child_id','id');

    }


}
