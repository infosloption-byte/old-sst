<?php

namespace App\Http\Controllers\Api;

use DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Passport;

use App\Models\User;

use App\Modules\JobManage\Models\Job;
use App\Modules\JobManage\Models\Task;
use App\Modules\JobManage\Models\Client;
use App\Modules\JobManage\Logics\JobLogic;
use App\Modules\JobManage\Models\JobCategory;
use App\Modules\JobManage\Models\TaskCategory;
use App\Modules\JobManage\Models\JobTransaction;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LoginController Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles REST api requests from mobile application.
    |
    */

    public function login(Request $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials))
        {
            $token = auth()->user()->createToken('accessToken')->accessToken;

            $response['status_code'] = 200;
            $response['user_message'] = "Login successful";
            $response['debug_message'] = "Login successful";
            $user = auth()->user();

            $response['access_token'] = $token;

            $usr_data = User::selectRaw("users.id as user_id,users.*,employee.*,department.name as department_name,
                    concat('".url('storage/')."',users.image) as image_url")
                ->leftjoin('employee','employee.id','=','users.employee_id')->leftjoin('department','department.id','=','employee.department_id')->find($user->id);

            $total_tasks = Task::where('assigned_to',$usr_data->employee_id)->count();
            $pending_tasks = Task::where('assigned_to',$usr_data->employee_id)->where('status',0)->count();
            $inprogress_tasks = Task::where('assigned_to',$usr_data->employee_id)->where('status',1)->count();
            $completed_tasks = Task::where('assigned_to',$usr_data->employee_id)->where('status',2)->count();

            $usr_data['total_tasks'] = $total_tasks;
            $usr_data['pending_tasks'] = $pending_tasks;
            $usr_data['inprogress_tasks'] = $inprogress_tasks;
            $usr_data['completed_tasks'] = $completed_tasks;

            $usr_data['rating'] = 1;

            if($usr_data['is_hod'] || $usr_data['is_hod']==0)
            {
                $usr_data['is_hod'] = false;
            }else{
                $usr_data['is_hod'] = true;
            }

            $response['user'] = $usr_data;

            return response()->json($response);
        } else {
            $response['status_code'] = 500;
            $response['user_message'] = "Username or password invalid";
            $response['debug_message'] = "Username or password invalid";

            return response()->json($response);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
    }

    public function userDetails()
    {
        $user = User::selectRaw("users.id as user_id,users.*,employee.*,department.name as department_name,
                    concat('".url('storage/')."',users.image) as image_url")
                ->leftjoin('employee','employee.id','=','users.employee_id')->leftjoin('department','department.id','=','employee.department_id')->find(auth()->user()->id);

        $total_tasks = Task::where('assigned_to',$user->employee_id)->count();
        $pending_tasks = Task::where('assigned_to',$user->employee_id)->where('status',0)->count();
        $inprogress_tasks = Task::where('assigned_to',$user->employee_id)->where('status',1)->count();
        $completed_tasks = Task::where('assigned_to',$user->employee_id)->where('status',2)->count();

        $user['total_tasks'] = $total_tasks;
        $user['pending_tasks'] = $pending_tasks;
        $user['inprogress_tasks'] = $inprogress_tasks;
        $user['completed_tasks'] = $completed_tasks;

        $user['rating'] = 1;

        return response()->json($user);
    }

}
