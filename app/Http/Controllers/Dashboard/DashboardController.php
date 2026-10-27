<?php 

namespace App\Http\Controllers\Dashboard;

use DB;
use PDF;
use Excel;
use Image;
use Sentinel;
use Response;
use Exception;

use Carbon\Carbon;
use App\Models\User;

use App\Models\CostType;
use App\Models\CostTransaction;

use App\Classes\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;

use System\Employee\Models\Employee;

use App\Modules\JobManage\Models\Client;

use App\Modules\JobManage\Models\JobCategory;
use App\Modules\JobManage\Models\Job;
use App\Modules\JobManage\Models\JobTransaction;
use App\Modules\JobManage\Logics\JobLogic;

use App\Modules\JobManage\Models\TaskCategory;
use App\Modules\JobManage\Models\Task;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
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

    public function default()
    {   

        $data = [];

        return view('dashboard.default',compact('data'));
    }

    public function jobSumeryJson()
    {
        $user = \Auth::user();

        $total_jobs = Job::all()->count();
        $pending_jobs = Job::where('status',0)->count();
        $inprogress_jobs = Job::where('status',1)->count();
        $completed_jobs = Job::where('status',2)->count();

        $jsonData = [
            'total_jobs' => $total_jobs,
            'pending_jobs' => $pending_jobs,
            'inprogress_jobs' => $inprogress_jobs,
            'completed_jobs' => $completed_jobs
        ];

        $chartJsonData = self::jobSumeryChartJson();

        return response()->json(['json' => $jsonData, 'chart' => $chartJsonData]);
    }

    public function taskSumeryJson()
    {
        $user = \Auth::user();

        if(\Entrust::hasRole('Admin'))
        {
            $total_tasks = Task::all()->count();
            $pending_tasks = Task::where('status',0)->count();
            $inprogress_tasks = Task::where('status',1)->count();
            $completed_tasks = Task::where('status',2)->count();
        }else{
            $total_tasks = Task::where('assigned_to',$user->employee_id)->count();
            $pending_tasks = Task::where('assigned_to',$user->employee_id)->where('status',0)->count();
            $inprogress_tasks = Task::where('assigned_to',$user->employee_id)->where('status',1)->count();
            $completed_tasks = Task::where('assigned_to',$user->employee_id)->where('status',2)->count();
        }

        $jsonData = [
            'total_tasks' => $total_tasks,
            'pending_tasks' => $pending_tasks,
            'inprogress_tasks' => $inprogress_tasks,
            'completed_tasks' => $completed_tasks
        ];

        $chartJsonData = self::taskSumeryChartJson();

        return response()->json(['json' => $jsonData, 'chart' => $chartJsonData]);
    }

    public function jobSumeryChartJson()
    {
        $user = \Auth::user();

        $jsonData = [];

        for ($i = 3; $i >= 0; $i--)
        {
            $dd = [];

            $month = Carbon::now()->subMonth($i)->format('Y-m');

            $total_jobs = Job::where('created_at','like',$month.'%')->count();
            $completed_jobs = JobTransaction::where('created_at','like',$month.'%')->where('status','Job Finished')->count();

            $pending_jobs = $total_jobs-$completed_jobs;

            $dd['a'] = Carbon::now()->subMonth($i)->format('M');
            $dd['b'] = $total_jobs;
            $dd['c'] = $pending_jobs;
            $dd['d'] = $completed_jobs;

            array_push($jsonData, $dd);

        }

        return $jsonData;
    }

    public function taskSumeryChartJson()
    {
        $user = \Auth::user();

        $jsonData = [];

        for ($i = 3; $i >= 0; $i--)
        {
            $dd = [];

            $month = Carbon::now()->subMonth($i)->format('Y-m');

            if(\Entrust::hasRole('Admin'))
            {
                $total_tasks = Task::where('created_at','like',$month.'%')->count();
                $pending_tasks = Task::where('start_at','like',$month.'%')->where('status',0)->count();
                $completed_tasks = Task::where('end_at','like',$month.'%')->where('status',2)->count();
            }else{
                $total_tasks = Task::where('assigned_to',$user->employee_id)->where('created_at','like',$month.'%')->count();
                $pending_tasks = Task::where('assigned_to',$user->employee_id)->where('start_at','like',$month.'%')->where('status',0)->count();
                $completed_tasks = Task::where('assigned_to',$user->employee_id)->where('end_at','like',$month.'%')->where('status',2)->count();
            }

            $dd['a'] = Carbon::now()->subMonth($i)->format('M');
            $dd['b'] = $total_tasks;
            $dd['c'] = $pending_tasks;
            $dd['d'] = $completed_tasks;

            array_push($jsonData, $dd);

        }

        return $jsonData;
    }

    public function costSumeryChartJson()
    {
        $user = \Auth::user();

        $jsonData = [];

        $costtypes = CostType::all();

        $colors = ['rgb(255, 99, 132, 0.2)','rgb(25, 80, 32, 0.2)','rgb(54, 162, 235)','rgb(90, 62, 35)'];

        foreach($costtypes as $key=>$ctype)
        {
            $dd = [];

            $dd['type'] = 'bar';
            $dd['label'] = $ctype->name;
            $dd['data'] = [];
            $dd['backgroundColor'] = $colors[$key];

            for ($i = 3; $i >= 0; $i--)
            {
                $month = Carbon::now()->subMonth($i)->format('Y-m');

                // $dd['data'][] = Task::where('created_at','like',$month.'%')->count();
                $dd['data'][] = CostTransaction::where('effective_date','like',$month.'%')->where('cost_type_id',$ctype->id)->sum('cost_amount');

            }

            array_push($jsonData, $dd);

        }

        $labels = [];

        $current = [];
        $last_three = [];
        $last_six = [];
        $last_year = [];

        for ($i = 3; $i >= 0; $i--)
        {
            $month = Carbon::now()->subMonth($i)->format('M Y');

            array_push($labels,$month);

        }

        for ($i = 12; $i >= 0; $i--)
        {
            $month = Carbon::now()->subMonth($i)->format('Y-m');

            if($i==0){
                array_push($current,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
                array_push($last_three,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
                array_push($last_six,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }

            if($i==1){
                array_push($last_three,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
                array_push($last_six,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }

            if($i==2){
                array_push($last_three,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
                array_push($last_six,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }

            if($i==3){
                array_push($last_six,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }

            if($i==4){
                array_push($last_six,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }
            
            if($i==5){
                array_push($last_six,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }
            
            if($i==6){
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }
            
            if($i==7){
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }

            if($i==8){
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }

            if($i==9){
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }
            
            if($i==10){
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }
            
            if($i==11){
                array_push($last_year,CostTransaction::where('effective_date','like',$month.'%')->sum('cost_amount'));
            }

        }

        return [
            'jsonData'=>$jsonData,
            'labels'=>$labels,
            'others'=>[
                'current_month'=>array_sum($current),
                'last_three_month'=>array_sum($last_three),
                'last_six_month'=>array_sum($last_six),
                'last_year'=>array_sum($last_year)
            ]
        ];
    }

    public function costTypeSumeryChartJson()
    {
        $jsonData = [];

        $costtypes = CostType::all();

        $colors = [];

        foreach($costtypes as $key=>$ctype)
        {
            $dd = [];

            $dd['label'] = $ctype->name;
            $dd['value'] = CostTransaction::where('cost_type_id',$ctype->id)->sum('cost_amount');

            array_push($jsonData,$dd);
            array_push($colors,sprintf('#%06X', mt_rand(0, 0xFFFFFF)));
        }

        return ['jsonData'=>$jsonData,'colors'=>$colors];
    }

}
