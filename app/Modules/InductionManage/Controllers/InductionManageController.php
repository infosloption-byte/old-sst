<?php
namespace App\Modules\InductionManage\Controllers;

use DB;
use PDF;
use Image;
use Sentinel;
use Response;
use Storage;
use Mail;
use Carbon\Carbon;
use App\Classes\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;

use App\Modules\InductionManage\Models\Induction;
use App\Modules\InductionManage\Models\InductionQuestion;
use App\Modules\InductionManage\Models\Exam;
use App\Modules\CertificationManage\Logics\CertificationLogic;
use App\Modules\CertificationManage\Models\EmployeeCertification;

class InductionManageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Induction Manage Controller
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
	public function __construct(Functions $common,CertificationLogic $certificationLogic)
	{
		$this->middleware('auth');
		$this->common = $common;
		$this->certificationLogic = $certificationLogic;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$user = \Auth::user();

		return view('InductionManage::induction.index');
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function viewPdf(Request $request)
	{
		$user = \Auth::user();

		return view('InductionManage::induction.view-pdf');
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function getEmployeeCertifications(Request $request)
	{
		$user = \Auth::user();

		$data = $this->certificationLogic->getAllCertifications($request);

		return response()->json($data);
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function getInductionQuestions(Request $request)
	{
		$user = \Auth::user();

		$old_exam_qs = Exam::where('user_id',$user->id)->get();

		if(count($old_exam_qs)>0)
		{
			$question_ids = [];

			foreach ($old_exam_qs as $value)
			{
				if($value->given_answer!=$value->real_answer)
				{
					$question_ids[] = $value->q_id;
				}
			}

			$questions = InductionQuestion::whereIn('id',$question_ids)->get();

		}else{
			$questions = InductionQuestion::all()->random(25)->shuffle();
		}

		Exam::where('user_id',$user->id)->delete();

		foreach ($questions as $value)
		{
			Exam::create([
				'user_id' => $user->id,
				'q_id' => $value->id,
				'real_answer' => $value->answer,
				'created_by' => $user->id
			]);
		}

		return response()->json([]);
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function getUserExamQuestions(Request $request)
	{
		$user = \Auth::user();

		$questions = Exam::where('user_id',$user->id)->with(['question.answers']);

		$questions = $questions->paginate(1);

		return $questions;
	}

	public function resetUserExam(Request $request)
	{
		$user = \Auth::user();

		$res = Exam::where('user_id',$user->id)->delete();

		if($res){
			return response()->json([
                'status_code' => 200,
                'msg' => 'success'
            ]);
		}else{
			return response()->json([
                'status_code' => 404,
                'msg' => 'faild'
            ]);
		}

		return $questions;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function saveUserExamAnswer(Request $request)
	{
		$user = \Auth::user();

		$result = Exam::find($request->question);

		if($result)
		{
			$result->given_answer = $request->given_answer;
			$result->save();
			return $result;
		}else{
			return [];
		}

	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function checkUserExamAnswer(Request $request)
	{
		$user = \Auth::user();

		$exam_result = Exam::where('user_id',$user->id)->whereNull('given_answer')->get();

		if($exam_result && count($exam_result)>0)
		{
			return ['status_code'=>100, 'message'=>'Cannot finish exam','debug'=>'Please answer to all questions'];
		}else{
			$exam_result = Exam::where('user_id',$user->id)->get();

			$marks = 0;

			$total = count($exam_result)*4;

			foreach ($exam_result as $value)
			{
				if($value->given_answer == $value->real_answer)
				{
					$marks += 4;
				}
			}

			if($marks == $total)
			{
				$certified = EmployeeCertification::create([
					'employee_id' => $user->employee_id,
					'certification_id' => 3,
					'exam_date' => date('Y-m-d H:i:s'),
					'exam_mark' => 100,
					'status' => 1
				]);

				if($certified)
				{
					$certified->reg_no = "CERT".str_pad($certified->id,6,0,STR_PAD_LEFT)."";

					$certified->save();

					$data = EmployeeCertification::where('id',$certified->id)->with(['certification','employee'])->first();

					$pdf = PDF::loadView('InductionManage::induction.certificate-view', compact('data'))->save('storage/uploads/employee_certificate/'.$certified->reg_no.'.pdf');

					Mail::send('emails.certified_mail', ['data' => $certified], function ($m)use($certified)
		            {
		                $m->from('admin@sisfs.com.au', 'Congratulations');
		                $m->to($certified->employee->email)->subject("You're successfuly certified by SISFS");
		            });
				}

				Exam::where('user_id',$user->id)->delete();

				return ['status_code'=>200, 'message'=>'Well Done..!','debug'=>'You passed the exam. Check your certificate'];
			}else{
				return ['status_code'=>300, 'message'=>' Please try again','debug'=>'You got only '.$marks.' from '.$total.'.'];
			}

		}

	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function getUserInductionCertificate(Request $request)
	{
		$user = \Auth::user();

		$data = EmployeeCertification::where('employee_id',$user->employee_id)
			->where('certification_id',3)
			->with(['certification','employee'])
			->get();

		return response()->json($data);
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function getInductionData(Request $request)
	{
		$user = \Auth::user();

		$data = Induction::all();

		return response()->json($data);
	}

	/**
	 * Check user has any image
	 *
	 * @return Response
	 */
	public function getUserImage(Request $request)
	{	
		$user = \Auth::user();

		if($user->image && $user->image!='' && file_exists(storage_path($user->image)))
		{
			return response()->json([
                'status_code' => 200,
                'msg' => 'success'
            ]);
		}else{
			return response()->json([
                'status_code' => 404,
                'msg' => 'User has no profile image. Please update user profile image to show certificate'
            ]);
		}
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function viewCertificate($id)
	{	
		$data = EmployeeCertification::where('id',$id)->with(['certification','employee'])->first();

		$pdf = PDF::loadView('InductionManage::induction.certificate-view', compact('data'));
		
		return $pdf->setPaper('a4')->stream('certificate.pdf');
	}
}
