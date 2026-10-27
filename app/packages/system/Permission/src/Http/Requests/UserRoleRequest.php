<?php
namespace System\Permissions\Http\Requests;

use App\Http\Requests\Request;

class PermissionsRequest extends Request {

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
