<?php
namespace System\Employee\Http\Controllers;

use System\Permissions\Models\Permission;
use System\UserRoles\Models\UserRole;

use App\Http\Controllers\Controller;
use Core\UserRoles\Http\Requests\UserRoleRequest;
use Core\PermissionGroups\Models\PermissionGroup;

use Illuminate\Http\Request;
use Response;
use Sentinel;
use Carbon\Carbon;
use DB;
use Mail;
use App\Exceptions\TransactionException;
use System\Employee\Models\Employee;
use App\Models\User;
use App\Models\Designation;
use App\Classes\Functions;
use App\Classes\TextToImage;

use System\UserRoles\Http\BusinessLogic\UserRoleLogic;
use System\Department\BusinessLogic\DepartmentLogic;
use System\Department\Models\Department;

use App\Http\Controllers\MailController;

use App\Modules\RegistrationRequestManage\Models\RegistrationRequest;

use App\Http\Controllers\Api\IssueTokenTrait;

class EmployeeController extends Controller {

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
	protected $roleLogic;
	protected $departmentLogic;
	protected $common;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(UserRoleLogic $roleLogic,DepartmentLogic $departmentLogic, MailController $mailController, Functions $functions)
	{
		$this->middleware('auth');
		$this->roleLogic = $roleLogic;
		$this->departmentLogic = $departmentLogic;
		$this->mailController = $mailController;
		$this->common = $functions;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		$supervisors =  Employee::where('type','employee')->get();
		$employee_list =  Employee::with(['user.roles','department','designation','certification'])->where('type','employee')->get();
		$departments   = $this->departmentLogic->getAllDepartments();
		$designations  = Designation::all();

		$user = \Auth::user();

		return view('Employee::employee.list',compact('employee_list','designations','supervisors','departments','user'));
	}

