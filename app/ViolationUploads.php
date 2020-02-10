<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ViolationUploads extends Model
{
    //
    use SoftDeletes;
    protected $table = 'violation_uploads';
    protected $dates = ['deleted_at'];
}
