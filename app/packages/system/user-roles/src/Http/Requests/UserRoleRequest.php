<?php
namespace System\UserRoles\Http\Requests;

use App\Http\Requests\Request;

class UserRoleRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
			'name'        => 'required',
		];
		return $rules;
	}

}
