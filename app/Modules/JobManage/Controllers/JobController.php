<?php
namespace App\Modules\JobManage\Controllers;

use DB;
use PDF;
use Excel;
use Image;
use Sentinel;
use Response;
use Exception;
use App\Classes\Functions;

use Carbon\Carbon;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;

use System\Employee\Models\Employee;

use App\Models\CostType;
use App\Models\CostTransaction;

use App\Models\MasterSection;
use App\Models\MasterSectionTask;

use App\Modules\JobManage\Models\Client;

use App\Modules\JobManage\Models\JobCategory;
use App\Modules\JobManage\Models\Job;
use App\Modules\JobManage\Logics\JobLogic;

use App\Modules\JobManage\Models\Section;

use App\Modules\JobManage\Models\TaskCategory;
use App\Modules\JobManage\Models\Task;

use Illuminate\Support\Facades\Log;

class JobController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Job Controller
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
	public function __construct(JobLogic $jobLogic,Functions $common)
	{
		$this->middleware('auth');
		$this->jobLogic = $jobLogic;
		$this->common = $common;
	}

	/**
	 * Create job view.
	 *
	 * @return Response
	 */
	public function createJobView(Request $request)
    {
    	return view('JobManage::create-job');
    }

	/**
	 * Master job section and tasks.
	 *
	 * @return Response
	 */
	public function viewMasterSectionTasksData(Request $request)
    {
    	return view('JobManage::master-data',compact('request'));
    }

	/**
	 * Get master sections.
	 *
	 * @return Response
	 */
	public function getMasterSectionList(Request $request)
    {
    	$sections = MasterSection::whereNull('deleted_at')->get();
    	
    	return response()->json($sections);
    }

	/**
	 * Get master tasks.
	 *
	 * @return Response
	 */
	public function getMasterTaskList(Request $request)
    {
    	$tasks = MasterSectionTask::whereNull('deleted_at')->with(['MasterSection','TaskCategory']);

    	if($request->section && $request->section!=null && $request->section!='')
		{
			$tasks = $tasks->where('master_section_id',$request->section);
		}

		$tasks = $tasks->paginate(20);
    	
    	return response()->json($tasks);
    }

    /**
	 * Create Master section.
	 *
	 * @return Response
	 */
	public function createMasterSection(Request $request)
    {
    	$details = $this->jobLogic->createMasterSection($request);

        return response()->json($details);
    }

    /**
	 * Create Master Task.
	 *
	 * @return Response
	 */
	public function createMasterTask(Request $request)
    {
    	$details = $this->jobLogic->createMasterTask($request);

        return response()->json($details);
    }

    /**
	 * Delete Master Task.
	 *
	 * @return Response
	 */
	public function deleteMasterTask(Request $request)
    {
    	$details = $this->jobLogic->deleteMasterTask($request);

        return response()->json($details);
    }

	/**
	 * Config job section and tasks.
	 *
	 * @return Response
	 */
	public function configJobSectionWithTask(Request $request)
    {
    	return view('JobManage::config-job',compact('request'));
    }

	/**
	 * Create job.
	 *
	 * @return Response
	 */
	public function createJob(Request $request)
    {
        $details = $this->jobLogic->createJob($request);

        return response()->json($details);
    }

	/**
	 * Create job.
	 *
	 * @return Response
	 */
	public function configJob(Request $request)
    {
        $details = $this->jobLogic->configJob($request);

        return response()->json($details);
    }

    public function getMasterSectionWithTask(Request $request)
    {
        $details = MasterSection::whereNull('deleted_at')->with(['masterTasks'])->get();

        return response()->json($details);
    }

	/**
	 * Show the job list screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		return view('JobManage::index-job',compact('request'));
	}

	/**
	 * Show the job list screen to the user.
	 *
	 * @return Response
	 */
	public function getJobList(Request $request)
	{
		$user = \Auth::getUser();

		$jobs = Job::whereNull('deleted_at')->with(['inspection','category','client','tasks.section','tasks.category','tasks.assignTo','transactions.actionby','costLogs.costType','costLogs.createdby','createdby','regularTransactions.actionby']);

		if($user->roles[0]->name == 'External')
		{
			$jobs = $jobs->where('client_id',$user->employee_id);
		}

		if($request->status && $request->status != null && $request->status != '')
		{
			$jobs = $jobs->where('status',$request->status);
		}

		if($request->client && $request->client != null && $request->client != '')
		{
			$jobs = $jobs->where('client_id',$request->client);
		}

		if($request->job_category && $request->job_category != null && $request->job_category != '')
		{
			$jobs = $jobs->where('job_category_id',$request->job_category);
		}

		if($request->job_type && $request->job_type != 0)
		{
			$jobs = $jobs->where('job_type_id',$request->job_type);
		}

		if($request->keyword && $request->keyword != null && $request->keyword != '')
		{
			$jobs = $jobs->where(function($aa) use($request){
				$aa->where('reference_no','LIKE','%'.$request->keyword.'%');
			});
		}

		if($request->from_date && $request->from_date != null && $request->from_date != '')
		{
			$jobs = $jobs->where(function($aa) use($request){
				$aa->where('created_at','>',$request->from_date.' 00:00:00');
			});
		}

		if($request->to_date && $request->to_date != null && $request->to_date != '')
		{
			$jobs = $jobs->where(function($aa) use($request){
				$aa->where('created_at','<',$request->to_date.' 23:59:59');
			});
		}

		$jobs = $jobs->paginate(10);

		foreach ($jobs as $value)
		{
			if($value['job_type_id']==1)
			{
				if($value->status == 0 || $value->status == 1)
				{
					$value['spend_time'] = '--';
				}else{
					$time_spend = 0;

					foreach ($value['tasks'] as $task)
					{
						// $datetime1 = date($task->task_start_at);
						// $datetime2 = date($task->task_end_at);
						// $time_spend[] = $datetime1->diff($datetime2);
						$time_spend += self::calculateTimes($task->task_end_at,$task->task_start_at);
					}

					$value['spend_time'] = self::formatTimes($time_spend);
				}
			}else{
				if(count($value['regularTransactions'])>0)
				{
					$time_spend = 0;

					foreach ($value['regularTransactions'] as $rgT)
					{
						// $datetime1 = date($task->task_start_at);
						// $datetime2 = date($task->task_end_at);
						// $time_spend[] = $datetime1->diff($datetime2);
						$rgT['spend_time'] = self::formatTimes(self::calculateTimes($rgT->ended_at,$rgT->started_at));
						$time_spend += self::calculateTimes($rgT->ended_at,$rgT->started_at);
					}

					$value['spend_time'] = self::formatTimes($time_spend/count($value['regularTransactions']));
				}else{
					$value['spend_time'] = '--';
				}
			}
		}

		return response()->json($jobs);
	}

	public function getJobDetails(Request $request)
	{
		$job = Job::where('id',$request->job)->with(['inspection','category','client','tasks.category','tasks.assignTo','transactions.actionby','costLogs.costType','costLogs.createdby','createdby'])->first();

		return $job;
	}

	static function calculateTimes($end,$start)
	{
		return abs(strtotime($end)-strtotime($start));
	}

	static function formatTimes($diff)
	{
		$years = floor($diff / (365*60*60*24));

		$months = floor(($diff - $years * 365*60*60*24)
		                               / (30*60*60*24)); 
		
		$days = floor(($diff - $years * 365*60*60*24 - 
		             $months*30*60*60*24)/ (60*60*24));
		$hours = floor(($diff - $years * 365*60*60*24 
		       - $months*30*60*60*24 - $days*60*60*24)
		                                   / (60*60)); 
		$minutes = floor(($diff - $years * 365*60*60*24 
		         - $months*30*60*60*24 - $days*60*60*24 
		                          - $hours*60*60)/ 60); 
		$seconds = floor(($diff - $years * 365*60*60*24 
		         - $months*30*60*60*24 - $days*60*60*24
		                - $hours*60*60 - $minutes*60));

		$str_time = '';

		if($days!=0)
		{
			$str_time .=$days.'d ';
		}

		if($hours!=0)
		{
			$str_time .=$hours.'h ';
		}

		if($minutes!=0)
		{
			$str_time .=$minutes.'m ';
		}

		if($seconds!=0)
		{
			$str_time .=$seconds.'s';
		}

		return $str_time;

		return [$days,$hours,$minutes,$seconds];
	}

	/**
	 * Create section.
	 *
	 * @return Response
	 */
	public function createSection(Request $request)
    {
    	$details = $this->jobLogic->createSection($request);

        return response()->json($details);
    }

    /**
	 * Update section.
	 *
	 * @return Response
	 */
	public function updateSection(Request $request)
    {
    	$details = $this->jobLogic->updateSection($request);

        return response()->json($details);
    }

	/**
	 * Create task.
	 *
	 * @return Response
	 */
	public function createTask(Request $request)
    {
    	$details = $this->jobLogic->createTask($request);

        return response()->json($details);
    }

	/**
	 * Job category.
	 *
	 * @return Response
	 */
	public function jobCategoryList(Request $request)
    {
        $job_categories = JobCategory::all();

        return response()->json($job_categories);
    }

	/**
	 * task category.
	 *
	 * @return Response
	 */
	public function taskCategoryList(Request $request)
    {
        $task_categories = TaskCategory::all();

        return response()->json($task_categories);
    }

	/**
	 * client list.
	 *
	 * @return Response
	 */
	public function clientList(Request $request)
    {
        $clients = Employee::where('type','client')->get();

        return response()->json($clients);
    }

    /**
	 * Show the section list screen to the user.
	 *
	 * @return Response
	 */
	public function indexSection(Request $request)
	{
		return view('JobManage::index-section',compact('request'));
	}

	/**
	 * Show the section list screen to the user.
	 *
	 * @return Response
	 */
	public function getAllSections(Request $request)
	{
		$user = \Auth::getUser();

		$sections = Section::whereNull('deleted_at')->with(['job','tasks','createdby']);

		if($user->roles[0]->name == 'External')
		{
			$sections = $sections->whereIn('job_id',function($qry)use($user)
			{
				$qry->select('id')->from('job')->where('client_id',$user->employee_id);
			});
		}

		if($request->status && $request->status!=null && $request->status!= ''){
			$sections = $sections->where('status',$request->status);
		}

		if($request->job && $request->job!=null && $request->job!= ''){
			$sections = $sections->where('job_id',$request->job);
		}

		if($request->keyword && $request->keyword != ''){
			$sections = $sections->where(function($aa) use($request){
				$aa->where('reference_no','LIKE','%'.$request->keyword.'%');
				$aa->orWhere('title','LIKE','%'.$request->keyword.'%');
			});
		}

		return $sections = $sections->paginate(10);
	}

	/**
	 * Show the job sections list screen to the user.
	 *
	 * @return Response
	 */
	public function getJobSections(Request $request)
	{
		$sections = Section::where('job_id',$request->job)->get();

		return $sections;
	}

    /**
	 * Show the job list screen to the user.
	 *
	 * @return Response
	 */
	public function indexTask(Request $request)
	{
		return view('JobManage::index-task',compact('request'));
	}

    /**
	 * Show the task list screen to the user.
	 *
	 * @return Response
	 */
	public function getAllTasks(Request $request)
	{
		$user = \Auth::getUser();

		$tasks = Task::whereNull('deleted_at')->with(['category','job','section','transactions.actionby','assignTo','createdby']);
		
		if($user->roles[0]->name == 'External')
		{
			$tasks = $tasks->whereIn('job_id',function($qry)use($user)
			{
				$qry->select('id')->from('job')->where('client_id',$user->employee_id);
			});
		}

		if($request->status && $request->status!=null && $request->status!= ''){
			$tasks = $tasks->where('status',$request->status);
		}

		if($request->job && $request->job!=null && $request->job!= ''){
			$tasks = $tasks->where('job_id',$request->job);
		}

		if($request->task_category && $request->task_category!=null && $request->task_category!= ''){
			$tasks = $tasks->where('task_category_id',$request->task_category);
		}

		if($request->technician && $request->technician!=null && $request->technician!= ''){
			$tasks = $tasks->where('assigned_to',$request->technician);
		}

		if($request->keyword && $request->keyword != ''){
			$tasks = $tasks->where(function($aa) use($request){
				$aa->where('reference_no','LIKE','%'.$request->keyword.'%');
				$aa->orWhere('title','LIKE','%'.$request->keyword.'%');
				$aa->orWhere('remark','LIKE','%'.$request->keyword.'%');
			});
		}

		if($request->from_date && $request->from_date != null && $request->from_date != '')
		{
			$tasks = $tasks->where(function($aa) use($request){
				$aa->where('created_at','>',$request->from_date.' 00:00:00');
			});
		}

		if($request->to_date && $request->to_date != null && $request->to_date != '')
		{
			$tasks = $tasks->where(function($aa) use($request){
				$aa->where('created_at','<',$request->to_date.' 23:59:59');
			});
		}

		$tasks = $tasks->paginate(10);

		foreach($tasks as $task)
		{
			$time_spend = $this->calculateTimes($task->task_end_at,$task->task_start_at);
			$task['spend_time'] = $this->formatTimes($time_spend);
		}

		return $tasks;
	}

    /**
	 * Show the job list screen to the user.
	 *
	 * @return Response
	 */
	public function createTaskView(Request $request)
	{
		return view('JobManage::create-task');
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
	 * Show the job details screen to the user.
	 *
	 * @return Response
	 */
	public function getAllJobs(Request $request)
	{
		$user_details = \Auth::getUser();

		return $jobs = Job::all();
	}

    /**
	 * delete task.
	 *
	 * @return Response
	 */
	public function deleteTask(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->jobLogic->deleteTask($request);

        return response()->json($details);
	}

    /**
	 * update task detail.
	 *
	 * @return Response
	 */
	public function updateTask(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->jobLogic->updateTask($request);

        return response()->json($details);
	}

	/**
	 * export task list to excel.
	 *
	 * @return Response
	 */
	public function exportTaskData(Request $request)
	{
		$tasks = Task::whereNull('deleted_at')->with(['category','job','transactions.actionby','assignTo','createdby']);

		if($request->status && $request->status!=null && $request->status!= ''){
			$tasks = $tasks->where('status',$request->status);
		}

		if($request->job && $request->job!=null && $request->job!= ''){
			$tasks = $tasks->where('job_id',$request->job);
		}

		if($request->task_category && $request->task_category!=null && $request->task_category!= ''){
			$tasks = $tasks->where('task_category_id',$request->task_category);
		}

		if($request->technician && $request->technician!=null && $request->technician!= ''){
			$tasks = $tasks->where('assigned_to',$request->technician);
		}

		if($request->keyword && $request->keyword != ''){
			$tasks = $tasks->where(function($aa) use($request){
				$aa->where('reference_no','LIKE','%'.$request->keyword.'%');
				$aa->orWhere('title','LIKE','%'.$request->keyword.'%');
				$aa->orWhere('remark','LIKE','%'.$request->keyword.'%');
			});
		}

		if($request->from_date && $request->from_date != null && $request->from_date != '')
		{
			$tasks = $tasks->where(function($aa) use($request){
				$aa->where('created_at','>',$request->from_date.' 00:00:00');
			});
		}

		if($request->to_date && $request->to_date != null && $request->to_date != '')
		{
			$tasks = $tasks->where(function($aa) use($request){
				$aa->where('created_at','<',$request->to_date.' 23:59:59');
			});
		}

		$tasks = $tasks->get();

		$jsonList = [];

		foreach ($tasks as $value)
		{
			$dd = [];

			$dd[] = $value->reference_no;
			$dd[] = $value->title;
			$dd[] = $value->start_at.' '.$value->start_time;
			$dd[] = $value->end_at.' '.$value->end_time;
			$dd[] = $value['category']->name;
			$dd[] = $value['job']->reference_no;
			
			if($value->status == 0)
			{
				$dd[] = 'Pending';
			}else if($value->status == 1){
				$dd[] = 'In-Progress';
			}else if($value->status == 2){
				$dd[] = 'Finished';
			}

			if($value['assignTo'])
			{
				$dd[] = $value['assignTo']->first_name.' '.$value['assignTo']->last_name;
			}else if($value->status == 1){
				$dd[] = 'Not Assigned';
			}

			$dd[] = $value->remark;
			$dd[] = $value['createdby']->username;

			array_push($jsonList, $dd);
			
		}

		$headers = ['Task','Title','Start At','End At','Task category','Job no','Status','Assigned User','Remark','Created User'];
		
		array_unshift($jsonList, $headers);
		
		Excel::create('Task List', function($excel) use($jsonList) {

            $excel->sheet('Sheetname', function($sheet) use($jsonList){

                $sheet->fromArray($jsonList, null, 'A1', false, false);

            });

        })->download('xls');
	}

	/**
	 * delete job.
	 *
	 * @return Response
	 */
	public function deleteJob(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->jobLogic->deleteJob($request);

        return response()->json($details);
	}

    /**
	 * update job detail.
	 *
	 * @return Response
	 */
	public function updateJob(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->jobLogic->updateJob($request);

        return response()->json($details);
	}

    /**
	 * Assign technician to task.
	 *
	 * @return Response
	 */
	public function assignTechnicianToTask(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->jobLogic->assignTechnicianToTask($request);

        return response()->json($details);
	}

	/**
	 * export job list to excel.
	 *
	 * @return Response
	 */
	public function exportJobData(Request $request)
	{
		$jobs = Job::whereNull('deleted_at')->with(['category','client','tasks','transactions.actionby','createdby']);

		if($request->status && $request->status != null && $request->status != '')
		{
			$jobs = $jobs->where('status',$request->status);
		}

		if($request->client && $request->client != null && $request->client != '')
		{
			$jobs = $jobs->where('client_id',$request->client);
		}

		if($request->job_category && $request->job_category != null && $request->job_category != '')
		{
			$jobs = $jobs->where('job_category_id',$request->job_category);
		}

		if($request->job_type && $request->job_type != 0)
		{
			$jobs = $jobs->where('job_type_id',$request->job_type);
		}

		if($request->keyword && $request->keyword != null && $request->keyword != '')
		{
			$jobs = $jobs->where(function($aa) use($request){
				$aa->where('reference_no','LIKE','%'.$request->keyword.'%');
			});
		}

		if($request->from_date && $request->from_date != null && $request->from_date != '')
		{
			$jobs = $jobs->where(function($aa) use($request){
				$aa->where('created_at','>',$request->from_date.' 00:00:00');
			});
		}

		if($request->to_date && $request->to_date != null && $request->to_date != '')
		{
			$jobs = $jobs->where(function($aa) use($request){
				$aa->where('created_at','<',$request->to_date.' 23:59:59');
			});
		}

		$jobs = $jobs->get();

		$jsonList = [];

		foreach ($jobs as $value)
		{
			$dd = [];

			$dd[] = $value->reference_no;
			$dd[] = $value->job_title;
			$dd[] = $value['category']->name;

			$dd[] = $value->start_date;
			$dd[] = $value->end_date;

			$dd[] = $value->address;
			$dd[] = $value->city;
			$dd[] = $value->state;
			$dd[] = $value->postalcode;

			if($value->status == 0)
			{
				$dd[] = 'Pending';
			}else if($value->status == 1){
				$dd[] = 'In-Progress';
			}else if($value->status == 2){
				$dd[] = 'Finished';
			}

			$dd[] = $value['client']->name;
			$dd[] = $value['client']->contact_no;
			$dd[] = $value['client']->email;

			$dd[] = $value->description;
			$dd[] = $value['createdby']->username;

			array_push($jsonList, $dd);
			
		}

		$headers = ['Job','Title','Category','Start Date','End Date','Address','City','State','Postal Code','Status','Client Name','Client Contact No','Client Email','Created By'];
		
		array_unshift($jsonList, $headers);

		Excel::create('Job List', function($excel) use($jsonList) {

            $excel->sheet('Sheetname', function($sheet) use($jsonList){

                $sheet->fromArray($jsonList, null, 'A1', false, false);

            });

        })->download('xls');
	}

    /**
	 * Start task.
	 *
	 * @return Response
	 */
	public function startTask(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->jobLogic->startTask($request);

        return response()->json($details);
	}

    /**
	 * END task.
	 *
	 * @return Response
	 */
	public function endTask(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->jobLogic->endTask($request);

        return response()->json($details);
	}

    /**
	 * Cost Types.
	 *
	 * @return Response
	 */
	public function getCostTypes(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = CostType::all();

        return response()->json($details);
	}

    /**
	 * Job Cost detail json.
	 *
	 * @return Response
	 */
	public function getJobCostLogData(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = Job::with(['category','client','tasks.category','tasks.assignTo','transactions.actionby','costLogs.costType','costLogs.createdby','createdby'])->find($request->job_id);

        return response()->json($details);
	}

    /**
	 * Create job Cost.
	 *
	 * @return Response
	 */
	public function createJobCost(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->jobLogic->createJobCost($request);

        return response()->json($details);
	}

    /**
	 * Create inspection.
	 *
	 * @return Response
	 */
	public function createInspection(Request $request)
	{
		$user_details = \Auth::getUser();

		$details = $this->jobLogic->createInspection($request);

        return response()->json($details);
	}

	public static function getJobSummeryDetails($job_id)
	{
		$tasks = Task::where('job_id',$job_id)->with(['assignTo'])->get();

		// Log::info(json_encode($tasks));

		$data = [];

		foreach($tasks as $task)
		{
			$dd = [];

			// Log::info(json_encode($task['assignTo']));
			// Log::info(json_encode($task['assign_to']));

			$dd['technician'] = $task['assignTo']->name.' '.$task['assignTo']->last_name;
			$dd['task_code'] = $task->reference_no;
			$dd['task_title'] = $task->title;
			$dd['task_start_at'] = $task->task_start_at;
			$dd['task_end_at'] = $task->task_end_at;

			$_spendTime = self::calculateTimes($task->task_end_at,$task->task_start_at);

			$dd['spend_time'] = self::formatTimes($_spendTime);

			array_push($data,$dd);
		}

		return $data;

	}

	public function exportQRCodesPdf(Request $request)
	{
		$_tmp = "http://chart.apis.google.com/chart?cht=qr&chl=".$request->job."&chs=120";

		if($request->job!='')
		{
            $page1 =  view('JobManage::qr-pdf')->with(['job'=>$request->job,'encoded_url'=>$_tmp])->render();
        }else{
            return response()->view("errors.404");
        }

        $filename="Job QR Code";

        // $pdf = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Inspection Report']);
        // PDF::SetMargins(5, 30, 5);
        PDF::SetTitle("QR Scan - SISFS");
        PDF::SetFont('helvetica', 5);
        PDF::SetAutoPageBreak(TRUE, 30);
        PDF::AddPage('P', 'A4');
        PDF::writeHtml($page1);
        PDF::output($filename.".pdf", 'I');

		// return $inspection;
	}

}
