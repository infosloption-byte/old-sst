<?php
namespace App\Modules\ReportManage\Controllers;

use DB;
use PDF;
use Excel;
use Image;
use Sentinel;
use Response;
use Exception;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\User;
use App\Classes\Functions;
use App\Classes\RegularFunctions;

use System\Employee\Models\Employee;
use System\Department\Models\Department;
use System\Department\BusinessLogic\DepartmentLogic;

use App\Modules\JobManage\Models\Job;
use App\Modules\JobManage\Models\Section;
use App\Modules\JobManage\Models\Task;
use App\Modules\JobManage\Models\Client;
use App\Modules\JobManage\Logics\JobLogic;
use App\Modules\JobManage\Models\JobCategory;
use App\Modules\JobManage\Models\TaskCategory;
use App\Modules\JobManage\Models\JobTransaction;
use App\Modules\JobManage\Models\RegularJobTransaction;

use App\Modules\RepairManage\Models\Repair;
use App\Modules\RepairManage\Models\RepairType;
use App\Modules\RepairManage\Models\RepairAttachment;

use App\Modules\InspectionManage\Models\InspectionJob;
use App\Modules\InspectionManage\Models\InspectionSection;
use App\Modules\InspectionManage\Models\InspectionTask;
use App\Modules\InspectionManage\Logics\InspectionLogic;

use App\Modules\JobManage\Controllers\JobController;

use App\Modules\ReportManage\Logics\ReportLogic;

