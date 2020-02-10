<?php

namespace App;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;

use App\Traits\DangerCatDangerSubCat;

use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use Illuminate\Database\Eloquent\Model;

class DangerSubCategories extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;
    use DangerCatDangerSubCat;

    protected $table = 'danger_sub_cat';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

//    public function cities()
//    {
//        return $this->hasMany('App\City', 'state_id', 'id');
//    }

}
