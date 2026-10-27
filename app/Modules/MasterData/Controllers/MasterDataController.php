<?php
namespace App\Modules\MasterData\Controllers;

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

use System\Employee\Models\Employee;

use App\Modules\MasterData\Logics\MasterDataLogic;

class MasterDataController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Master Data Controller
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
	public function __construct(MasterDataLogic $masterLogic)
	{
		$this->middleware('auth');
		$this->masterLogic = $masterLogic;
	}

	/////////////// Designation Function Start ///////////////

	/**
	 * Designation view.
	 *
	 * @return Response
	 */
	public function designationView(Request $request)
	{
		return view('MasterData::designation');
	}

	/**
	 * Create Designation View
	 * 
	 * @return Response
	 */
	public function createDesignation(Request $request)
	{
		$details = $this->masterLogic->createDesignation($request);

        return response()->json($details);
	}

	/**
	 * Designation Json list
	 * 
	 * @return Response
	 */
	public function getDesignationList(Request $request)
	{
		$details = $this->masterLogic->getDesignationList($request);

        return response()->json($details);
	}

	/**
	 * Update Designation View
	 * 
	 * @return Response
	 */
	public function updateDesignation(Request $request)
	{
		$details = $this->masterLogic->updateDesignation($request);

        return response()->json($details);
	}

	/**
	 * Delete Designation View
	 * 
	 * @return Response
	 */
	public function deleteDesignation(Request $request)
	{
		$details = $this->masterLogic->deleteDesignation($request);

        return response()->json($details);
	}

	/////////////// Designation Function End ///////////////

	/////////////// Cost Type Function Start ///////////////

	/**
	 * Cost Type view.
	 *
	 * @return Response
	 */
	public function costTypeView(Request $request)
	{
		return view('MasterData::cost-type');
	}

	/**
	 * Create Cost Type View
	 * 
	 * @return Response
	 */
	public function createCostType(Request $request)
	{
		$details = $this->masterLogic->createCostType($request);

        return response()->json($details);
	}

	/**
	 * CostType Json list
	 * 
	 * @return Response
	 */
	public function getCostTypeList(Request $request)
	{
		$details = $this->masterLogic->getCostTypeList($request);

        return response()->json($details);
	}

	/**
	 * Update CostType View
	 * 
	 * @return Response
	 */
	public function updateCostType(Request $request)
	{
		$details = $this->masterLogic->updateCostType($request);

        return response()->json($details);
	}

	/**
	 * Delete CostType View
	 * 
	 * @return Response
	 */
	public function deleteCostType(Request $request)
	{
		$details = $this->masterLogic->deleteCostType($request);

        return response()->json($details);
	}

	/////////////// Cost Type Function End ///////////////

}
