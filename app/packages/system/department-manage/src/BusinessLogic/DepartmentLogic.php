<?php
namespace System\Department\BusinessLogic;

use System\Department\Models\Department;

class DepartmentLogic {

	
	public function __construct()
	{
		
	}

	public function getAllDepartments()
	{
		return Department::all();
	}

	public function getDepartment($id)
	{
		return Department::find($id);
	}
	

	

}
