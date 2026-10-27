<?php
namespace App\Modules\JobManage\Logics;

use DB;
use Mail;
use Excel;
use Sentinel;
use Response;
use Exception;
use Carbon\Carbon;

use App\Models\CostType;
use App\Models\CostTransaction;

use System\Employee\Models\Employee;
use App\Modules\JobManage\Models\Job;
use App\Modules\JobManage\Models\Section;
use App\Modules\JobManage\Models\Task;
use App\Modules\JobManage\Models\JobTransaction;

use App\Modules\InspectionManage\Models\InspectionJob;
use App\Modules\InspectionManage\Models\InspectionSection;
use App\Modules\InspectionManage\Models\InspectionTask;

use App\Models\MasterSection;
use App\Models\MasterSectionTask;

use App\Jobs\RegularJobStarted;
use App\Mail\RegularJobStartedMail;
use App\Mail\RegularJobFinishedMail;
use App\Mail\InspectionFinishedMail;
use App\Mail\JobFinishedMail;
use App\Mail\RepairMail;

class JobLogic 
{
        
    public function __construct()
    {
        
    }

    public function createJob($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$job = Job::create([
		    		'job_category_id'  	=> $request->job_category,
		    		'job_type_id'  		=> $request->job_type,
		    		'client_id'    		=> $request->client,
	                'job_title'   		=> $request->job_title,
		    		'start_date'        => $request->start_date,
		    		'end_date'        	=> $request->end_date,
	                'description'   	=> $request->job_note,
		    		'address'        	=> $request->address,
		    		'city'        		=> $request->city,
		    		'state'        		=> $request->state,
		    		'postalcode'        => $request->postalcode,
		    		'lng'   			=> $request->lng,
		    		'lat'        		=> $request->lat,
		    		'status'        	=> 0,
		    		'created_by'		=> \Auth::getUser()->id
		    	]);

		    	if($job)
		    	{
		    		$job->reference_no = "JB/".str_pad($job->id,6,0,STR_PAD_LEFT)."";
		    		$job->save();

		    		$trans = JobTransaction::create([
		    			'job_id' => $job->id,
		    			'action' => 'Job Created',
		    			'remark' => 'New job created - '.$job->reference_no,
		    			'status' => 'Pending',
		    			'action_by' => \Auth::getUser()->id
 		    		]);

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Job created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Job faild';
		    	}
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function configJob($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$job = Job::find($request->job_config_id);

		    	if($job)
		    	{
		    		Section::where('job_id',$job->id)->delete();
		    		Task::where('job_id',$job->id)->delete();

		    		$selected_sections = explode(',', $request->selected_sections);
		    		$selected_tasks = explode(',', $request->selected_tasks);

		    		foreach($selected_sections as $msection_id)
		    		{
		    			$msection = MasterSection::find($msection_id);

				    	if($msection)
				    	{
				    		if(!Section::where('job_id',$job->id)->where('master_section_id',$msection_id)->where('name',$msection->name)->first())
				    		{
				    			$section = Section::create([
						    		'job_id'  			=> $job->id,
						    		'master_section_id' => $msection->id,
						    		'name'  			=> $msection->name,
						    		'remark'   			=> $msection->name,
					                'status'        	=> 0,
					                'created_by'   		=> \Auth::getUser()->id
						    	]);

					    		$trans = JobTransaction::create([
					    			'job_id' 		=> $job->id,
					    			'section_id' 	=> $section->id,
					    			'action' 		=> 'Section Created',
					    			'remark' 		=> 'New section - created for '.$job->reference_no.' - '.$msection->name,
					    			'status' 		=> 'Pending',
					    			'action_by' 	=> \Auth::getUser()->id
			 		    		]);
					    	}
				    	}
		    		}

		    		foreach($selected_tasks as $mtask_id)
		    		{
		    			$mtask = MasterSectionTask::find($mtask_id);

		    			if($mtask)
		    			{
		    				$mtask_msection = MasterSection::find($mtask->master_section_id);

		    				$job_section = Section::where('job_id',$job->id)->where('name',$mtask_msection->name)->first();

		    				if($job_section)
		    				{
		    					if(!Task::where('job_id',$job->id)->where('section_id',$job_section->id)->where('title',$mtask->name)->first()){
		    						
			    					$task = Task::create([
							    		'job_id'  			=> $job->id,
							    		'section_id'  		=> $job_section->id,
							    		'master_section_id' => $mtask_msection->id,
							    		'master_task_id' 	=> $mtask->id,
							    		'task_category_id'  => $mtask->task_category_id,
						                'title'   			=> $mtask->name,
						                'remark'   			=> $mtask->name,
						                'start_at'   		=> $job->start_date,
						                'start_time'   		=> '08:00',
						                'end_at'   			=> $job->end_date,
						                'end_time'   		=> '22:00',
							    		'status'        	=> 0,
						                'created_by'   		=> \Auth::getUser()->id
							    	]);

							    	if($task)
							    	{
							    		$task->reference_no = "TK".str_pad($task->id,5,0,STR_PAD_LEFT)."";

							    		$task->save();

							    		$trans = JobTransaction::create([
							    			'job_id' => $job->id,
							    			'section_id' => $task->section_id,
							    			'task_id' => $task->id,
							    			'action' => 'Task Created',
							    			'remark' => 'New task - ('.$task->reference_no.') - created for '.$job->reference_no,
							    			'status' => 'Pending',
							    			'action_by' => \Auth::getUser()->id
					 		    		]);

					 		    		if($request->assign_technician !=0)
							    		{
							    			$task->assigned_to = $request->assign_technician;
							    			$task->save();

							    			$emp = Employee::find($task->assigned_to);

							    			$trans = JobTransaction::create([
								    			'job_id' => $job->id,
								    			'section_id' => $task->section_id,
								    			'task_id' => $task->id,
								    			'action' => 'Technician Assigned',
								    			'remark' => 'Task assigned to '.$emp->first_name.' '.$emp->last_name,
								    			'status' => 'Pending',
								    			'action_by' => \Auth::getUser()->id
						 		    		]);
							    		}
							    	}
		    					}
		    				}

		    			}
		    		}

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Job configed';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Job faild';
		    	}
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage().' ---> '.$e->getLine();

            return response()->json($response);
        }
    }

