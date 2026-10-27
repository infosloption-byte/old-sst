<?php
namespace System\Department\Http\Controllers;

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
use App\Exceptions\TransactionException;
use System\Employee\Models\Employee;
use App\Models\User;

use System\UserRoles\Http\BusinessLogic\UserRoleLogic;
use System\Department\Models\Department;
use System\Department\BusinessLogic\DepartmentLogic;

class DepartmentController extends Controller {

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

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(UserRoleLogic $roleLogic,DepartmentLogic $departmentLogic)
	{
		$this->middleware('auth');
		$this->roleLogic = $roleLogic;
		$this->departmentLogic = $departmentLogic;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function listView(){
		$departments  =  Department::with(['ancestors'=>function($aa){
			$aa->withDepth();
		}])->get();
		return view('Department::department.list',compact('departments'));
	}

	public function getDepartments(){
		$response = $this->departmentLogic->getAllDepartments();
		return response()->json($response);
	}

	public function getDepartment(Request $request){
		$response = $this->departmentLogic->getDepartment($request->id);
		return response()->json($response);
	}


	public function create(Request $request){

		DB::transaction(function () use($request){
			$user = \Auth::user();

			if($request->main_department=="0"){
				$department = Department::create([
					'name'         => $request->name,
					'description'  => $request->desc,
					'code'         => '',
					'status'       => 1,
					'created_by'   => $user->id
				]);

				$department->code = "DEP/".str_pad($department->id,6,0,STR_PAD_LEFT)."";
				$department->save();	

				$department->makeRoot()->save();
			}else{

				$main_department = Department::find($request->main_department);

				$department = Department::create([
					'name'         => $request->name,
					'description'  => $request->desc,
					'code'         => '',
					'status'       => 1,
					'created_by'   => $user->id
				]);

				$department->code = "DEP/".str_pad($department->id,6,0,STR_PAD_LEFT)."";
				$department->save();

				$department->appendToNode($main_department)->save();
			}	
			
			
		});
		return response()->json(['status'=>1]);
	}

	public function update(Request $request){

		DB::transaction(function () use($request){
			$user = \Auth::user();

			$department = Department::find($request->department_id);
			if($department){
				if($request->main_department=="0"){
					$department->name = $request->name;
					$department->description = $request->desc;
					$department->save();	
					$department->makeRoot()->save();
				}else{
					$main_department = Department::find($request->main_department);
					$department->name = $request->name;
					$department->description = $request->desc;
					$department->save();	

					$department->appendToNode($main_department)->save();
				}	
			}else{
				return response()->json(['status'=>0]);
			}
			
		});
		return response()->json(['status'=>1]);
	}

	public function delete(Request $request){

		try {
			$department = Department::find($request->department_id);
			if($department){
				$employee = Employee::where('department_id',$request->department_id)->get();
				if(count($employee)>0){
					$json = [
			            'success' => false,
			            'error' => [
			                'code' => 5000,
			                'message' => "Cannot delete the department, this department releated to an employee(s).Reassign releated data and delete again",
			            ],
			        ];
			        return response()->json($json);
				}
				DB::transaction(function () use($request,$department){
					$user = \Auth::user();
					$department->delete();
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
		                'message' => "Cannot find the department",
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


}
