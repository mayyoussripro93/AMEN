<?php

namespace App;

use App\Traits\CountryStateCity;
use Illuminate\Database\Eloquent\Model;
use App\EmployeeEvaluation;
use App\ProjectAssign;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    //
    use SoftDeletes;
    use CountryStateCity;

    protected $table = 'projects';
    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($projects) {

            foreach ($projects->uploads()->get() as $project_upload) {

                \Storage::disk('s3')->delete('amen_project/studies' .$project_upload->upload);
                $project_upload->delete();
            }
            foreach ($projects->violations()->get() as $violation) {
                $violation->delete();
            }
            foreach ($projects->Assigns()->get() as $employee_assign) {
                $employee_assign->delete();
            }
            foreach ($projects->events()->get() as $event ) {
                $event->delete();
            }
            foreach ($projects->Evaluations()->get() as $Evaluation) {
                $Evaluation->delete();
            }
            foreach ($projects->jobs()->get() as $job) {
                $job->delete();
            }
            foreach ($projects->messages()->get() as $message) {
                $message->delete();
            }

        });
    }


    public function getName()
    {
        $html = '';
        if (!empty($this->name))
            $html .= $this->name;

        return $html;
    }

    public function printProjectImage($width = 0, $height = 0)
    {

        $image = (string) $this->logo;
        $image = (!empty($image)) ? $image : 'no_image.jpg';
        return \ImgUploader::print_image("amen_project/logo/$image", $width, $height, '/admin_assets/no_image.jpg', $this->getName());
    }

    public function assignees()
    {
        return $this->belongsToMany('App\Employee', 'projects_assigns', 'project_id', 'employee_id')->withPivot('employee_head_id');
    }

    public function violations()
    {
        return $this->hasMany('App\Violation');
    }

    public function uploads()
    {
        return $this->hasMany('App\ProjectUpload');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function Evaluations()
    {
        return $this->hasMany('App\EmployeeEvaluation');
    }

    public function Assigns()
    {
        return $this->hasMany('App\ProjectAssign');
    }

    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

    public function messages()
    {
        return $this->hasMany('App\CompanyMessage');
    }


    public static function getContentBySlug($slug)
    {
        $cms = Cms::where('page_slug', 'like', $slug)->first();
        $cmsContent = self::where('page_id', '=', $cms->id)->where('lang', 'like', \App::getLocale())->first();
        if (null === $cmsContent) {
            $cmsContent = self::where('page_id', '=', $cms->id)->first();
        }

        return $cmsContent;
    }

}
