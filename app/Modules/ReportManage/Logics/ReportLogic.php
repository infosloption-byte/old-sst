<?php
namespace App\Modules\ReportManage\Logics;

use DB;
use Mail;
use Excel;
use Sentinel;
use Response;
use Exception;
use Carbon\Carbon;
use App\Classes\Functions;

use System\Employee\Models\Employee;

class ReportLogic 
{
        
    public function __construct(Functions $common)
    {
        $this->common = $common;
    }
   
}
