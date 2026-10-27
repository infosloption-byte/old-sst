<?php
namespace System\UserRoles\Http\Controllers;

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
use App\Models\User;

use System\Permissions\Http\BusinessLogic\PermissionsLogic;

class UserRoleController extends Controller {

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
	protected $permlogic;

	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(PermissionsLogic $permlogic)
	{
		$this->middleware('auth');
		$this->permlogic = $permlogic;
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function listView(){
		$roles = UserRole::with('createdby')->get();
		return view( 'userRoles::role.list',compact('roles'));
	}

	public function create(Request $request){

		DB::transaction(function () use($request){
			$user = \Auth::user();

			$owner = new UserRole();
			$owner->name         = $request->roleName;
			$owner->display_name = $request->displayName; // optional
			$owner->description  = ''; // optional
			$owner->created_by   = $user->id; // optional
			$owner->save();

			$perms = [];
			foreach (json_decode($request->permission) as $key => $value) {
				$perm = new Permission();
				$perm->id           = $value->id;
				$perm->name         = $value->name;
				$perm->display_name = $value->name; 
				$perm->created_by   = $value->id; 
				$perm->status       = $value->status; 
				array_push($perms,$perm);
			}

			$owner->attachPermissions($perms);
		});
		return response()->json(['status'=>1]);
	}

	public function getAllPermissions()
	{
		$response = $this->permlogic->getAll();
		return response()->json($response);
	}

	public function getRole(Request $request)
	{
		$response['permissions'] = [];
		$response['role'] = null;

		$role = UserRole::with(['permissions'])->find($request->id);
		if($role){
			$response['role'] = $role;
			if(count($role->permissions)){
				$response['permissions'] = $this->permlogic->getPermsToEdit($role->id);
			}else{
				$response['permissions'] = $this->permlogic->getAll();
			}
		}
		return response()->json($response);
	}


	public function update(Request $request){

		DB::transaction(function () use($request){
			$user = \Auth::user();

			$owner = UserRole::find($request->role_id);
			if($owner){
				$owner->name         = $request->roleName;
				$owner->display_name = $request->displayName; // optional
				$owner->description  = ''; // optional
				$owner->created_by   = $user->id; // optional
				$owner->save();
			}

			$permDelets = UserRole::find($request->role_id)->perms()->sync([]);

			$perms = [];
			foreach (json_decode($request->permission) as $key => $value) {
				$perm = new Permission();
				$perm->id           = $value->id;
				$perm->name         = $value->name;
				$perm->display_name = $value->name; 
				$perm->created_by   = $value->id; 
				$perm->status       = $value->status; 
				array_push($perms,$perm);
			}

			$owner->attachPermissions($perms);
		});
		return response()->json(['status'=>1]);
	}

	public function delete(Request $request){

		try {
			$userRole = UserRole::find($request->id);
			if($userRole){
				$users = User::whereIn('id',function($aa) use($request)
				{
					$aa->select('user_id')->from('role_user')->where('role_id',$request->id);
				})->get();

				if(count($users)>0){
					$json = [
			            'success' => false,
			            'error' => [
			                'code' => 5000,
			                'message' => "Cannot delete the role, this role releated to user.Would you like to delete all related data",
			            ],
			        ];
			        return response()->json($json);
				}
				DB::transaction(function () use($request,$userRole){
					$user = \Auth::user();
					$userRole->delete();
				
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

	public function deleteWithRelations(Request $request){

		try {
			$userRole = UserRole::find($request->id);
			if($userRole){
				$users = User::with('roles')->whereIn('id',function($aa) use($request)
				{
					$aa->select('user_id')->from('role_user')->where('role_id',$request->id);
				})->get();


				DB::transaction(function () use($request,$users,$userRole){
					$user = \Auth::user();
					foreach ($users as $key => $usr) {
						$usr->roles()->sync([]);
					}
					$userRole->perms()->sync([]);
					UserRole::destroy($request->id);
					
				
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
                'code' => 200,
                'message' => "deleted successfully",
            ],
        ];
        return response()->json($json);

		
        return response()->json($json);

	}
}
