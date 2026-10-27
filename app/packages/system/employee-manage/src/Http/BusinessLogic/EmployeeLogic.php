<?php
namespace System\Employee\Http\BusinessLogic;

use System\Employee\Models\Employee;

class EmployeeLogic {

	
	public function __construct()
	{
		
	}

	public function getAllEmployees()
	{
		return Employee::all();
	}

	
	

	

}
