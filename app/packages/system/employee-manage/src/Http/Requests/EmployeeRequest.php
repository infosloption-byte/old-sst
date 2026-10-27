<?php
namespace System\Employee\Http\Requests;

use App\Http\Requests\Request;

class EmployeeRequest extends Request {

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
