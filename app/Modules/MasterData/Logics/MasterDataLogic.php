<?php
namespace App\Modules\MasterData\Logics;

use DB;
use Mail;
use Excel;
use Sentinel;
use Response;
use Exception;
use Carbon\Carbon;
use App\Classes\Functions;

use System\Employee\Models\Employee;

use App\Models\Designation;
use App\Models\CostType;

class MasterDataLogic 
{
	/////////////// Designation Function Start ///////////////

	public function __construct(Functions $common)
    {
        $this->common = $common;
    }

    public function createDesignation($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$designation = Designation::create([
		    		'name' => $request->designation
		    	]);

		    	if($designation)
		    	{
		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Designation created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Designation faild';
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

    public function getDesignationList($request)
    {
    	$designations = Designation::whereNull('deleted_at');

    	$response = $designations->paginate(10);

    	return $response;
    }

    public function updateDesignation($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$designation = Designation::find($request->edit_designation_id);

				if($designation)
				{
					$designation->name = $request->edit_designation;

			    	if($designation->save())
			    	{
			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Designation data updated';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Designation data updated faild';
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

    public function deleteDesignation($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$designation = Designation::find($request->designation_id);

				if($designation->delete())
		    	{
		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Designation data deleted';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Designation data delete faild';
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

    /////////////// Designation Function End ///////////////

	/////////////// Cost Type Function Start ///////////////

    public function createCostType($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$costtype = CostType::create([
		    		'name' => $request->cost_type
		    	]);

		    	if($costtype)
		    	{
		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Cost Type created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Cost Type faild';
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

    public function getCostTypeList($request)
    {
    	$costtypes = CostType::whereNull('deleted_at');

    	$response = $costtypes->paginate(10);

    	return $response;
    }

    public function updateCostType($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$costtype = CostType::find($request->edit_cost_type_id);

				if($costtype)
				{
					$costtype->name = $request->edit_cost_type;

			    	if($costtype->save())
			    	{
			    		$response['status_code'] = 200;
			    		$response['message'] = 'Success';
			    		$response['debug'] = 'Cost type data updated';
			    	}else{
			    		$response['status_code'] = 500;
			    		$response['message'] = 'Faild';
			    		$response['debug'] = 'Cost type data updated faild';
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

    public function deleteCostType($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$costtype = CostType::find($request->cost_type_id);

				if($costtype->delete())
		    	{
		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Cost type data deleted';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Cost type data delete faild';
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

	/////////////// Cost Type Function End ///////////////
   
}
