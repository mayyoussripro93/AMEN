<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinInitiatives extends Model
{

    protected $table = 'join_initiatives';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
