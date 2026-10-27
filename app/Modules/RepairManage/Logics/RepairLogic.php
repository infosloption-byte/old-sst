<?php
namespace App\Modules\RepairManage\Logics;

use DB;
use Mail;
use Excel;
use Sentinel;
use Response;
use Exception;
use Carbon\Carbon;
use App\Classes\Functions;

use System\Employee\Models\Employee;
use App\Modules\RepairManage\Models\Repair;
use App\Modules\RepairManage\Models\RepairType;
use App\Modules\RepairManage\Models\RepairAttachment;

class RepairLogic 
{
        
    public function __construct(Functions $common)
    {
        $this->common = $common;
    }

    public function createRepair($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$repair = Repair::create([
		    		'repair_type_id'  	=> $request->repair_type,
		    		'asset'    		=> $request->asset,
	                'location'   	=> $request->location,
	                'remark'   		=> $request->remark,
		    		'lng'   			=> $request->lng,
		    		'lat'        		=> $request->lat,
		    		'created_by'		=> \Auth::getUser()->id
		    	]);

		    	if($repair)
		    	{
		    		$repair->reference_no = "RP".str_pad($repair->id,6,0,STR_PAD_LEFT)."";
		    		$repair->save();

		    		if(isset($request->repair_images))
                    {
                    	foreach ($request->repair_images as $value)
                    	{
                    		$filePath = 'uploads/repairs';
	                        
	                        $this->common->makeDirNotExist($filePath, 0777, true);
	                        $fileName = '';

	                        $extn = $value->getClientOriginalExtension(); //get extension

	                        $_img = RepairAttachment::create([
	                        	'repair_id' => $repair->id
	                        ]);

	                        $fileName = $repair->reference_no.'_'.$_img->id.'.'.$extn; //set file name

	                        $destinationPath = storage_path($filePath); // destination
	                        $value->move($destinationPath, $fileName);//move to file

	                        $_img->file_name = $fileName;
	                        $_img->image_url = "uploads/repairs/".$fileName;
		                    $_img->save();
                    	}
                    }

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Repair created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Repair faild';
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

    public function repairTypeList($request)
    {
    	return RepairType::all();
    }

    public function deleteRepair($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$repair = Repair::where('id',$request->repair_id)->first();

				if($repair->delete())
		    	{
		    		$attachments = RepairAttachment::where('repair_id',$repair->id)->get();

		    		if($attachments)
		    		{
		    			foreach ($attachments as $key => $attachment)
		    			{
		    				unlink(storage_path('uploads/repairs/'.$attachment->file_name));

		    				$attachment->delete();
		    			}
		    		}

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Repair data deleted';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Repair data delete faild';
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

    public function updateRepair($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$repair = Repair::find($request->edit_repair_id);

				if($repair)
				{
					$repair->repair_type_id = $request->edit_repair_type;
		    		$repair->asset 			= $request->edit_asset;
	                $repair->location   	= $request->edit_location;
	                $repair->remark   		= $request->edit_remark;
	                $repair->created_by   	= $request->edit_report_by;

			    	if($repair->save())
			    	{
			    		if(isset($request->repair_images))
	                    {
	                    	foreach ($request->repair_images as $value)
	                    	{
	                    		$filePath = 'uploads/repairs';
		                        
		                        $this->common->makeDirNotExist($filePath, 0777, true);
		                        $fileName = '';

		                        $extn = $value->getClientOriginalExtension(); //get extension

		                        $_img = RepairAttachment::create([
		                        	'repair_id' => $repair->id
		                        ]);

		                        $fileName = $repair->code.'_'.$_img->id.'.'.$extn; //set file name

		                        $destinationPath = storage_path($filePath); // destination
		                        $value->move($destinationPath, $fileName);//move to file

		                        $_img->file_name = $fileName;
		                        $_img->image_url = "uploads/repairs/".$fileName;
			                    $_img->save();
	                    	}
	                    }

			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Repair data updated';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Repair data updated faild';
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

    public function deleteRepairAttachment($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$attachment = RepairAttachment::find($request->image_id);

		    	if($attachment)
		    	{
		    		if($attachment->delete())
		    		{
		    			if(file_exists(storage_path('uploads/repairs/'.$attachment->file_name)))
				        {
				            unlink(storage_path('uploads/repairs/'.$attachment->file_name));
				        }

		    			$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Attachment deleted';
		    		}else{
		    			$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Attachment delete faild';
		    		}
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Attachment not found';
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
