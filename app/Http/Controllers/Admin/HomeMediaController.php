<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use ImgUploader;
use App\HomePageUploads;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Controllers\Controller;

class HomeMediaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexMedia()
    {
        return view('admin.homepage_media.index')
                   ;
    }

    public function createMedia()
    {
        return view('admin.homepage_media.add');
    }

    public function store(Request $request)
    {
        $file=new HomePageUploads();
        $file->media_type=$request->input('media_type');
//        $file->title=$request->input('title');
        $file->youtube_link=$request->input('youtube_link');
        $file->is_active=$request->input('is_active');

        if($request->hasFile('file_path') )
        {
            $original_name=explode('.',$request->file_path->getClientOriginalName())[0];
            $file->title=$original_name;
            $file->upload_file = ImgUploader::UploadDoc('amen_home_page_media/'.$request->input('media_type'), $request->file('file_path'),$original_name);
        }
        $file->save();
        return \Redirect::route('list.homeMedia');
    }

    public function deleteMedia(Request $request)
    {
        $id = $request->input('id');
        try {
            $video = HomePageUploads::findOrFail($id);
            $media_type=$video->media_type;
            \Storage::disk('s3')->delete('amen_home_page_media/'.$media_type .$video->file_upload);

                $video->delete();

            echo 'ok';
            exit;
        } catch (ModelNotFoundException $e) {
            echo 'notok';
            exit;
        }
    }

    public function fetchMediaData(Request $request)
    {
        $videos = HomePageUploads::select([
                    'homepage_uploads.id','homepage_uploads.media_type', 'homepage_uploads.title', 'homepage_uploads.upload_file','homepage_uploads.is_active'
                ]);
        return Datatables::of($videos)
                        ->filter(function ($query) use ($request) {

                            if ($request->has('title') && !empty($request->title)) {
                                $query->where('homepage_uploads.title', 'like', "%{$request->get('title')}%");
                            }
                            if ($request->has('media_type') && !empty($request->media_type)) {
                                $query->where('homepage_uploads.media_type', '=', "$request->media_type");
                            }

                        })
                        ->addColumn('title', function ($videos) {
                            $video = str_limit($videos->title, 100, '...');
                            return '<span >' . $video . '</span>';
                        })
                        ->addColumn('action', function ($videos) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $videos->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $videos->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $videos->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">						
						<li>
							<a href="javascript:void(0);" onclick="deleteVideo(' . $videos->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $videos->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'title'])
                        ->setRowId(function($videos) {
                            return 'videoDtRow' . $videos->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveMedia(Request $request)
    {
        $id = $request->input('id');
        try {
            $video = HomePageUploads::findOrFail($id);
            $video->is_active = 1;
            $video->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveMedia(Request $request)
    {
        $id = $request->input('id');
        try {
            $video = HomePageUploads::findOrFail($id);
            $video->is_active = 0;
            $video->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {

            echo 'notok';
        }
    }





}
