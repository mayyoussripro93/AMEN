<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{

    protected $table = 'contacts';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $fillable = [

        'first_name','last_name', 'email','employee_id'

    ];
    protected $dates = ['created_at', 'updated_at'];

}
