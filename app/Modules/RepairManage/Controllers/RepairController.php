<?php
namespace App\Modules\RepairManage\Controllers;

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

use App\Modules\RepairManage\Models\Repair;

use App\Modules\RepairManage\Logics\RepairLogic;

class RepairController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Repair Controller
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
	public function __construct(RepairLogic $repairLogic)
	{
		$this->middleware('auth');
		$this->repairLogic = $repairLogic;
	}

	/**
	 * Create repair view.
	 *
	 * @return Response
	 */
	public function createRepairView(Request $request)
    {
        return view('RepairManage::create');
    }

	/**
	 * Create repair.
	 *
	 * @return Response
	 */
	public function createRepair(Request $request)
    {
        $details = $this->repairLogic->createRepair($request);

        return response()->json($details);
    }

	/**
	 * Show the repair list screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		return view('RepairManage::index',compact('request'));
	}

	/**
	 * JSON repair list.
	 *
	 * @return Response
	 */
	public function getRepairList(Request $request)
	{
		$repairs = Repair::whereNull('deleted_at')->with(['createdby','repairType','attachments']);

		if($request->keyword && $request->keyword != null && $request->keyword != ''){
			$repairs = $repairs->where(function($aa) use($request){
				$aa->where('reference_no','LIKE','%'.$request->keyword.'%');
			});
		}

		if($request->repair_type && $request->repair_type != null && $request->repair_type != ''){
			$repairs = $repairs->where(function($aa) use($request){
				$aa->where('repair_type_id',$request->repair_type);
			});
		}

		if($request->status && $request->status != null && $request->status != ''){
			$repairs = $repairs->where('status',$request->status);
		}

		if($request->from_date && $request->from_date != null && $request->from_date != '')
		{
			$repairs = $repairs->where(function($aa) use($request){
				$aa->where('created_at','>',$request->from_date.' 00:00:00');
			});
		}

		if($request->to_date && $request->to_date != null && $request->to_date != '')
		{
			$repairs = $repairs->where(function($aa) use($request){
				$aa->where('created_at','<',$request->to_date.' 23:59:59');
			});
		}

		if($request->reported_user && $request->reported_user != null && $request->reported_user != '')
		{
			$repairs = $repairs->where(function($aa) use($request){
				$aa->where('created_by',$request->reported_user);
			});
		}

		$repairs = $repairs->paginate(10);

		return response()->json($repairs);
	}
	
	/**
	 * Create repair.
	 *
	 * @return Response
	 */
	public function repairTypeList(Request $request)
    {
        $details = $this->repairLogic->repairTypeList($request);

        return response()->json($details);
    }

    /**
	 * Technician List.
	 *
	 * @return Response
	 */
	public function getTechnician(Request $request)
	{
		$user_details = \Auth::getUser();

		return $technicians = Employee::where('designation_id',2)->get();
	}

    /**
	 * User List.
	 *
	 * @return Response
	 */
	public function getUsers(Request $request)
	{
		$user_details = \Auth::getUser();

		return $users = User::with(['employee'])->get();
	}

	/**
	 * delete repair.
	 *
	 * @return Response
	 */
	public function deleteRepair(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->repairLogic->deleteRepair($request);

        return response()->json($details);
	}

    /**
	 * update repair detail.
	 *
	 * @return Response
	 */
	public function updateRepair(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->repairLogic->updateRepair($request);

        return response()->json($details);
	}

    /**
	 * update repair detail.
	 *
	 * @return Response
	 */
	public function deleteRepairAttachment(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->repairLogic->deleteRepairAttachment($request);

        return response()->json($details);
	}

	/**
	 * export repair list to excel.
	 *
	 * @return Response
	 */
	public function exportRepairData(Request $request)
	{
		$repairs = Repair::whereNull('deleted_at')->with(['createdby','repairType','attachments']);

		if($request->keyword && $request->keyword != null && $request->keyword != ''){
			$repairs = $repairs->where(function($aa) use($request){
				$aa->where('reference_no','LIKE','%'.$request->keyword.'%');
			});
		}

		if($request->repair_type && $request->repair_type != null && $request->repair_type != ''){
			$repairs = $repairs->where(function($aa) use($request){
				$aa->where('repair_type_id',$request->repair_type);
			});
		}

		if($request->status && $request->status != null && $request->status != ''){
			$repairs = $repairs->where('status',$request->status);
		}

		if($request->from_date && $request->from_date != null && $request->from_date != '')
		{
			$repairs = $repairs->where(function($aa) use($request){
				$aa->where('created_at','>',$request->from_date.' 00:00:00');
			});
		}

		if($request->to_date && $request->to_date != null && $request->to_date != '')
		{
			$repairs = $repairs->where(function($aa) use($request){
				$aa->where('created_at','<',$request->to_date.' 23:59:59');
			});
		}

		if($request->reported_user && $request->reported_user != null && $request->reported_user != '')
		{
			$repairs = $repairs->where(function($aa) use($request){
				$aa->where('created_by',$request->reported_user);
			});
		}

		$repairs = $repairs->get();

		$jsonList = [];

		foreach ($repairs as $value)
		{
			$dd = [];

			$dd[] = $value->reference_no;
			$dd[] = $value->createdby->name;
			$dd[] = $value->created_at;
			$dd[] = $value->location;
			$dd[] = $value->asset;
			$dd[] = $value->remark;
			
			if($value->status == 0)
			{
				$dd[] = 'Pending';
			}else if($value->status == 1){
				$dd[] = 'In-Progress';
			}else if($value->status == 2){
				$dd[] = 'REPAIRED';
			}

			$dd[] = $value->lat;
			$dd[] = $value->lng;

			array_push($jsonList, $dd);
			
		}

		$headers = ['Reference No','Reported User','Reported Date','Asset','Location','Remark','Status','Latitude','Longitude'];
		
		array_unshift($jsonList, $headers);
		
		Excel::create('Repair List', function($excel) use($jsonList) {

            $excel->sheet('Sheetname', function($sheet) use($jsonList){

                $sheet->fromArray($jsonList, null, 'A1', false, false);

            });

        })->download('xls');
	}

}
