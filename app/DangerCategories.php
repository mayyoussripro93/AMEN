<?php

namespace App;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DangerCatDangerSubCat;


class DangerCategories extends Model
{
use DangerCatDangerSubCat;
    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'danger_cat';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function danger_sub_cat()
    {
        return $this->hasMany('App\DangerSubCategories', 'country_id', 'id');
    }

}
