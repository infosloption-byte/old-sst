<?php

namespace App\Modules\InquiryManage\Logics;

use DB;
use Mail;
use Excel;
use Sentinel;
use Response;
use Exception;
use Carbon\Carbon;
use App\Classes\Functions;
use Illuminate\Support\Facades\URL;

use App\Models\Appointment;
use App\Models\RateUs;
use App\Modules\InquiryManage\Models\Inquiry;
use App\Modules\InquiryManage\Models\InquiryAttachment;
use System\Employee\Models\Employee;

class InquiryLogic 
{
        
    public function __construct(Functions $common)
    {
        $this->common = $common;
    }

    public function bookNow($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$appointment = Appointment::create([
		    		'first_name'   	=> $request->first_name,
		    		'last_name'    	=> $request->last_name,
	                'email'   		=> $request->email,
	                'contact_no'   	=> $request->contact_no,
		    		'inquiry_type'  => $request->app_type,
		    		'placement'  	=> $request->tattoo_placement,
		    		'appointment_date' => $request->app_date,
		    		'appointment_time' => $request->app_time
		    	]);

		    	if($appointment)
		    	{
		    		$appointment->code = "APP/".str_pad($appointment->id,6,0,STR_PAD_LEFT)."";
		    		$appointment->save();

		    		// Mail::send('emails.new_inquiry', ['data' => $appointment], function ($m)use($appointment)
		            // {
		            //     $m->from('info.southernstartattoo@gmail.com', 'Client Appointment');
		            //     $m->cc(['csriyarathne@gmail.com']);
		            //     $m->to($appointment->email)->subject("Client appointment - ".$appointment->code);
		            // });

		            // Mail::send('emails.customer_inquiry', ['data' => $appointment], function ($m)use($appointment)
		            // {
		            //     $m->from($appointment->email, 'Customer appointment');
		            //     $m->to(['info.southernstartattoo@gmail.com','csriyarathne@gmail.com'])->subject("Customer appointment - ".$appointment->code);
		            // });

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Appointment created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Appointment faild';
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

    public function rateUs($request)
    {
    	$response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$rating = RateUs::create([
		    		'first_name'   	=> $request->first_name,
		    		'last_name'    	=> $request->last_name,
	                'email'   		=> $request->email,
	                'contact_no'   	=> $request->contact_no,
		    		'rating_value'  => $request->rate,
		    		'remark'  		=> $request->remark
		    	]);

		    	if($rating)
		    	{
		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Rating created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Rating faild';
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
