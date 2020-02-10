<?php

namespace App\Providers;

use App\Event;
use App\Project;
use Carbon\Carbon;
use DB;
use View;
use App\Language;
use App\SiteSetting;
use App\Cms;
use Illuminate\Support\ServiceProvider;

use Auth;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {

// From URL to get webpage contents.
        $url="https://timesprayer.com/ajax.php?do=converter&language=ar&t=greg&y=".date('Y')."&m=".date('m')."&d=".date('d');
       // $url = "http://api.aladhan.com/v1/gToH?date=".date('d-m-Y');
// Initialize a CURL session.
        $ch = curl_init();
// Return Page contents.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//


        curl_setopt($ch, CURLOPT_URL, $url);
        $json =\curl_exec($ch) ;

        $json = preg_replace('/\s(\w+)\s/i', '"$1"', $json);
        $json = json_decode($json, true);

      //  $higridate=$json['data']['hijri']['day']+$adjustment." ".$json['data']['hijri']['month']['ar']." ".$json['data']['hijri']['year'];
        $higridate=$json['converter']['long_hijri'];
        $gregoriandate=$json['converter']['long_gre'];
      // dd($gregoriandate);
        $siteLanguages = Language::where('is_active', '=', 1)->get();
        $siteSetting = SiteSetting::findOrFail(1272);
        $show_in_top_menu = Cms::where('show_in_top_menu', 1)->get();
        $show_in_footer_menu = Cms::where('show_in_footer_menu', 1)->get();

        $storage_url= 'https://'.env('AWS_BUCKET','amen-project').'.s3.' . env('AWS_DEFAULT_REGION','us-east-2') . '.amazonaws.com/';




        /*         * *********************************** */
        View::share(
                [
                    'siteLanguages' => $siteLanguages,
                    'siteSetting' => $siteSetting,
                    'show_in_top_menu' => $show_in_top_menu,
                    'show_in_footer_menu' => $show_in_footer_menu,
                    'storage_url'=> $storage_url,
                    'higridate'=>$higridate,
                    'gregoriandate'=>$gregoriandate
                ]
        );

    }

    public function register()
    {
        //
    }

}
