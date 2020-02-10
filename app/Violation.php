<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DangerCatDangerSubCat;
use Illuminate\Database\Eloquent\SoftDeletes;
class Violation extends Model
{
    //violations;

    use SoftDeletes;

    protected $table = 'violations';
    protected $dates = ['deleted_at'];
    use DangerCatDangerSubCat;

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($violations) {

            foreach ($violations->history()->get() as $one) {
                $one->delete();
            }

            foreach ($violations->objection()->get() as $one_objection) {
                $one_objection->delete();
            }

            foreach ($violations->comments()->get() as $comment) {
                $comment->delete();
            }

            foreach ($violations->violation_uploads()->get() as $violation_upload) {
                \Storage::disk('s3')->delete('amen_project/violation' . $violation_upload->upload);
                $violation_upload->delete();
            }
        });
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'id')->withTrashed();
    }

    public function history()
    {
        return $this->hasMany('App\ViolationHistory');
    }
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }
    public function objection()
    {
        return $this->hasOne('App\Objection');
    }
    public function violation_uploads()
    {
        return $this->hasOne('App\ViolationUploads');
    }
    public function comments()
    {
        return $this->hasOne('App\Comment');
    }
}
