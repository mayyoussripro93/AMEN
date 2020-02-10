<?php

namespace App\Http\Controllers;

use App;
use Mail;
use Auth;
use App\Employee;
use App\Mail\NewEmployeeAdded;
use App\Seo;
use App\Job;
use App\Company;
use App\FunctionalArea;
use App\Country;
use App\Video;
use App\Testimonial;
use App\Slider;
use Illuminate\Http\Request;
use Redirect;
use App\Traits\CompanyTrait;
use App\Traits\FunctionalAreaTrait;
use App\Traits\CityTrait;
use App\Traits\JobTrait;
use App\Traits\Active;
use App\Helpers\DataArrayHelper;
use Illuminate\Support\Facades\Input;
use App\HomePageUploads;

class IndexController extends Controller
{

    use CompanyTrait;
    use FunctionalAreaTrait;
    use CityTrait;
    use JobTrait;
    use Active;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $topCompanyIds = $this->getCompanyIdsAndNumJobs(16);
        $topFunctionalAreaIds = $this->getFunctionalAreaIdsAndNumJobs(32);
        $topIndustryIds = $this->getIndustryIdsFromCompanies(32);
        $topCityIds = $this->getCityIdsAndNumJobs(32);
        $featuredJobs = Job::active()->featured()->notExpire()->limit(12)->get();
        $latestJobs = Job::active()->notExpire()->orderBy('id', 'desc')->limit(12)->get();
        $video = Video::getVideo();
        $testimonials = Testimonial::langTestimonials();

        $functionalAreas = DataArrayHelper::langFunctionalAreasArray();
        $countries = DataArrayHelper::langCountriesArray();
		$sliders = Slider::langSliders();
//        $jobs_1 = Auth::guard('employee')->user()->jobs()->where("Initiatives_type",'1')->count();
//        $jobs_2= Auth::guard('employee')->user()->jobs()->where("Initiatives_type",'2')->count();
//        $jobs_0 = Auth::guard('employee')->user()->jobs()->where("Initiatives_type",'0')->count();

        $seo = SEO::where('seo.page_title', 'like', 'front_index_page')->first();

        return view('welcome')
                        ->with('topCompanyIds', $topCompanyIds)
                        ->with('topFunctionalAreaIds', $topFunctionalAreaIds)
                        ->with('topCityIds', $topCityIds)
                        ->with('topIndustryIds', $topIndustryIds)
                        ->with('featuredJobs', $featuredJobs)
                        ->with('latestJobs', $latestJobs)
                        ->with('functionalAreas', $functionalAreas)
                        ->with('countries', $countries)
						->with('sliders', $sliders)
                        ->with('video', $video)
                        ->with('testimonials', $testimonials)
                        ->with('seo', $seo) ;
//                         ->with('jobs_2', $jobs_2)
//            ->with('jobs_0', $jobs_0);
    }

    public function setLocale(Request $request)
    {
        $locale = $request->input('locale');
        $return_url = $request->input('return_url');
        $is_rtl = $request->input('is_rtl');
        $localeDir = ((bool) $is_rtl) ? 'rtl' : 'ltr';

        session(['locale' => $locale]);
        session(['localeDir' => $localeDir]);

        return Redirect::to($return_url);
    }



    public function get_activate_register($token){

//        dd($token);
     return view('employee.account-activation')
            ->with('verify_token',$token);

    }


    public function post_activate_register(Request $request){

        $this->validate($request, [
            'verify_token' => 'required|exists:employees,verification_token',


        ]);

        $employee=Employee::where('verification_token', $request->input('verify_token'))->first();
//        if ($employee === null) {
//            // user doesn't exist
//            return back()->withErrors(['verify_token' => ['Not Valid']]);
//        }
        $employee->is_active=1;
        $employee->is_manager=1;
        $employee->save();
//        Auth::guard('employee')->logout();
//        $request->session()->invalidate();
        return redirect()->route('login');
    }

    public function filterInitiatives(Request $request)
    {
        $jobs_1 = Job::where("state_id", $request->input('region_Id'))->where("Initiatives_type",'1')->notExpire()->count();
        $jobs_2=Job::where("state_id", $request->input('region_Id'))->where("Initiatives_type",'2')->notExpire()->count();
        $jobs_0 = Job::where("state_id", $request->input('region_Id'))->where("Initiatives_type",'0')->notExpire()->count();

        return ['jobs_1'=> $jobs_1,'jobs_2'=> $jobs_2,'jobs_0'=> $jobs_0];
    }

    public function SafetyGallery(){
        $videos=HomePageUploads::where('is_active',1)->where('media_type','video')->get();
        $papers=HomePageUploads::where('is_active',1)->where('media_type','paper')->get();
        $videos_count=HomePageUploads::where('is_active',1)->where('media_type','video')->count();
        $papers_count=HomePageUploads::where('is_active',1)->where('media_type','paper')->count();
//        dd($videos,$papers,$videos_count,$papers_count);
        return view('safety_gallery')
             ->with('videos',$videos)
             ->with('papers',$papers)
             ->with('videos_count',$videos_count)
             ->with('papers_count',$papers_count)
            ;
    }
    public function ImagesGallery(){
        $images=HomePageUploads::where('is_active',1)->where('media_type','image')->get();
        $images_count=HomePageUploads::where('is_active',1)->where('media_type','image')->count();

        return view('image_gallery')
            ->with('images',$images)
            ->with('images_count',$images_count)
            ;
    }

}
