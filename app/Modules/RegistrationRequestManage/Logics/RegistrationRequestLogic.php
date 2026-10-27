<?php

namespace App\Modules\RegistrationRequestManage\Logics;

use DB;
use Mail;
use Excel;
use Sentinel;
use Response;
use Exception;
use Carbon\Carbon;
use App\Classes\Functions;

use App\Http\Controllers\MailController;

use App\Modules\RegistrationRequestManage\Models\RegistrationRequest;

class RegistrationRequestLogic
{
        
    public function __construct(Functions $common, MailController $mailcontrol)
    {
        $this->common = $common;
        $this->mailcontrol = $mailcontrol;
    }

    public function createRegisterRequest($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$res = RegistrationRequest::create([
		    		'first_name'   	=> $request->first_name,
		    		'last_name'    	=> $request->last_name,
	                'email'   		=> $request->email,
	                'contact_no'   	=> $request->contact_no,
		    		'building_no'   => $request->building,
		    		'street'        => $request->street,
		    		'city'  		=> $request->city,
		    		'state'       	=> $request->state,
	                'postal_code'   => $request->postal_code
		    	]);

		    	if($res)
		    	{
		    		// if ($request->hasFile('profile_pic'))
        //             {
        //             	$filePath = 'attachments/profile_pics';
                        
        //                 $this->common->makeDirNotExist($filePath, 0777, true);
        //                 $fileName = '';

        //                 $profilePic = $request->file('profile_pic');

        //                 $extn = $profilePic->getClientOriginalExtension(); //get extension

        //                 $fileName = date('YmdHis').'.'.$extn; //set file name

        //                 $destinationPath = storage_path($filePath); // destination
        //                 $profilePic->move($destinationPath, $fileName);//move to file

        //                 $res->profile_pic = $fileName;
        //                 $res->save();
        //             }

                    Mail::send('emails.contact_ok', ['data' => []], function ($m)use($res)
                    {
		                $m->from('admin@sisfs.com.au', 'Welcome to SISFS');
		                $m->to($res->email)->subject('Welcome to SISFS ');
		            });

                    Mail::send('emails.join_request', ['data' => $res], function ($m)
                    {
		                $m->from('admin@sisfs.com.au', 'New join request');
		                $m->to('gayan@sisfs.com.au')->subject('New join request ');
		                $m->cc('vanessa@sisfs.com.au');
		                $m->bcc('chathu.ad@gmail.com');
		            });

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Register request created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Register request faild';
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

    public function getRegistrationRequestData($request)
    {
	    $user = \Auth::user();

		$data = RegistrationRequest::whereNull('deleted_at');

		if(isset($request->keyword) && $request->keyword!='')
		{
			$data = $data->where('first_name','like','%'.$request->keyword.'%')
					->orWhere('last_name','like','%'.$request->keyword.'%')
					->orWhere('email','like','%'.$request->keyword.'%')
					->orWhere('contact_no','like','%'.$request->keyword.'%');
		}

		if(isset($request->city) && $request->city!='')
		{
			$data = $data->where('city','like','%'.$request->city.'%');
		}

		if(isset($request->state) && $request->state!='')
		{
			$data = $data->where('state','like','%'.$request->state.'%');
		}

		$data = $data->orderBy('status','asc')->orderBy('created_at','DESC')->paginate(10);

		return $data;
	}

	public function approveRequest($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$res = RegistrationRequest::find($request->id);

		    	if($res)
		    	{
		    		$res->status = 1;

		    		$res->approved_by = \Auth::user()->id;
		    		$res->approved_at = date('Y-m-d H:i:s');
		    		$res->save();

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Request approved';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Request approval faild';
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

	public function rejectRequest($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$res = RegistrationRequest::find($request->id);

		    	if($res)
		    	{
		    		$res->status = 2;

		    		$res->rejected_reason = $request->reason;
		    		$res->rejected_by = \Auth::user()->id;
		    		$res->rejected_at = date('Y-m-d H:i:s');
		    		$res->save();

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Request rejected';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Request rejection faild';
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

	public function createEmployee($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$res = RegistrationRequest::find($request->id);

		    	if($res)
		    	{
		    		$res->status = 3;

		    		$res->rejected_reason = $request->reason;
		    		$res->rejected_by = \Auth::user()->id;
		    		$res->rejected_at = date('Y-m-d H:i:s');
		    		$res->save();

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'EMployee created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Employee creation faild';
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