    public function updateJob($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$job = Job::find($request->edit_job_id);

				if($job)
				{
					$job->job_category_id  	= $request->edit_job_category;
		    		$job->client_id    		= $request->edit_client;
	                $job->job_title   		= $request->edit_job_title;
	                $job->job_cost   		= $request->edit_job_cost;
		    		$job->start_date        = $request->edit_start_date;
		    		$job->end_date        	= $request->edit_end_date;
	                $job->description   	= $request->edit_job_note;
		    		$job->address        	= $request->edit_address;
		    		$job->city        		= $request->edit_city;
		    		$job->state        		= $request->edit_state;
		    		$job->postalcode        = $request->edit_postalcode;
		    		$job->lng   			= $request->edit_lng;
		    		$job->lat        		= $request->edit_lat;

			    	if($job->save())
			    	{
			    		if($job->status==0)
			    		{
			    			$status = 'Pending';
			    		}else if($job->status==1)
			    		{
			    			$status = 'In-Progress';
			    		}else if($job->status==2)
			    		{
			    			$status = 'Finished';
			    		}

			    		$trans = JobTransaction::create([
			    			'job_id' => $job->id,
			    			'task_id' => null,
			    			'action' => 'Job Updated',
			    			'remark' => 'Update job details by '.\Auth::getUser()->username,
			    			'status' => $status,
			    			'action_by' => \Auth::getUser()->id
	 		    		]);

			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Job updated';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Job updated faild';
			    	}
				}
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function deleteJob($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$job = Job::where('id',$request->job_id)->with(['tasks'])->first();

				if($job)
		    	{
		    		if(count($job['tasks']) == 0)
		    		{
		    			if($job->delete())
			    		{
			    			$trans = JobTransaction::create([
				    			'job_id' => $job->id,
				    			'task_id' => null,
				    			'action' => 'Job Deleted',
				    			'remark' => $job->reference_no.' - '.'Job deleted ',
				    			'status' => 'Deleted',
				    			'action_by' => \Auth::getUser()->id
		 		    		]);

				    		$response['status_code'] = 200;
				    		$response['message'] = 'Success';
				    		$response['debug'] = 'Job Deleted';
			    		}else{
			    			$response['status_code'] = 404;
				    		$response['message'] = 'Faild';
				    		$response['debug'] = "Job delete faild";
			    		}
		    		}else{
		    			$response['status_code'] = 404;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = "Cannot delete this job. Job has ongoing task.";
		    		}
		    	}else{
		    		$response['status_code'] = 404;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Job not found';
		    	}
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function createSection($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$job = Job::find($request->job);

				if($job)
				{
					$section = Section::create([
			    		'job_id'  			=> $job->id,
			    		'name'  			=> $request->section_name,
			    		'remark'   			=> $request->section_remark,
		                'status'        	=> 0,
		                'created_by'   		=> \Auth::getUser()->id
			    	]);

			    	if($section)
			    	{
			    		$trans = JobTransaction::create([
			    			'job_id' 		=> $job->id,
			    			'section_id' 	=> $section->id,
			    			'action' 		=> 'Section Created',
			    			'remark' 		=> 'New section - created for '.$job->reference_no,
			    			'status' 		=> 'Pending',
			    			'action_by' 	=> \Auth::getUser()->id
	 		    		]);

			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Section created';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Section faild';
			    	}
				}
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function updateSection($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$section = Section::find($request->edit_section_id);

				if($section)
				{
					$section->job_id  		= $request->edit_job;
					$section->name  		= $request->edit_section_name;
	                $section->remark   		= $request->edit_section_remark;

			    	if($section->save())
			    	{
			    		$trans = JobTransaction::create([
			    			'job_id' 		=> $section->job_id,
			    			'section_id' 	=> $section->id,
			    			'action' 		=> 'Section Updated',
			    			'remark' 		=> 'Update section details by '.\Auth::getUser()->username,
			    			'status' 		=> $section->status,
			    			'action_by' 	=> \Auth::getUser()->id
	 		    		]);

			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Section updated';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Section updated faild';
			    	}
				}
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function deleteSection($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$section = Section::find($request->section_id);

				if($section)
		    	{
		    		$tasks = Task::where('section_id',$section->id)->get();

		    		if(count($tasks)==0){

			    		if($section->delete())
			    		{
			    			$trans = JobTransaction::create([
				    			'job_id' 		=> $section->job_id,
				    			'section_id' 	=> $section->id,
				    			'action' 		=> 'Section Deleted',
				    			'remark' 		=> 'Section deleted ',
				    			'status' 		=> 'Deleted',
				    			'action_by' 	=> \Auth::getUser()->id
		 		    		]);

				    		$response['status_code'] = 200;
				    		$response['message'] = 'Success';
				    		$response['debug'] = 'Section Deleted';
			    		}else{
			    			$response['status_code'] = 404;
				    		$response['message'] = 'Faild';
				    		$response['debug'] = "Section delete faild";
			    		}
			    	}else{
			    		$response['status_code'] = 404;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = "Section cannot delete when it have tasks";
			    	}
		    	}else{
		    		$response['status_code'] = 404;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Section not found';
		    	}
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function createTask($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$job = Job::find($request->job);

				if($job)
				{
					$task = Task::create([
			    		'job_id'  			=> $job->id,
			    		'section_id'  		=> $request->section,
			    		'task_category_id'  => $request->category,
		                'assigned_to'   	=> $request->assignto,
		                'title'   			=> $request->task_title,
		                'remark'   			=> $request->task_note,
		                'start_at'   		=> $request->start_at,
		                'start_time'   		=> $request->start_time,
		                'end_at'   			=> $request->end_at,
		                'end_time'   		=> $request->end_time,
			    		'status'        	=> 0,
		                'created_by'   		=> \Auth::getUser()->id
			    	]);

			    	if($task)
			    	{
			    		$task->reference_no = "TK".str_pad($task->id,5,0,STR_PAD_LEFT)."";
			    		$task->save();

			    		$trans = JobTransaction::create([
			    			'job_id' => $job->id,
			    			'section_id' => $task->section_id,
			    			'task_id' => $task->id,
			    			'action' => 'Task Created',
			    			'remark' => 'New task - ('.$task->reference_no.') - created for '.$job->reference_no,
			    			'status' => 'Pending',
			    			'action_by' => \Auth::getUser()->id
	 		    		]);

			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Task created';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Task faild';
			    	}
				}
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function updateTask($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$task = Task::find($request->edit_task_id);

				if($task)
				{
					$task->job_id  			= $request->edit_job;
					$task->section_id  		= $request->edit_section;
		    		$task->task_category_id = $request->edit_category;
	                $task->assigned_to   	= $request->edit_assignto;
	                $task->title   			= $request->edit_task_title;
	                $task->remark   		= $request->edit_task_note;
	                $task->start_at   		= $request->edit_start_at;
	                $task->start_time   	= $request->edit_start_time;
	                $task->end_at   		= $request->edit_end_at;
	                $task->end_time   		= $request->edit_end_time;

			    	if($task->save())
			    	{
			    		if($task->status==0)
			    		{
			    			$status = 'Pending';
			    		}else if($task->status==1)
			    		{
			    			$status = 'In-Progress';
			    		}else if($task->status==2)
			    		{
			    			$status = 'Finished';
			    		}

			    		$trans = JobTransaction::create([
			    			'job_id' => $task->job_id,
			    			'section_id' => $task->section_id,
			    			'task_id' => $task->id,
			    			'action' => 'Task Updated',
			    			'remark' => 'Update task details by '.\Auth::getUser()->username,
			    			'status' => $status,
			    			'action_by' => \Auth::getUser()->id
	 		    		]);

			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Task updated';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Task updated faild';
			    	}
				}
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function taskAssignTo($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$task = Task::find($request->task_id);

				if($task)
		    	{
		    		$task->assigned_to = $request->assigned_to;
		    		$task->save();

		    		$emp = Employee::whereIn('id',function($q)use($request)
		    		{
		    			$q->select('employee_id')->from('users')->where('id',$request->assigned_to);
		    		})->first();

		    		$trans = JobTransaction::create([
		    			'job_id' => $task->job_id,
		    			'section_id' => $task->section_id,
		    			'task_id' => $task->id,
		    			'action' => 'Task assigned',
		    			'remark' => 'Task assigned to - '.$emp->employee_no.' - '.$emp->first_name.' '.$emp->first_name,
		    			'status' => 'Pending',
		    			'action_by' => \Auth::getUser()->id
 		    		]);

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Task Assigned';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Task assigned faild';
		    	}
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function deleteTask($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$task = Task::find($request->task_id);

				if($task)
		    	{
		    		if($task->delete())
		    		{
		    			$trans = JobTransaction::create([
			    			'job_id' => $task->job_id,
			    			'section_id' => $task->section_id,
			    			'task_id' => $task->id,
			    			'action' => 'Task Deleted',
			    			'remark' => $task->reference_no.' - '.'Task deleted ',
			    			'status' => 'Deleted',
			    			'action_by' => \Auth::getUser()->id
	 		    		]);

			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Task Deleted';
		    		}else{
		    			$response['status_code'] = 404;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = "Task delete faild";
		    		}
		    	}else{
		    		$response['status_code'] = 404;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Task not found';
		    	}
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function assignTechnicianToTask($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$task = Task::find($request->task_id);

				if($task)
				{
					$task->assigned_to = $request->assign_technician;
	                
	                if($task->save())
			    	{
			    		if($task->status==0)
			    		{
			    			$status = 'Pending';
			    		}else if($task->status==1)
			    		{
			    			$status = 'In-Progress';
			    		}else if($task->status==2)
			    		{
			    			$status = 'Finished';
			    		}

			    		$emp = Employee::find($request->assign_technician);

			    		$trans = JobTransaction::create([
			    			'job_id' => $task->job_id,
			    			'section_id' => $task->section_id,
			    			'task_id' => $task->id,
			    			'action' => 'Technician Assigned',
			    			'remark' => 'Task assigned to '.$emp->first_name.' '.$emp->last_name,
			    			'status' => $status,
			    			'action_by' => \Auth::getUser()->id
	 		    		]);

			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Technician Assigned';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Technician assign faild';
			    	}
				}
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function startTask($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$task = Task::find($request->task_id);

				if($task)
				{
					$task->start_at = date('Y-m-d');
					$task->start_time = date('H:i:s');

					$task->start_lat = $request->lat;
					$task->start_lng = $request->lng;
					$task->status = 1;
	                
	                if($task->save())
			    	{
			    		$status = 'In-Progress';

			    		$trans = JobTransaction::create([
			    			'job_id' => $task->job_id,
			    			'section_id' => $task->section_id,
			    			'task_id' => $task->id,
			    			'action' => 'Task Started',
			    			'remark' => $task->reference_no.' Task now in-progress ',
			    			'status' => $status,
			    			'action_by' => \Auth::getUser()->id
	 		    		]);

			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Task Started';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Task fail to start';
			    	}
				}
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function endTask($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$task = Task::find($request->task_id);

				if($task)
				{
					$task->end_at = date('Y-m-d');
					$task->end_time = date('H:i:s');

					$task->end_lat = $request->lat;
					$task->end_lng = $request->lng;
					$task->status = 2;
	                
	                if($task->save())
			    	{
			    		$status = 'Finished';

			    		$trans = JobTransaction::create([
			    			'job_id' => $task->job_id,
			    			'section_id' => $task->section_id,
			    			'task_id' => $task->id,
			    			'action' => 'Task Finished',
			    			'remark' => $task->reference_no.' Task completed',
			    			'status' => $status,
			    			'action_by' => \Auth::getUser()->id
	 		    		]);

	 		    		$_is_tasks_pending = Task::where('job_id',$task->job_id)->whereIn('status',[0,1])->count();

	 		    		if($_is_tasks_pending == 0)
	 		    		{
	 		    			$job = Job::find($task->job_id);

	 		    			$job_summery = JobController::getJobSummeryDetails($job->id);

	 		    			if($job)
	 		    			{
	 		    				$job->status = 2;

	 		    				if($job->save())
	 		    				{
	 		    					$trans = JobTransaction::create([
						    			'job_id' => $job->id,
						    			'task_id' => null,
						    			'action' => 'Job Finished',
						    			'remark' => $job->reference_no.' Job Finished',
						    			'status' => 'Job Finished',
						    			'action_by' => \Auth::getUser()->id
				 		    		]);

				 		    		Mail::to([$job->client->email,'inquiry@sisfs.com.au'])
                                        ->bcc(['gayan@sisfs.com.au','csriyarathne@gmail.com'])
                                        ->queue(new JobFinishedMail($job,$job_summery));

				 		    		// Mail::send('emails.job_finished_customer', ['data' => $job,'summery'=>$job_summery], function ($m)use($job)
             //                        {
             //                            $m->from('admin@sisfs.com.au', $job->reference_no.' Job Finished');
             //                            $m->cc(['csriyarathne@gmail.com']);
             //                            $m->to($job->client->email)->subject("SISFS Job Completed - ".$job->reference_no);
             //                        });

                                    // Mail::send('emails.job_finished_admin', ['data' => $job,'summery'=>$job_summery], function ($m)use($job)
                                    // {
                                    //     $m->from('admin@sisfs.com.au', 'Job Done');
                                    //     $m->to(['inquiry@sisfs.com.au','gayan@sisfs.com.au','csriyarathne@gmail.com'])->subject("Job Finished - ".$job->reference_no);
                                    // });
	 		    				}
	 		    			}
	 		    		}

			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Task Finished';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Task fail to complete';
			    	}
				}
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function createJobCost($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$job = Job::find($request->cost_job);

				if($job)
		    	{
		    		$trans = CostTransaction::create([
		    			'reference_type' => "JOB",
		    			'reference_id' => $job->id,
		    			'cost_type_id' => $request->cost_type,
		    			'remark' => $request->remark,
		    			'cost_amount' => $request->cost_amount,
		    			'effective_date' => $request->effective_date,
		    			'created_by' => \Auth::getUser()->id
 		    		]);

 		    		if($trans)
 		    		{
			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Cost logged';
			    		$response['job'] = $job->id;
			    	}else{
			    		$response['status_code'] = 404;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Cost faild to logged';
			    	}
		    	}else{
		    		$response['status_code'] = 404;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Job not found';
		    	}
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function createInspection($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$job = Job::where('id',$request->job)->with(['sections.tasks.masterTask'])->first();

				if($job)
		    	{
		    		$is_exist = InspectionJob::where('job_id',$job->id)->first();		

		    		if(!$is_exist)
		    		{
			    		$inspection = InspectionJob::create([
			    			'job_id' => $job->id,
			    			'manager_id' => $request->manager,
			    			'inspection_date' => $request->inspection_date,
			    			'created_by' => \Auth::getUser()->id
			    		]);

			    		if($inspection)
			    		{
			    			$total_points = 0;

			    			$inspection->reference_no = "INJ/".str_pad($job->id,6,0,STR_PAD_LEFT)."";
			    			$inspection->save();

			    			foreach($job['sections'] as $job_section)
			    			{
			    				$inspect_section = InspectionSection::create([
			    					'inspection_job_id' => $inspection->id,
			    					'job_section_id' => $job_section->id,
			    					'task_count' => count($job_section['tasks']),
			    					'total_score' => count($job_section['tasks'])*10,
			    					'created_by' => \Auth::getUser()->id
			    				]);

			    				$total_points += count($job_section['tasks'])*10;

			    				foreach($job_section['tasks'] as $task)
				    			{
				    				$inspect_task = InspectionTask::create([
				    					'inspect_job_id' => $inspection->id,
				    					'inspect_section_id' => $inspect_section->id,
				    					'task_id' => $task->id,
				    					'title' => $task['masterTask']->inspection_name,
				    					'remark' => $task['masterTask']->inspection_name,
				    					'created_by' => \Auth::getUser()->id
				    				]);	
				    			}
			    			}

			    			$inspection->total_points = $total_points;
			    			$inspection->save();

			    			$response['status_code'] = 200;
				    		$response['message'] = 'Success';
				    		$response['debug'] = 'Job inspection logged';

			    		}else{
			    			$response['status_code'] = 500;
				    		$response['message'] = 'Faild';
				    		$response['debug'] = 'Inspection not generated';
			    		}
			    	}elseif($is_exist && $job->job_type_id==2)
			    	{
			    		$inspection = InspectionJob::create([
			    			'job_id' => $job->id,
			    			'manager_id' => $request->manager,
			    			'inspection_date' => $request->inspection_date,
			    			'created_by' => \Auth::getUser()->id
			    		]);

			    		if($inspection)
			    		{
			    			$total_points = 0;

			    			$_ins_count = InspectionJob::where('job_id',$job->id)->get()->count();

			    			$inspection->reference_no = "INJ/".str_pad($job->id,6,0,STR_PAD_LEFT)."/".$_ins_count;
			    			$inspection->save();

			    			foreach($job['sections'] as $job_section)
			    			{
			    				$inspect_section = InspectionSection::create([
			    					'inspection_job_id' => $inspection->id,
			    					'job_section_id' => $job_section->id,
			    					'task_count' => count($job_section['tasks']),
			    					'total_score' => count($job_section['tasks'])*10,
			    					'created_by' => \Auth::getUser()->id
			    				]);

			    				$total_points += count($job_section['tasks'])*10;

			    				foreach($job_section['tasks'] as $task)
				    			{
				    				$inspect_task = InspectionTask::create([
				    					'inspect_job_id' => $inspection->id,
				    					'inspect_section_id' => $inspect_section->id,
				    					'task_id' => $task->id,
				    					'title' => $task->title,
				    					'remark' => $task->remark,
				    					'created_by' => \Auth::getUser()->id
				    				]);	
				    			}
			    			}

			    			$inspection->total_points = $total_points;
			    			$inspection->save();

			    			$response['status_code'] = 200;
				    		$response['message'] = 'Success';
				    		$response['debug'] = 'Job inspection logged';

			    		}else{
			    			$response['status_code'] = 500;
				    		$response['message'] = 'Faild';
				    		$response['debug'] = 'Inspection not generated';
			    		}
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Inspection already exist';
			    	}
		    		
		    	}else{
		    		$response['status_code'] = 404;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Job not found';
		    	}
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function createMasterSection($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$section = MasterSection::create([
		    		'name'  			=> $request->section_name,
		    		'created_by'   		=> \Auth::getUser()->id
		    	]);

		    	if($section)
		    	{
		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Master Section created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Master Section faild';
		    	}
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function createMasterTask($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$task = MasterSectionTask::create([
		    		'master_section_id'	=> $request->master_section,
		    		'task_category_id'	=> $request->task_category,
		    		'name'				=> $request->task_title,
		    		'inspection_name' 	=> $request->inspection_title,
		    		'created_by' 		=> \Auth::getUser()->id
		    	]);

		    	if($task)
		    	{
		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Master Task created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Master Task faild';
		    	}
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function deleteMasterTask($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$task = MasterSectionTask::find($request->task_id);

		    	if($task->delete())
		    	{
		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Master Task Deleted';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Deletion faild';
		    	}
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
   
}
