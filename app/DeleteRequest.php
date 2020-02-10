<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeleteRequest extends Model
{
    //
    protected $table = 'account_delete_request';
    protected  $fillable =['employee_id'];
}
