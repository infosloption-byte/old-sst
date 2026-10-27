<?php
namespace App\Modules\ProfileManage\Controllers;

use DB;
use Sentinel;
use Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\BodyMeasurement;

use System\Employee\Models\Employee;
use System\Department\Models\Department;
use App\Modules\ProfileManage\Logics\ProfileLogic;
use Illuminate\Support\Facades\Hash;

class ProfileManageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Role Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $profileLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(ProfileLogic $profileLogic)
	{
		$this->middleware('auth');
		$this->profileLogic = $profileLogic;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_id = \Auth::user()->id;
		$day = Carbon::now('Asia/Colombo')->toDateString();
		$user_details = User::where('id',$user_id)->with(['employee.department','employee.supervisor'])->first();
		return view('ProfileManage::index',compact('user_details'));
	}

	public function saveBasicProfileDetails(Request $request)
	{
		try{
			$user = \Auth::user();
			$day = Carbon::now('Asia/Colombo')->toDateString();
			
			$_user = User::find($user->id);
			$_employee = Employee::find($user->employee_id);

			$savePath = storage_path('attachments/profile_pics');


			if ($request->hasFile('files')){
	            $file = $request->file('files');

	            $image = $file->getClientOriginalName();
				//return json_encode($image);

	            $_old_image = storage_path('attachments/profile_pics').'/'.$_user->image;
				if($_user->image && file_exists($_old_image)){
					unlink($_old_image);
				}

				$file_ext = $file->getClientOriginalExtension();
				$name = date("YmdHis").'_'.$user->id.'.'.$file_ext;

	            $file->move($savePath,$name);

	            $_user->image = 'attachments/profile_pics'.'/'.$name;
	            $_employee->image = 'attachments/profile_pics'.'/'.$name;
				$_user->save();
				$_employee->save();
			}

			if($request->first_name!=""){
				$_employee->first_name=$request->first_name;
				$_employee->save();
			}

			if($request->last_name!=""){
				$_employee->last_name=$request->last_name;
				$_employee->save();
			}

			if(($request->first_name.$request->last_name)!=""){
				$_user->name=$request->first_name." ".$request->last_name;
				$_user->save();
			}

			if($request->email!=""){
				$_employee->email=$request->email;
				$_user->email=$request->email;
				$_employee->save();
				$_user->save();
			}

			if($request->contact!=""){
				$_employee->phone=$request->contact;
				$_employee->save();
			}
			return response()->json(1);
		} catch (\Exception $e) {
			throw new \Exception('message: '.$e->getMessage());
		}


		// $_last_body_measures = $this->profileLogic->getUserLastBodyMeasurement($user_id);
	}


	public function resetPassword(Request $request)
	{
		$user = \Auth::user();

		if(!Hash::check($request->old, $user->password)){
			return ['status'=>0,'msg'=>'invalid old password'];
		}else{
			if($request->new!=$request->confirm){
				return ['status'=>0,'msg'=>'confirmation password mismatch'];
			}
		}

		$user->password = Hash::make($request->new);
        $user->save(); 

		 \Auth::logout();

		 return ['status'=>1,'msg'=>'done'];
		//ok
	}

}
