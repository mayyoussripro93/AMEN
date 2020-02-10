<?php

namespace App\Traits;

use DB;
use App\Country;
use App\State;
use App\City;
use App\DangerSubCategories;
use App\DangerCategories;
use App\Http\Requests;
use Illuminate\Http\Request;

trait DangerCatDangerSubCat
{

    public function deleteCountry(Request $request)
    {

        $id = $request->input('id');
        try {
            $this->delCountry($id);
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    private function delCountry($id)
    {

        $country = DangerCategories::findOrFail($id);
        $states = DangerSubCategories::select('danger_sub_cat.id')->where('danger_sub_cat.country_id', '=', $country->country_id)->pluck('danger_sub_cat.id')->toArray();
        foreach ($states as $state_id) {
            $this->delState($state_id);
        }

        if ((bool) $country->is_default) {

          DangerSubCategories::where('country_id', '=', $country->country_id)->delete();

        } else {
            $country->delete();
        }
    }

    public function deleteState(Request $request)
    {
        $id = $request->input('id');
        try {
            $this->delState($id);
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    private function delState($id)
    {
        $state = DangerSubCategories::findOrFail($id);
//        $cities = City::select('cities.id')->where('cities.state_id', '=', $state->state_id)->pluck('cities.id')->toArray();
//        foreach ($cities as $city_id) {
//            $this->delCity($city_id);
//        }
        if ((bool) $state->is_default) {
            DangerSubCategories::where('state_id', '=', $state->state_id)->delete();
        } else {
            $state->delete();
        }
    }

//    public function deleteCity(Request $request)
//    {
//        $id = $request->input('id');
//        try {
//            $this->delCity($id);
//            return 'ok';
//        } catch (ModelNotFoundException $e) {
//            return 'notok';
//        }
//    }
//
//    private function delCity($id)
//    {
//        $city = City::findOrFail($id);
//        if ((bool) $city->is_default) {
//            City::where('city_id', '=', $city->city_id)->delete();
//        } else {
//            $city->delete();
//        }
//    }

    public function country()
    {
        return $this->belongsTo('App\DangerCategories', 'country_id', 'country_id');
    }

    public function getCountry($field = '')
    {

$country=DangerCategories:: where('id',$this->country_id)->lang()->first();
//        $country = $this->DangerCategories()->lang()->first();

        if (null === $country) {
            $country=DangerCategories:: where('id',$this->country_id)->first();
        }
        if (null !== $country) {
            if (!empty($field)) {
                return $country->$field;
            } else {
                return $country;
            }
        }
    }

    public function danger_cat()
    {
        return $this->belongsTo('App\DangerCategories', 'danger_cat_id', 'country_id');
    }

    public function get_danger_cat($field = '')
    {

        $country=DangerCategories:: where('id',$this->country_id)->lang()->first();
//        $country = $this->DangerCategories()->lang()->first();

        if (null === $country) {
            $country=DangerCategories:: where('id',$this->country_id)->first();
        }
        if (null !== $country) {
            if (!empty($field)) {
                return $country->$field;
            } else {
                return $country;
            }
        }
    }


    public function state()
    {
        return $this->belongsTo('App\DangerSubCategories', 'state_id', 'state_id');
    }

    public function getState($field = '')
    {
        $state = $this->DangerSubCategories()->lang()->first();
        if (null === $state) {
            $state = $this->DangerSubCategories()->first();
        }
        if (null !== $state) {
            if (!empty($field)) {
                return $state->$field;
            } else {
                return $state;
            }
        }
    }


    public function sub_cat()
    {
        return $this->belongsTo('App\DangerSubCategories', 'danger_sub_cat_id', 'state_id');
    }

    public function get_sub_cat($field = '')
    {
        $state = $this->DangerSubCategories()->lang()->first();
        if (null === $state) {
            $state = $this->DangerSubCategories()->first();
        }
        if (null !== $state) {
            if (!empty($field)) {
                return $state->$field;
            } else {
                return $state;
            }
        }
    }
//    public function city()
//    {
//        return $this->belongsTo('App\City', 'city_id', 'city_id');
//    }
//
//    public function getCity($field = '')
//    {
//        $city = $this->city()->lang()->first();
//        if (null === $city) {
//            $city = $this->city()->first();
//        }
//        if (null !== $city) {
//            if (!empty($field)) {
//                return $city->$field;
//            } else {
//                return $city;
//            }
//        }
//    }

    public function getLocation()
    {
        $country = $this->getCountry('country');
        $state = $this->getState('state');
        $city = $this->getCity('city');

        $str = '';
        if (!empty($city))
            $str .= $city . ' - ';
        if (!empty($state))
            $str .=  $state . ' - ';
        if (!empty($country))
            $str .= $country;

        return $str;
    }

}