	public function create(Request $request)
	{
		DB::transaction(function () use($request)
		{
			$user = \Auth::user();

			if($request->supervisor=="0"){
				$employee = Employee::create([
					'first_name' => $request->first_name,
					'last_name' => $request->last_name,
					'email' => $request->email,
					'phone' => $request->phone,
					'employee_no' => $request->employee_no,
					'code' => '',
					'department_id' => $request->department,
					'designation_id' => $request->designation,
					'created_by' => $user->id,
					'status' => 1,
					'gender' => $request->gender,
					'type' => $request->type,
					'is_hod' => $request->is_hod?$request->is_hod:0
				]);

				$employee->code = "EMP/".str_pad($employee->id,6,0,STR_PAD_LEFT)."";
				$employee->save();

				$employee->makeRoot()->save();
			}else{

				$supervisor = Employee::find($request->supervisor);

				$employee = Employee::create([
					'first_name' => $request->first_name,
					'last_name' => $request->last_name,
					'email' => $request->email,
					'phone' => $request->phone,
					'employee_no' => $request->employee_no,
					'code' => '',
					'department_id' => $request->department,
					'designation_id' => $request->designation,
					'created_by' => $user->id,
					'status' => 1,
					'gender' => $request->gender,
					'type' => $request->type,
					'is_hod' => $request->is_hod
				]);

				$employee->code = "EMP/".str_pad($employee->id,6,0,STR_PAD_LEFT)."";
				$employee->save();

				$employee->appendToNode($supervisor)->save();
			}

			if($request->is_user>0)
			{
				$_tmp_pass = $request->password;

				$newuser = User::create([
		            'name' => $request->first_name.' '.$request->last_name,
		            'username' => $request->username,
		            'email' => $request->email,
		            'password' => bcrypt($request->password),
		            'employee_id' => $employee->id,
		            'image' => $employee->image
		        ]);

				IssueTokenTrait::issueToken($request, 'password');

		        Mail::send('emails.password', ['data' => ['username'=>$request->username,'password'=>$_tmp_pass]], function ($m)use($request)
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

			if(isset($request->request_id))
			{
				$tem_req = RegistrationRequest::find($request->request_id);

				if($tem_req)
				{
					$tem_req->emp_no = $employee->employee_no;
					$tem_req->status = REG_REQ_EMPLOYEE_CREATED;
					$tem_req->save();
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

			if($request->supervisor=="0"){
				$employee->first_name     = $request->first_name;
				$employee->last_name      = $request->last_name;
				$employee->email          = $request->email;
				$employee->phone          = $request->phone;
				$employee->employee_no    = $request->employee_no;
				$employee->department_id  = $request->department;
				$employee->designation_id = $request->edit_designation;
				$employee->gender         = $request->gender;
				$employee->type           = $request->type;
				$employee->is_hod         = $request->is_hod;
				$employee->save();

				$employee->makeRoot()->save();
			}else{
				$supervisor = Employee::find($request->supervisor);

				$employee->first_name     = $request->first_name;
				$employee->last_name      = $request->last_name;
				$employee->email          = $request->email;
				$employee->phone          = $request->phone;
				$employee->employee_no    = $request->employee_no;
				$employee->department_id  = $request->department;
				$employee->designation_id = $request->edit_designation;
				$employee->gender         = $request->gender;
				$employee->type           = $request->type;
				$employee->is_hod         = $request->is_hod;
				$employee->save();

				$employee->appendToNode($supervisor)->save();
			}


			if($request->is_user>0 && $request->user_id==0)
			{
				$_tmp_pass = $request->password;

				$newuser = User::create([
		            'name' => $request->first_name.' '.$request->last_name,
		            'username' => $request->username,
		            'email' => $request->email,
		            'password' => bcrypt($request->password),
		            'employee_id' => $employee->id,
		            'image' => $employee->image
		        ]);

		        Mail::send('emails.password', ['data' => ['username'=>$request->username,'password'=>$_tmp_pass]], function ($m)use($request)
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
		$response = $supervisors =  Employee::where('type','employee')->get();
		return response()->json($response);
	}

	public function getDesignations(){
		$response = $designations =  Designation::all();
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
				$_tmp_pass = $request->reset_password1;

				$updateuser->username = $request->reset_username;
				$updateuser->password = bcrypt($request->reset_password1);
				$updateuser->save();

				Mail::send('emails.password', ['data' => ['username'=>$request->reset_username,'password'=>$_tmp_pass]], function ($m)use($updateuser)
	            {
	                $m->from('admin@sisfs.com.au', 'SISFS user account password reset');
	                $m->to($updateuser->email)->subject('Your SISFS account password reset');
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

	public function updateProfilePicture(Request $request)
	{
		$_user = User::where('employee_id',$request->profile_employee_id)->first();
		$_employee = Employee::find($request->profile_employee_id);

		$savePath = storage_path('attachments/profile_pics');
	                        
        $this->common->makeDirNotExist($savePath, 0777, true);
        $fileName = '';

		if ($request->hasFile('profile_pic'))
		{
			if(isset($_employee->image) && file_exists(storage_path('attachments/profile_pics/'.$_employee->image)))
	        {
	            unlink(storage_path('attachments/profile_pics/'.$_employee->image));
	        }

            $file = $request->file('profile_pic');

            $image = $file->getClientOriginalName();
			//return json_encode($image);

			$file_ext = $file->getClientOriginalExtension();
			$name = date("YmdHis").'_'.$_employee->id.'.'.$file_ext;

            $file->move($savePath,$name);

            if($_user){
            	$_user->image = 'attachments/profile_pics'.'/'.$name;
            	$_user->save();
            }

            $_employee->image = 'attachments/profile_pics'.'/'.$name;
			
			if($_employee->save())
			{
				$response = [
					'status' => 1,
					'msg' => 'Reset'
				];
			}else{
				$response = [
					'status' => 0,
					'msg' => 'Update Faild'
				];
			}
		}else{
			$response = [
				'status' => 0,
				'msg' => 'Select file to upload'
			];
		}

		return response()->json($response);
	}

	public function generateImage($text = '12323')
	{
		$image = imagecreate(200, 100);
  
		// Set the background color of image
		$background_color = imagecolorallocate($image, 0, 153, 0);
		  
		// Set the text color of image
		$text_color = imagecolorallocate($image, 255, 255, 255);
		  
		// Function to create image which contains string.
		imagestring($image, 5, 15, 5,  $text, $text_color);
		  
		header("Content-Type: image/png");
		  
		return imagepng($image);
		// imagedestroy($image);
	}

}
