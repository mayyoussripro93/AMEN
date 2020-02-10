<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use Form;
use App\Language;
use App\State;
use App\DangerSubCategories;
use App\Country;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\DangerSubCatFormRequest;
use App\Http\Controllers\Controller;
use App\Traits\CountryStateCity;
use App\Traits\DangerCatDangerSubCat;
class DangerSubCategoriesController extends Controller
{


    use DangerCatDangerSubCat;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexStates()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $countries = DataArrayHelper::defaultDangerCategoriesArray();
        return view('admin.danger_sub_cat.index')
                        ->with('languages', $languages)
                        ->with('countries', $countries);
    }

    public function createState()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $countries = DataArrayHelper::defaultDangerCategoriesArray();
        return view('admin.danger_sub_cat.add')
                        ->with('languages', $languages)
                        ->with('countries', $countries);
    }

    public function storeState(DangerSubCatFormRequest $request)
    {
        $state = new DangerSubCategories();
        $state->lang = $request->input('lang');
        $state->country_id = $request->input('country_id');
        $state->state = $request->input('state');
        $state->is_default = $request->input('is_default');
        $state->state_id = $request->input('state_id');
        $state->is_active = $request->input('is_active');
        $state->save();
        /*         * ************************************ */
        $state->sort_order = $state->id;
        if ((int) $request->input('is_default') == 1) {
            $state->state_id = $state->id;
        } else {
            $state->state_id = $request->input('state_id');
        }
        $state->update();
        /*         * ************************************ */
        flash('State has been added!')->success();
        return \Redirect::route('edit.danger.sub.cats', array($state->id));
    }

    public function editState($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $countries = DataArrayHelper::defaultDangerCategoriesArray();
        $state = DangerSubCategories::findOrFail($id);
        return view('admin.danger_sub_cat.edit')
                        ->with('languages', $languages)
                        ->with('state', $state)
                        ->with('countries', $countries);
    }

    public function updateState($id, DangerSubCatFormRequest $request)
    {
        $state = DangerSubCategories::findOrFail($id);
        $state->lang = $request->input('lang');
        $state->country_id = $request->input('country_id');
        $state->state = $request->input('state');
        $state->is_default = $request->input('is_default');
        $state->state_id = $request->input('state_id');
        $state->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $state->state_id = $state->id;
        } else {
            $state->state_id = $request->input('state_id');
        }
        /*         * ************************************ */
        $state->update();
        flash('State has been updated!')->success();
        return \Redirect::route('edit.danger.sub.cats', array($state->id));
    }

    public function fetchStatesData(Request $request)
    {
        $states = DangerSubCategories::select([
                    'danger_sub_cat.id', 'danger_sub_cat.lang', 'danger_sub_cat.country_id', 'danger_sub_cat.state', 'danger_sub_cat.is_default', 'danger_sub_cat.state_id', 'danger_sub_cat.is_active',
                ])->sorted();
        return Datatables::of($states)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('danger_sub_cat.id', 'like', "{$request->get('id')}%");
                            }
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('danger_sub_cat.lang', 'like', "{$request->get('lang')}");
                            }
                            if ($request->has('country_id') && !empty($request->country_id)) {
                                $query->where('danger_sub_cat.country_id', '=', "{$request->get('country_id')}");
                            }
                            if ($request->has('state') && !empty($request->state)) {
                                $query->where('danger_sub_cat.state', 'like', "%{$request->get('state')}%");
                            }
                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('danger_sub_cat.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('country_id', function ($states) {
                            return $states->getCountry('country');
                        })
                        ->addColumn('state', function ($states) {
                            $state = str_limit($states->state, 100, '...');
                            $direction = MiscHelper::getLangDirection($states->lang);
                            return '<span dir="' . $direction . '">' . $state . '</span>';
                        })
                        ->addColumn('action', function ($states) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $states->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $states->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $states->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.danger.sub.cats', ['id' => $states->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteState(' . $states->id . ', ' . $states->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $states->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'country_id', 'state'])
                        ->setRowId(function($states) {
                            return 'stateDtRow' . $states->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveState(Request $request)
    {
        $id = $request->input('id');
        try {
            $state = DangerSubCategories::findOrFail($id);
            $state->is_active = 1;
            $state->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveState(Request $request)
    {
        $id = $request->input('id');
        try {
            $state = DangerSubCategories::findOrFail($id);
            $state->is_active = 0;
            $state->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortStates()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.danger_sub_cat.sort')->with('languages', $languages);
    }

    public function stateSortData(Request $request)
    {
        $lang = $request->input('lang');
        $states = DangerSubCategories::select('danger_sub_cat.id', 'danger_sub_cat.state', 'danger_sub_cat.sort_order')
                ->where('danger_sub_cat.lang', 'like', $lang)
                ->orderBy('danger_sub_cat.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($states != null) {
            foreach ($states as $state) {
                $str .= '<li id="' . $state->id . '"><i class="fa fa-sort"></i>' . $state->state . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function stateSortUpdate(Request $request)
    {
        $stateOrder = $request->input('stateOrder');
        $stateOrderArray = explode(',', $stateOrder);
        $count = 1;
        foreach ($stateOrderArray as $stateId) {
            $state = DangerSubCategories::find($stateId);
            $state->sort_order = $count;
            $state->update();
            $count++;
        }
    }

}
