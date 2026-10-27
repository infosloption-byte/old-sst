<?php
namespace App\Modules\ClientManage\Controllers;


use DB;
use Mail;
use Sentinel;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\TransactionException;
use App\Http\Controllers\MailController;

use App\Models\User;
use System\Employee\Models\Employee;

use System\UserRoles\Models\UserRole;
use System\Permissions\Models\Permission;

use Core\UserRoles\Http\Requests\UserRoleRequest;
use Core\PermissionGroups\Models\PermissionGroup;

use System\UserRoles\Http\BusinessLogic\UserRoleLogic;
use System\Department\BusinessLogic\DepartmentLogic;
use System\Department\Models\Department;

use App\Modules\RegistrationRequestManage\Models\RegistrationRequest;

class ClientController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Client Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	protected $roleLogic;
	protected $departmentLogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(UserRoleLogic $roleLogic,DepartmentLogic $departmentLogic, MailController $mailController)
	{
		$this->middleware('auth');
		$this->roleLogic = $roleLogic;
		$this->departmentLogic = $departmentLogic;
		$this->mailController = $mailController;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		$supervisors =  Employee::all();
		$employee_list =  Employee::with(['user.roles','department'])->where('type','client')->get();
		$departments   = $this->departmentLogic->getAllDepartments();

		$user = \Auth::user();

		return view('ClientManage::index',compact('employee_list','supervisors','departments','user'));
	}

	public function create(Request $request)
	{
		DB::transaction(function () use($request)
		{
			$user = \Auth::user();

			$employee = Employee::create([
				'first_name' => $request->first_name,
				'last_name' => $request->last_name,
				'email' => $request->email,
				'address' => $request->address,
				'phone' => $request->phone,
				'employee_no' => $request->employee_no,
				'code' => '',
				'department_id' => $request->department,
				'created_by' => $user->id,
				'status' => 1,
				'gender' => $request->gender,
				'type' => 'client',
				'company' => $request->company,
				'is_hod' => $request->is_hod?$request->is_hod:0
			]);

			$employee->code = "CL/".str_pad($employee->id,6,0,STR_PAD_LEFT)."";
			$employee->save();

			$employee->makeRoot()->save();

			if($request->is_user>0)
			{
				$newuser = User::create([
		            'name' => $request->first_name.' '.$request->last_name,
		            'username' => $request->username,
		            'email' => $request->email,
		            'password' => bcrypt($request->password),
		            'employee_id' => $employee->id
		        ]);

		        Mail::send('emails.password', ['data' => ['username'=>$request->username,'password'=>$request->password]], function ($m)use($request)
	            {
	                $m->from('admin@sisfs.com.au', 'SISFS user account created');
	                $m->to($request->email)->subject('Your SISFS account created');
	            });

		        foreach (json_decode($request->roles) as $key => $role) {
		        	$attachrole = new UserRole();
					$attachrole->id = $role->id;
					$newuser->attachRole($attachrole);
		        }

		        if($request->is_hod==1){
					$department = Department::find($request->department);
					$department->hod_id = $newuser->id;
					$department->save();
				}

			}
			
		});
		return response()->json(['status'=>1]);
	}


	public function update(Request $request)
	{
		DB::transaction(function () use($request)
		{
			$user = \Auth::user();

			$employee = Employee::find($request->employee_id);

			$employee->first_name     = $request->first_name;
			$employee->last_name      = $request->last_name;
			$employee->email          = $request->email;
			$employee->address        = $request->address;
			$employee->phone          = $request->phone;
			$employee->employee_no    = $request->employee_no;
			$employee->department_id  = $request->department;
			$employee->gender         = $request->gender;
			$employee->type           = 'client';
			$employee->company        = $request->company;
			$employee->is_hod         = $request->is_hod;
			$employee->save();

			$employee->makeRoot()->save();


			if($request->is_user>0 && $request->user_id==0){
				$newuser = User::create([
		            'name' => $request->first_name.' '.$request->last_name,
		            'username' => $request->username,
		            'email' => $request->email,
		            'password' => bcrypt($request->password),
		            'employee_id' => $employee->id
		        ]);

		        Mail::send('emails.password', ['data' => ['username'=>$request->username,'password'=>$request->password]], function ($m)use($request)
	            {
	                $m->from('admin@sisfs.com.au', 'SISFS user account created');
	                $m->to($request->email)->subject('Your SISFS account created');
	            });

		        foreach (json_decode($request->roles) as $key => $role) {
		        	$attachrole = new UserRole();
					$attachrole->id = $role->id;
					$newuser->attachRole($attachrole);
		        }

		        if($request->is_hod && $request->is_hod==1){
					$department = Department::find($request->department);
					$department->hod_id = $newuser->id;
					$department->save();
				}

			}

			if($request->user_id>0){

				$updateuser = User::find($request->user_id);
				$updateuser->name     = $request->first_name.' '.$request->last_name;
		        $updateuser->email    = $request->email;

		        if($request->reset_password>0){
					$updateuser->username = $request->username;
					$updateuser->password = bcrypt($request->password);
		        }

		        $updateuser->save();

		        $roles = $updateuser->roles()->sync([]);


		        foreach (json_decode($request->roles) as $key => $role) {
		        	$attachrole = new UserRole();
					$attachrole->id = $role->id;
					$updateuser->attachRole($attachrole);
		        }

		        if($request->is_hod &&  $request->is_hod==1){
					$department = Department::find($request->department);
					$department->hod_id = $updateuser->id;
					$department->save();
				}

			}
		});

		return response()->json(['status'=>1]);
	}

	public function getroles(){
		$response = $this->roleLogic->getAllRoles();
		return response()->json($response);
	}

	public function getDepartments(){
		$response = $this->departmentLogic->getAllDepartments();
		return response()->json($response);
	}

	public function getSupervisors(){
		$response = $supervisors =  Employee::all();
		return response()->json($response);
	}

	public function getemployee(Request $request){

		$response['roles'] = [];
		$response['employee'] = null;

		$employee = Employee::with(['user.roles'])->find($request->id);
		if($employee){
			$response['employee'] = $employee;
			if($employee->user){
				$response['roles'] = $this->roleLogic->getRolesToEdit($employee->user->id);
			}else{
				$response['roles'] = $this->roleLogic->getAllRoles();
			}
		}
		
		return response()->json($response);
	}

	public function delete(Request $request)
	{
		try {
			$employee = Employee::find($request->id);
			if($employee){
				$user = User::where('employee_id',$request->id)->get();
				if(count($user)>0){
					$json = [
			            'success' => false,
			            'error' => [
			                'code' => 5000,
			                'message' => "Cannot delete the employee, this employee releated to user.Would you like to delete all related data",
			            ],
			        ];
			        return response()->json($json);
				}
				DB::transaction(function () use($request,$employee){
					$user = \Auth::user();
					$employee->delete();
					$json = [
			            'success' => true,
			            'error' => [
			                'code' => 200,
			                'message' => "deleted successfully",
			            ],
			        ];
			        return response()->json($json);
				
				});
			}else{
				$json = [
		            'success' => false,
		            'error' => [
		                'code' => 404,
		                'message' => "Cannot find the employee",
		            ],
		        ];
		        return response()->json($json);
			}
		} catch (Exception $e) {
			$json = [
	            'success' => false,
	            'error' => [
	                'code' => $e->getCode(),
	                'message' => $e->getMessage(),
	            ],
	        ];
		}

		$json = [
            'success' => true,
            'error' => [
                'code' => 400,
                'message' => "Deleted",
            ],
        ];
        return response()->json($json);

	}

	public function deleteWithRelations(Request $request)
	{
		try {
			$employee = Employee::find($request->id);
			if($employee){
				$user = User::where('employee_id',$request->id)->first();
				DB::transaction(function () use($request,$employee,$user){
					$roles = $user->roles()->sync([]);
					$user->delete();
					$employee->delete();

					$employee->delete();
					$json = [
			            'success' => true,
			            'error' => [
			                'code' => 200,
			                'message' => "deleted with all relations,User,Role and employee",
			            ],
			        ];
			        return response()->json($json);
				
				});
			}else{
				$json = [
		            'success' => false,
		            'error' => [
		                'code' => 404,
		                'message' => "Cannot find the employee",
		            ],
		        ];
		        return response()->json($json);
			}
		} catch (Exception $e) {
			$json = [
	            'success' => false,
	            'error' => [
	                'code' => $e->getCode(),
	                'message' => $e->getMessage(),
	            ],
	        ];
		}

		$json = [
            'success' => true,
            'error' => [
                'code' => 400,
                'message' => "Deleted",
            ],
        ];
        return response()->json($json);

	}

	public function resetPassword(Request $request)
	{
		$response = [];

		DB::transaction(function () use($request,&$response)
		{
			$updateuser = User::where('employee_id',$request->reset_employee_id)->first();

			if($updateuser)
			{
				$updateuser->username = $request->reset_username;
				$updateuser->password = bcrypt($request->reset_password1);
				$updateuser->save();

				Mail::send('emails.password', ['data' => ['username'=>$request->reset_username,'password'=>$request->reset_password1]], function ($m)use($updateuser)
	            {
	                $m->from('admin@sisfs.com.au', 'SISFS user account created');
	                $m->to($updateuser->email)->subject('Your SISFS account created');
	            });
				
				$response = [
					'status' => 1,
					'msg' => 'Reset'
				];
			}else{
				$response = [
					'status' => 0,
					'msg' => 'User not found'
				];
			}

		});

		return $response;
	}

	public function sendAccountDetails(Request $request)
	{
		$employee = Employee::find($request->id);

		$this->mailController->sendPasswordMail($employee);
	}


}
