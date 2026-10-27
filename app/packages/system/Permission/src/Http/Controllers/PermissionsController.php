<?php
namespace System\Permissions\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use System\Permissions\Models\Permission;
use DB;

class PermissionsController extends Controller {

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

	
	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function listView(){
		$perms = Permission::with('createdby')->get();
		return view( 'permissions::list',compact('perms'));
	}

	public function create(Request $request){

		DB::transaction(function () use($request){
			$user = \Auth::user();

			$owner = new Permission();
			$owner->name         = $request->name;
			$owner->display_name = $request->displayName; // optional
			$owner->description  = ''; // optional
			$owner->status       = 1; // optional
			$owner->created_by   = $user->id; // optional
			$owner->save();

		});
		return response()->json(['status'=>1]);
	}


	public function getPerm(Request $request)
	{
		$response['perm'] = null;

		$perm = Permission::find($request->id);
		if($perm){
			$response['perm'] = $perm;
		}
		return response()->json($response);
	}

	public function update(Request $request){

		DB::transaction(function () use($request){
			$user = \Auth::user();

			$owner = Permission::find($request->id);
			if($owner){
				$owner->name         = $request->name;
				$owner->display_name = $request->displayName; // optional
				$owner->save();
			}

		});
		return response()->json(['status'=>1]);
	}

	public function delete(Request $request){
		DB::transaction(function () use($request){
			$user = \Auth::user();

			$perm = Permission::find($request->id);
			$perm->delete();

		});
		return response()->json(['status'=>1]);
	}

	

}
