<?php
namespace App\Modules\InspectionManage\Logics;

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

class InspectionLogic 
{
        
    public function __construct()
    {
        
    }

    public function createInspection($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$inspection = InspectionJob::create([
		    		'job_id'  	=> $request->job_category,
		    		'assigned_manager_id' => $request->client,
	                'inspection_date'  => $request->job_title,
		    		'start_at'	=> $request->start_date,
		    		'end_at'    => $request->end_date,
	                'status'    => 0,
		    		'created_by' => \Auth::getUser()->id
		    	]);

		    	if($job)
		    	{
		    		$job->reference_no = "INJ/".str_pad($job->id,6,0,STR_PAD_LEFT)."";
		    		$job->save();

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Job Inspection created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Job Inspection faild';
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
