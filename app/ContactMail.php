<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMail extends Model
{

    protected $table = 'contact_mail';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
