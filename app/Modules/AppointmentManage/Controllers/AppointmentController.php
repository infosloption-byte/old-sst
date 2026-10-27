<?php
namespace App\Modules\AppointmentManage\Controllers;

use DB;
use PDF;
use Excel;
use Image;
use Sentinel;
use Response;
use Exception;

use Carbon\Carbon;
use App\Models\User;

use App\Classes\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;

use App\Models\Appointment;

class AppointmentController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Appointment Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
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

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		return view('AppointmentManage::index');
	}

	public function getAppointmentListJson(Request $request)
	{
		$user = \Auth::getUser();

		$appointments = Appointment::whereNull('deleted_at')->orderBy('created_at','DESC')->paginate(10);

		return response()->json($appointments);
	}

}
