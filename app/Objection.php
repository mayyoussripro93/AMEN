<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Objection extends Model
{
    //
    use SoftDeletes;
    protected $table='objections';
    protected $dates = ['deleted_at'];
}
