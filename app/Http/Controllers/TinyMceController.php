<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Input;
use File;
use ImgUploader;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TinyMceController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('company');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
//            $fileName = ImgUploader::UploadImage('tinymce_images',  $request->file('image'), time());
            $fileName =  Storage::disk('public')->put('tinymce_images', $image);

            echo json_encode(array('location' => '/storage/app/public/' . $fileName));
        } else {
            echo 'No Image Available';
        }
    }

}
