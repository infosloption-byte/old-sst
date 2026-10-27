<?php
namespace System\UserRoles\Http\BusinessLogic;

use System\UserRoles\Models\UserRole;

class UserRoleLogic {

	
	public function __construct()
	{
		
	}

	public function getAllRoles()
	{
		return UserRole::all();
	}

	public function getRolesToEdit($user_id)
	{
		return UserRole::whereNotIn('id',function($aa) use($user_id)
		{
			$aa->select('role_id')->from('role_user')->where('user_id',$user_id);
		})->get();
	}

	
	

	

}
