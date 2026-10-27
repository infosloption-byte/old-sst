<?php

namespace App\Http\Controllers;


use DB;
use PDF;
use Image;
use Sentinel;
use Response;
use Exception;
use Carbon\Carbon;
use App\Classes\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;

use App\Modules\RegistrationRequestManage\Logics\RegistrationRequestLogic;
use App\Modules\InquiryManage\Logics\InquiryLogic;
use System\Employee\Models\Employee;
use App\Models\RateUs;

class FrontController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FrontController Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles REST api requests from mobile application.
    |
    */
    
    /**
     * Create a new controller instance. 
     *
     * @return void
     */
    public function __construct(Functions $common,RegistrationRequestLogic $requestLogic,InquiryLogic $inquiryLogic)
    {
        $this->common = $common;
        $this->requestLogic = $requestLogic;
        $this->inquiryLogic = $inquiryLogic;
    }

    public function index(Request $request)
    {
        $ratings = RateUs::all();

        return view('front.index',compact('ratings'));
    }

    public function aboutusView(Request $request)
    {
        return view('front.about-us');
    }

    public function tattooView(Request $request)
    {
        return view('front.tattoos');
    }

    public function bookNowView(Request $request)
    {
        return view('front.booknow');
    }

    public function piercingView(Request $request)
    {
        return view('front.piercing');
    }

    public function rateusView(Request $request)
    {
        return view('front.rateus');
    }

    public function shopView(Request $request)
    {
        return view('front.shop');
    }

    public function contactusView(Request $request)
    {
        return view('front.contact-us');
    }

    public function bookNow(Request $request)
    {
        $details = $this->inquiryLogic->bookNow($request);

        return response()->json($details);
    }

    public function rateUs(Request $request)
    {
        $details = $this->inquiryLogic->rateUs($request);

        return response()->json($details);
    }

    public function createInquiry(Request $request)
    {
        $details = $this->inquiryLogic->createInquiry($request);

        return response()->json($details);
    }

}
