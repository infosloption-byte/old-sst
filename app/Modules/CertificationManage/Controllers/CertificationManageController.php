<?php
namespace App\Modules\CertificationManage\Controllers;

use DB;
use Sentinel;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use System\Employee\Models\Employee;
use System\Department\Models\Department;

use App\Modules\CertificationManage\Models\Certification;
use App\Modules\CertificationManage\Models\CertificationDocument;
use App\Modules\CertificationManage\Models\CertificationQuestion;
use App\Modules\CertificationManage\Models\CertificationQuestionAnswer;
use App\Modules\CertificationManage\Logics\CertificationLogic;

class CertificationManageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Certification Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $logic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(CertificationLogic $certificateLogic)
	{
		$this->middleware('auth');
		$this->certificateLogic = $certificateLogic;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{	
		$user = \Auth::user();

		return view('CertificationManage::index');
	}

	public function getCertificationData(Request $request)
	{
		$details = $this->certificateLogic->getCertificationData($request);

		return response()->json($details);
	}

	public function createCertificate(Request $request)
	{
		$details = $this->certificateLogic->createCertificate($request);

		return response()->json($details);
	}

	public function updateCertificate(Request $request)
	{
		$details = $this->certificateLogic->updateCertificate($request);

		return response()->json($details);
	}

	public function removeDocument(Request $request)
	{
		$details = $this->certificateLogic->removeDocument($request);

		return response()->json($details);
	}

	public function getCertificationList(Request $request)
	{
		$details = $this->certificateLogic->getCertificationList($request);

		return response()->json($details);
	}

	public function questionListView(Request $request)
	{	
		$user = \Auth::user();

		return view('CertificationManage::questions');
	}

	public function getQuestionData(Request $request)
	{
		$details = $this->certificateLogic->getQuestionData($request);

		return response()->json($details);
	}

	public function createQuestion(Request $request)
	{
		$details = $this->certificateLogic->createQuestion($request);

		return response()->json($details);
	}

	public function updateQuestion(Request $request)
	{
		$details = $this->certificateLogic->updateQuestion($request);

		return response()->json($details);
	}

	public function uploadQuestions(Request $request)
	{
		$details = $this->certificateLogic->uploadQuestions($request);

		return response()->json($details);
	}
	
}
