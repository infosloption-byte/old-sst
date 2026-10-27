<?php
namespace App\Modules\InquiryManage\Controllers;

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

use App\Modules\JobManage\Models\Job;
use App\Modules\InquiryManage\Models\Inquiry;
use App\Modules\InquiryManage\Logics\InquiryLogic;

class InquiryController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Inquiry Controller
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
	public function __construct(InquiryLogic $inquiryLogic)
	{
		$this->middleware('auth');
		$this->inquiryLogic = $inquiryLogic;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function createInquiry(Request $request)
    {
        $details = $this->inquiryLogic->createInquiry($request);

        return response()->json($details);
    }

    public function createInquiryByCustomer(Request $request)
    {
        $details = $this->inquiryLogic->createInquiryByCustomer($request);

        return response()->json($details);
    }

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function approveInquiry(Request $request)
    {
        $details = $this->inquiryLogic->approveInquiry($request);

        return response()->json($details);
    }

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function rejectInquiry(Request $request)
    {
        $details = $this->inquiryLogic->rejectInquiry($request);

        return response()->json($details);
    }

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		return view('InquiryManage::index');
	}

	public function getInquiryListJson(Request $request)
	{
		$user = \Auth::getUser();

		$inquiries = Inquiry::whereNull('deleted_at')->with(['client','attachments','job']);
		
		if($user->roles[0]->name == 'External')
		{
			$inquiries = $inquiries->where('client_id',$user->employee_id);
		}

		if($request->status!=null)
		{
			$inquiries = $inquiries->where('status',$request->status);
		}

		if($request->keyword)
		{
			$inquiries = $inquiries->where(function($aa) use($request){
				$aa->where('first_name','LIKE','%'.$request->keyword.'%')
					->orWhere('last_name','LIKE','%'.$request->keyword.'%')
					->orWhere('inq_no','LIKE','%'.$request->keyword.'%')
					->orWhere('notes','LIKE','%'.$request->keyword.'%')
					->orWhere('email','LIKE','%'.$request->keyword.'%')
					->orWhere('last_name','LIKE','%'.$request->keyword.'%')
					->orWhere('last_name','LIKE','%'.$request->keyword.'%');
			});
		}

		$inquiries = $inquiries->orderBy('status','ASC')->orderBy('created_at','DESC')->paginate(10);

		return response()->json($inquiries);
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function createInquiryView(Request $request)
	{
		$user = \Auth::user();

		$jobs = Job::where('client_id',$user->employee_id)->get();

		return view('InquiryManage::create',compact('jobs','request'));
	}

	public function createClientInquiry(Request $request)
	{
		$user = \Auth::user();

		$details = $this->inquiryLogic->createClientInquiry($request);

        return response()->json($details);
	}


	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function sendMail(Request $request)
	{	
		$res = [];
		$res['status'] = 0;
		$res['message'] = '';

		DB::transaction(function () use($request,&$res){
			$user = \Auth::user();
			$day  = Carbon::now('Asia/Colombo')->toDateString();
			$inq  = Inquiry::with(['tour','payment.actvtran','files'])->find($request->id);
			$attach = [];
			
			if($inq->email!=null){
				$emails = [$inq->email => $inq->first_name.''.$inq->last_name];
				Mail::send('emails.inquiry_payment',['inq' => $inq],function($m) use ($emails,$inq){
		            $m->from('admin@sisfs.com.au', 'SISFS');
		            if(BCC_SRIYA){
		            	$m->bcc('chathu.ad@gmail.com');
		        	}
		        	$m->cc('admin@sisfs.com.au');
	            	$m->cc('gayan@sisfs.com.au');

		            $m->to($emails)->subject('Customer Inquiry');
		        });
		        $res['status'] = 1;
				$res['message'] = 'send';
			}else{
				$res['status'] = 0;
				$res['message'] = 'no email address to send an email';
			}
		});

		
		return response()->json($res);
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function mail(Request $request)
	{
		return view('emails.inquiry_payment');
	}

	

}