class ReportController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Report Controller
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
	public function __construct(ReportLogic $reportLogic,RegularFunctions $regularFunctions)
	{
		$this->middleware('auth');
		$this->reportLogic = $reportLogic;
		$this->regularFunctions = $regularFunctions;
	}

	/**
	 * Employee Work Summery Report view.
	 *
	 * @return Response
	 */
	public function employeeWorkSummeryReport(Request $request)
    {
        return view('ReportManage::employee-work-summery', compact('request'));
    }

	/**
	 * JSON repair list.
	 *
	 * @return Response
	 */
	public function employeeWorkSummeryJsonList(Request $request)
	{
		$data = [];

		$employees = Employee::where('type','employee')->where('designation_id',2)->orderBy('first_name','ASC')->orderBy('last_name','ASC')->get();

		foreach($employees as $employee)
		{
			$dd = [];

			$days = self::getWorkDays($employee,$request->from,$request->to);
			$hours = self::getWorkHours($employee,$request->from,$request->to);

			$dd['employee'] = $employee->first_name.' '.$employee->last_name;
			$dd['worked_days'] = count($days['onetime_worked_dates']) + count($days['regular_worked_dates']);
			$dd['worked_hours'] = $hours['total_worked_hours']?$hours['total_worked_hours']:0;
			$dd['regular'] = $hours['regular_worked_hours']?$hours['regular_worked_hours']:0;
			$dd['onetime'] = $hours['onetime_worked_hours']?$hours['onetime_worked_hours']:0;
			$dd['completed_tasks'] = $hours['completed_tasks'];
			$dd['performance'] = $hours['performance'];

			array_push($data, $dd);
		}

		return response()->json($data);
	}

	public function getWorkDays($emp,$from,$to)
	{
		$transactions = Task::where('assigned_to',$emp->id)->whereIn('job_id',function($query2){
			$query2->select('id')->from('job')->where('job_type_id',1);
		})->whereNotNull('task_start_at')->whereNotNull('task_end_at');

		if($from && $from != null && $from != '')
		{
			$transactions = $transactions->where(function($aa) use($from){
				$aa->where('task_start_at','>=',$from);
			});
		}

		if($to && $to != null && $to != '')
		{
			$transactions = $transactions->where(function($aa) use($to){
				$aa->where('task_end_at','<=',$to);
			});
		}

		$rtransactions = RegularJobTransaction::whereIn('created_by',function($query)use($emp)
		{
			$query->select('id')->from('users')->where('employee_id',$emp->id);
		})->whereNotNull('started_at')->whereNotNull('ended_at');

		if($from && $from != null && $from != '')
		{
			$rtransactions = $rtransactions->where(function($aa) use($from){
				$aa->where('created_at','>',$from.' 00:00:00');
			});
		}

		if($to && $to != null && $to != '')
		{
			$rtransactions = $rtransactions->where(function($aa) use($to){
				$aa->where('created_at','<',$to.' 23:59:59');
			});
		}

		$onetime = $transactions->get();
		$regular = $rtransactions->get();

		$onetine_worked_dates = $onetime->pluck('task_start_at');

		$_o_dates = [];
		$_r_dates = [];

		foreach($onetine_worked_dates as $date)
		{
			$dt = date('Y-m-d', strtotime($date));

			if(!in_array($dt, $_o_dates))
			{
				$_o_dates[] = $dt;
			}
		}

		$regular_worked_dates = $regular->pluck('started_at');

		foreach($regular_worked_dates as $date)
		{
			$dt = date('Y-m-d', strtotime($date));

			if(!in_array($dt, $_r_dates))
			{
				$_r_dates[] = $dt;
			}
		}

		return [
			'onetime_worked_dates' 	=> $_o_dates, 
			'regular_worked_dates' 	=> $_r_dates
		];
	}

	public function getWorkHours($emp,$from,$to)
	{
		$transactions = Task::where('assigned_to',$emp->id)->whereIn('job_id',function($query2){
			$query2->select('id')->from('job')->where('job_type_id',1);
		})->whereNotNull('task_start_at')->whereNotNull('task_end_at');

		if($from && $from != null && $from != '')
		{
			$transactions = $transactions->where(function($aa) use($from){
				$aa->where('task_start_at','>=',$from);
			});
		}

		if($to && $to != null && $to != '')
		{
			$transactions = $transactions->where(function($aa) use($to){
				$aa->where('task_end_at','<=',$to);
			});
		}

		$rtransactions = RegularJobTransaction::whereIn('created_by',function($query)use($emp)
		{
			$query->select('id')->from('users')->where('employee_id',$emp->id);
		})->whereNotNull('started_at')->whereNotNull('ended_at');

		if($from && $from != null && $from != '')
		{
			$rtransactions = $rtransactions->where(function($aa) use($from){
				$aa->where('created_at','>',$from.' 00:00:00');
			});
		}

		if($to && $to != null && $to != '')
		{
			$rtransactions = $rtransactions->where(function($aa) use($to){
				$aa->where('created_at','<',$to.' 23:59:59');
			});
		}

		$onetime_tasks = $transactions->get();
		$reg_jobs = $rtransactions->get();

		$onetime_worked_hours = 0;
		$completed_tasks = count($onetime_tasks)+count($reg_jobs);

		foreach($onetime_tasks as $task)
		{
			$onetime_worked_hours += $this->regularFunctions->calculateTimes($task->task_end_at,$task->task_start_at);
		}

		$regular_worked_hours = 0;
		foreach($reg_jobs as $job)
		{
			$regular_worked_hours += $this->regularFunctions->calculateTimes($job->ended_at,$job->started_at);
		}

		if($completed_tasks>0){
			$performance = (($onetime_worked_hours+$regular_worked_hours)/(60*60))/$completed_tasks;
		}else{
			$performance = 0;
		}

		return [
			'completed_tasks' 	=> $completed_tasks, 
			'performance' 	=> $performance,
			'total_worked_hours' 	=> $this->regularFunctions->formatTimes($onetime_worked_hours+$regular_worked_hours), 
			'onetime_worked_hours' 	=> $this->regularFunctions->formatTimes($onetime_worked_hours),
			'regular_worked_hours' 	=> $this->regularFunctions->formatTimes($regular_worked_hours)
		];
	}

	/**
	 * export repair list to excel.
	 *
	 * @return Response
	 */
	public function exportEmployeeWorkSummeryData(Request $request)
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
