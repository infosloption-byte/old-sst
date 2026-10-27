<?php
namespace App\Modules\QuestionManage\Controllers;

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

use App\Modules\QuestionManage\Models\Question;
use App\Modules\QuestionManage\Models\QuestionAnswer;
use App\Modules\QuestionManage\Logics\QuestionLogic;

class QuestionManageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Question Controller
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
	public function __construct(QuestionLogic $questionLogic)
	{
		$this->middleware('auth');
		$this->questionLogic = $questionLogic;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{	
		$user = \Auth::user();

		return view('QuestionManage::index');
	}

	public function getQuestionData(Request $request)
	{
		$details = $this->questionLogic->getQuestionData($request);

		return response()->json($details);
	}

	public function createQuestion(Request $request)
	{
		$details = $this->questionLogic->createQuestion($request);

		return response()->json($details);
	}

	public function updateQuestion(Request $request)
	{
		$details = $this->questionLogic->updateQuestion($request);

		return response()->json($details);
	}

	public function removeQuestion(Request $request)
	{
		$details = $this->questionLogic->removeQuestion($request);

		return response()->json($details);
	}

	public function getQuestionList(Request $request)
	{
		$details = $this->questionLogic->getQuestionList($request);

		return response()->json($details);
	}
	
}
