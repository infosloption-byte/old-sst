<?php
namespace App\Modules\ClientManage\Logics;

use DB;
use Mail;
use Excel;
use Sentinel;
use Response;
use Exception;
use Carbon\Carbon;
use App\Classes\Functions;

use System\Employee\Models\Employee;

class ClientLogic {

	
	public function __construct()
	{
		
	}

	public function getAllEmployees()
	{
		return Employee::all();
	}

	
	

	

}
