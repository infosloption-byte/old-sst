<?php
namespace System\Permissions\Http\BusinessLogic;

use System\Permissions\Models\Permission;

class PermissionsLogic {

	
	public function __construct()
	{
		
	}

	public function getAll()
	{
		return Permission::all();
	}

	public function getPermsToEdit($id)
	{
		return Permission::whereNotIn('id',function($aa) use($id)
		{
			$aa->select('permission_id')->from('permission_role')->where('role_id',$id);
		})->get();
	}
	

	

}
