<?php namespace App\Http\Controllers;

use DB;
use Mail;
use Excel;
use Session;
use Sentinel;
use Response;
use Exception;
use Carbon\Carbon;
use App\Classes\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Mail Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendThankingMail($request)
    {
        $response = [];

        try {
            Mail::send('emails.contact_ok', ['data' => []], function ($m)
            {
                $m->from('admin@sisfs.com.au', 'Welcome to SISFS');
                $m->to('chathu.ad@gmail.com')->subject('Welcome to SISFS ');
            });

        } catch (\Exception $ex) {

            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $ex->getMessage() . ' in line ' . $ex->getLine() . ' at ' . $ex->getFile();

            return response()->json($response);
        }
    }

    public function sendPasswordMail($request)
    {
        $response = [];

        try {
            Mail::send('emails.password', ['data' => $request], function ($m)
            {
                $m->from('admin@sisfs.com.au', 'SISFS Registered');
                $m->to('chathu.ad@gmail.com')->subject('Your SISFS account created');
            });

        } catch (\Exception $ex) {

            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $ex->getMessage() . ' in line ' . $ex->getLine() . ' at ' . $ex->getFile();

            return response()->json($response);
        }
    }

}
