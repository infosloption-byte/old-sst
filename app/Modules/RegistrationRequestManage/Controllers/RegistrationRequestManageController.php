<?php
namespace App\Modules\RegistrationRequestManage\Controllers;

use DB;
use PDF;
use Image;
use Sentinel;
use Response;
use Carbon\Carbon;
use App\Classes\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\RegistrationRequestManage\Models\RegistrationRequest;
use App\Modules\RegistrationRequestManage\Logics\RegistrationRequestLogic;

use System\Employee\Models\Employee;
use System\Department\BusinessLogic\DepartmentLogic;
use System\Department\Models\Department;

use App\Models\User;

class RegistrationRequestManageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration Request Manage Controller
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
	public function __construct(Functions $common,RegistrationRequestLogic $requestLogic,DepartmentLogic $departmentLogic)
	{
		$this->middleware('auth');
		$this->common = $common;
		$this->requestLogic = $requestLogic;
		$this->departmentLogic = $departmentLogic;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$user = \Auth::user();

		$supervisors =  Employee::all();
		$departments   = $this->departmentLogic->getAllDepartments();

		return view('RegistrationRequestManage::index',compact('supervisors','departments'));
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function createRegisterRequest(Request $request)
	{
		$user = \Auth::user();

		$details = $this->requestLogic->createRegisterRequest($request);

		return response()->json($details);
	}

	public function getRegistrationRequestData(Request $request)
	{
		$details = $this->requestLogic->getRegistrationRequestData($request);

		return response()->json($details);
	}

	public function approveRequest(Request $request)
	{
		$details = $this->requestLogic->approveRequest($request);

		return response()->json($details);
	}

	public function rejectRequest(Request $request)
	{
		$details = $this->requestLogic->rejectRequest($request);

		return response()->json($details);
	}

	public function sendMail(Request $request)
	{
		$details = $this->requestLogic->sendMail($request);

		return response()->json($details);
	}
}
