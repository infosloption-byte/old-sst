<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;
use DB;
use PDF;
use Mail;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Passport;

use Illuminate\Support\Facades\URL;

use App\Models\Company;
use App\Models\User;
use App\Models\Image;
use App\Classes\Functions;
use App\Classes\RegularFunctions;

use System\Employee\Models\Employee;
use System\Department\Models\Department;
use System\Department\BusinessLogic\DepartmentLogic;

use App\Modules\JobManage\Models\Job;
use App\Modules\JobManage\Models\Section;
use App\Modules\JobManage\Models\Task;
use App\Modules\JobManage\Models\Client;
use App\Modules\JobManage\Logics\JobLogic;
use App\Modules\JobManage\Models\JobCategory;
use App\Modules\JobManage\Models\TaskCategory;
use App\Modules\JobManage\Models\JobTransaction;
use App\Modules\JobManage\Models\RegularJobTransaction;

use App\Modules\RepairManage\Models\Repair;
use App\Modules\RepairManage\Models\RepairType;
use App\Modules\RepairManage\Models\RepairAttachment;

use App\Modules\InspectionManage\Models\InspectionJob;
use App\Modules\InspectionManage\Models\InspectionSection;
use App\Modules\InspectionManage\Models\InspectionTask;
use App\Modules\InspectionManage\Logics\InspectionLogic;

use App\Modules\JobManage\Controllers\JobController;

use App\Jobs\RegularJobStarted;
use App\Mail\RegularJobStartedMail;
use App\Mail\RegularJobFinishedMail;
use App\Mail\InspectionFinishedMail;
use App\Mail\JobStartedMail;
use App\Mail\JobFinishedMail;
use App\Mail\RepairMail;

use System\UserRoles\Models\UserRole;
use App\Http\Controllers\Api\IssueTokenTrait;

class ApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ApiController Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles REST api requests from mobile application.
    |
    */

    /**
     * Create a new controller instance. 
     *
     * @return void
     */
    public function __construct(Functions $common, RegularFunctions $rcommon)
    {
        $this->common = $common;
        $this->rcommon = $rcommon;
    }

    /**
     * get All Companies object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllCompaniesJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            $json = Company::all();

            $response['status_code'] = 200;
            $response['data']  = $json;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    /**
     * sign up user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function newUserSignup(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            DB::transaction(function () use($request,&$response)
            {
                $employee = Employee::create([
                    'company_id' => $request->company,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'employee_no' => Employee::where('type','employee')->count()+1,
                    'code' => '',
                    'department_id' => 3,
                    'designation_id' => 2,
                    'created_by' => 1,
                    'status' => 1,
                    'gender' => 'male',
                    'type' => 'employee',
                    'is_hod' => 0
                ]);

                $employee->code = "EMP/".str_pad($employee->id,6,0,STR_PAD_LEFT)."";
                $employee->save();

                $employee->makeRoot()->save();

                $_tmp_pass = $request->password;

                $newuser = User::create([
                    'name' => $request->first_name.' '.$request->last_name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'employee_id' => $employee->id,
                    'image' => ''
                ]);

                $attachrole = new UserRole();
                $attachrole->id = 2;
                $newuser->attachRole($attachrole);

                IssueTokenTrait::issueToken($request, 'password');

                Mail::send('emails.password', ['data' => ['username'=>$request->username,'password'=>$_tmp_pass]], function ($m)use($request)
                {
                    $m->from('admin@sisfs.com.au', 'SISFS user account created');
                    $m->to($request->email)->subject('Your SISFS account created');
                });

                $response['status_code'] = 200;
                $response['data']  = $employee;
                return $response;

            });
            
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    /**
     * get Job Category object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getJobCategoryJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $json = JobCategory::all();

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * get Task Category object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getTaskCategoryJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $json = TaskCategory::all();

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * get Job Sections object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getJobSectionJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $json = Section::where('job_id',$request->job_id)->get();

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * get Task Category object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getRepairTypesJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $json = RepairType::all();

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * get Client object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getClientsJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $json = Client::all();

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * get technician object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getTechniciansJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $json = Employee::where('designation_id',2)->get();

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * get Jobs object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllJobsJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $jobs =  Job::whereNull('deleted_at')->with(['category','client','tasks.category','tasks.assignTo','transactions.actionby','createdby']);

                if(isset($request->keyword) && $request->keyword!='')
                {
                    $jobs = $jobs->where('job_title','like','%'.$request->keyword.'%')->orWhere('reference_no','like','%'.$request->keyword.'%');
                }

                $jobs = $jobs->orderBy('status','ASC')->get();

                $json = [];

                foreach ($jobs as $job)
                {
                    $dd = [];

                    $dd["id"] =  $job->id;
                    $dd["reference_no"] =  $job->reference_no;
                    $dd["job_title"] =  $job->job_title;
                    $dd["description"] =  $job->description;
                    $dd["address"] =  $job->address;

                    $_users = Task::where('job_id',$job->id)->get()->pluck('assigned_to');

                    $assigned_users = Employee::whereIn('id',$_users)->get();

                    $dd["assigned_to"] =  [];

                    foreach ($assigned_users as $emp)
                    {
                        if(isset($emp->image) && $emp->image!='')
                        {
                            array_push($dd['assigned_to'], URL::to('storage').'/'.$emp->image);
                        }else{
                            $name = array_map(function($v) { return $v[0]; }, explode(' ', $emp->first_name.' '.$emp->last_name));

                            if(isset($name[1])){
                                $name = strtoupper($name[0].$name[1]);
                            }else{
                                $name = strtoupper($emp->first_name[0].substr($emp->first_name, -1));
                            }

                            array_push($dd['assigned_to'],$name);
                        }
                    }
                    
                    if($job->status==0){
                        $dd["status"] =  "PENDING";
                    }else if($job->status==1){
                        $dd["status"] =  "IN-PROGRESS";
                    }else if($job->status==2){
                        $dd["status"] =  "COMPLETED";
                    }

                    $dd["category"] =  $job['category']->name;
                    $dd["start_date"] =  $job->start_date;
                    $dd["end_date"] =  $job->end_date;

                    array_push($json,$dd);
                }

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * get Job detail object
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getJobDetailsJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $json = [];

                $job = Job::where('id',$request->job_id)->with(['category','client','tasks.category','tasks.assignTo','transactions.actionby','createdby'])->first();

                $json['id'] = $job->id;
                $json['job_no'] = $job->reference_no;
                $json['category'] = $job['category']->name;
                $json['job_title'] = $job->job_title;
                $json['description'] = $job->description;

                $json['start_date'] = $job->start_date;
                $json['end_date'] = $job->end_date;

                $json['address'] = $job->address;
                $json['city'] = $job->city;
                $json['state'] = $job->state;
                $json['postalcode'] = $job->postalcode;

                $json['lat'] = $job->lat;
                $json['lng'] = $job->lng;

                $json['client_name'] = $job['client']->first_name.' '.$job['client']->first_name;
                $json['client_address'] = $job['client']->address;
                $json['client_email'] = $job['client']->email;
                $json['client_phone'] = $job['client']->phone;

                if($job->status==0){
                    $json["status"] =  "PENDING";
                    $json["status_id"] =  0;
                }else if($job->status==1){
                    $json["status"] =  "IN-PROGRESS";
                    $json["status_id"] =  1;
                }else if($job->status==2){
                    $json["status"] =  "COMPLETED";
                    $json["status_id"] =  2;
                }

                $_users = Task::where('job_id',$request->job_id)->get()->pluck('assigned_to');

                $assigned_users = Employee::whereIn('id',$_users)->get();

                $total_tasks = Task::where('job_id',$request->job_id)->count();

                $completed_tasks = Task::where('job_id',$request->job_id)->where('status',2)->count();

                $remaining_tasks = $total_tasks - $completed_tasks;

                // $job['job_summery']['total_tasks'] = $total_tasks;
                // $job['job_summery']['remaining_task'] = $remaining_task;

                $json['total_tasks'] = $total_tasks;
                $json['remaining_tasks'] = $remaining_tasks;

                $tech_emps = [];

                foreach ($assigned_users as $technician)
                {
                    if(isset($technician->image) && $technician->image!='')
                    {
                        $tech_emps[] = URL::to('storage').'/'.$technician->image;
                    }else{
                        $name = array_map(function($v) { return $v[0]; }, explode(' ', $technician->first_name.' '.$technician->last_name));

                        if(isset($name[1])){
                            $name = strtoupper($name[0].$name[1]);
                        }else{
                            $name = strtoupper($technician->first_name[0].substr($technician->first_name, -1));
                        }

                        $tech_emps[] = $name;
                    }   
                }

                $json['task_users'] = $tech_emps;

                $startDate = strtotime($job->start_date);
                $endDate = strtotime($job->end_date);
                $currentDate = strtotime(now());

                $totalDays = (($endDate - $startDate) / 60 / 60 / 24)+1;

                $spendDays = (($currentDate - $startDate) / 60 / 60 / 24)+1;
                
                $remainingHours = (($totalDays - $spendDays)*8);

                $json['total_hours'] = $totalDays*8;
                $json['remaining_hours'] = $remainingHours;

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            $response['data'] = [];
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * get Task object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllTasksJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $json = [];

                $tasks = Task::whereNull('deleted_at')->where('assigned_to',auth()->user()->employee_id)->with(['category','job','transactions.actionby','assignTo','createdby']);

                if(isset($request->status))
                {
                    $tasks = $tasks->where('status',$request->status);
                }

                $tasks = $tasks->orderBy('status','asc')->get();

                foreach ($tasks as $task)
                {

                    $dd = [];

                    $dd['id'] = $task->id;
                    $dd['job_no'] = $task['job']->reference_no;
                    $dd['task_no'] = $task->reference_no;
                    $dd['title'] = $task->title;
                    $dd['task_category'] = $task['category']->name;

                    if($task->status==0){
                        $dd["status"] =  "PENDING";
                        $dd["status_id"] =  0;
                    }else if($task->status==1){
                        $dd["status"] =  "IN-PROGRESS";
                        $dd["status_id"] =  1;
                    }else if($task->status==2){
                        $dd["status"] =  "COMPLETED";
                        $dd["status_id"] =  2;
                    }

                    $dd['description'] = $task->remark;
                    $dd['assigned_user_name'] = $task['assignTo']->first_name.' '.$task['assignTo']->last_name;

                    if(isset($task['assignTo']->image) && $task['assignTo']->image!='')
                    {
                        $dd['assigned_user_image'] = URL::to('storage').'/'.$task['assignTo']->image;
                    }else{
                        $name = array_map(function($v) { return $v[0]; }, explode(' ', $task['assignTo']->first_name.' '.$task['assignTo']->last_name));

                        if(isset($name[1])){
                            $name = strtoupper($name[0].$name[1]);
                        }else{
                            $name = strtoupper($task['assignTo']->first_name[0].substr($task['assignTo']->first_name, -1));
                        }

                        $dd['assigned_user_image'] = $name;
                    }

                    array_push($json, $dd);

                }


                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * get Task detail object
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getTaskDetailsJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $json = Task::where('id',$request->task_id)->where('assigned_to',auth()->user()->employee_id)->with(['category','job','transactions.actionby','assignTo','createdby'])->first();

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * create new task
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createNewTask(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            DB::transaction(function () use($request,&$response)
            {
                if(auth()->user())
                {
                    $job = Job::find($request->job_id);

                    if($job)
                    {
                        $task = Task::create([
                            'job_id'            => $job->id,
                            'section_id'        => $request->section_id,
                            'task_category_id'  => $request->task_category_id,
                            'assigned_to'       => auth()->user()->employee_id,
                            'title'             => $request->task_title,
                            'remark'            => $request->task_note,
                            'start_at'          => $request->start_at,
                            'start_time'        => $request->start_time,
                            'end_at'            => $request->end_at,
                            'end_time'          => $request->end_time,
                            'status'            => 0,
                            'created_by'        => auth()->user()->id
                        ]);

                        if($task)
                        {
                            $task->reference_no = "TK".str_pad($task->id,5,0,STR_PAD_LEFT)."";
                            $task->save();

                            $trans = JobTransaction::create([
                                'job_id' => $job->id,
                                'task_id' => $task->id,
                                'action' => 'Task Created',
                                'remark' => 'New task created for '.$job->reference_no,
                                'status' => 'Pending',
                                'action_by' => auth()->user()->id
                            ]);

                            $response['status_code'] = 200;
                            $response['message'] = 'Success';
                            $response['debug'] = 'Task created';
                        }else{
                            $response['status_code'] = 500;
                            $response['message'] = 'Faild';
                            $response['debug'] = 'Task faild';
                        }
                    }else{
                        $response['status_code'] = 500;
                        $response['message'] = 'Faild';
                        $response['debug'] = 'Job not found';
                    }
                }else{
                    $response['message'] = "User not found";
                    $response['status_code'] = 404;
                }

            });
            
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * Create new repair request
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createNewRepair(Request $request)
    {

        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            DB::transaction(function () use($request,&$response)
            {
                if(auth()->user())
                {
                    $repair = Repair::create([
                        'repair_type_id'    => $request->repair_type,
                        'asset'         => $request->asset,
                        'location'      => $request->location,
                        'remark'        => $request->remark,
                        'lng'               => $request->lng,
                        'lat'               => $request->lat,
                        'created_by'        => auth()->user()->id
                    ]);

                    if($repair)
                    {
                        $repair->reference_no = "RP".str_pad($repair->id,6,0,STR_PAD_LEFT)."";
                        $repair->save();

                        if(isset($request->repair_images))
                        {
                            foreach ($request->repair_images as $key=>$value)
                            {
                                $filePath = 'uploads/repairs';
                                
                                $this->common->makeDirNotExist($filePath, 0777, true);
                                $fileName = '';

                                $extn = $value->getClientOriginalExtension(); //get extension

                                $_img = RepairAttachment::create([
                                    'repair_id' => $repair->id
                                ]);

                                $fileName = $repair->reference_no.'_'.$_img->id.'_'.$key.'.'.$extn; //set file name

                                $destinationPath = storage_path($filePath); // destination
                                $value->move($destinationPath, $fileName);//move to file

                                $_rimg = storage_path().'/uploads/repairs/'.$fileName;
                                $parts = pathinfo($_rimg);
                                $degrees = 270;
                                $source = imagecreatefromjpeg($_rimg);
                                $rotate = imagerotate($source, $degrees, 0);
                                imagejpeg($rotate, $_rimg);

                                $_img->file_name = $fileName;
                                $_img->image_url = "uploads/repairs/".$fileName;
                                $_img->save();
                            }
                        }

                        $_tmp_repair = Repair::where('id',$repair->id)->with(['createdby.employee','repairType','attachments'])->first();

                        $email_data = [];

                        $email_data['reference_no'] = $_tmp_repair->reference_no;
                        $email_data['repair_type']  = $_tmp_repair['repairType']->name;
                        $email_data['location'] = $_tmp_repair->location;
                        $email_data['lat']  = $_tmp_repair->lat;
                        $email_data['lng']  = $_tmp_repair->lng;
                        $email_data['remark']   = $_tmp_repair->remark;
                        $email_data['created_by']   = $_tmp_repair['createdby']['employee']->first_name.' '.$_tmp_repair['createdby']['employee']->last_name;
                        $email_data['created_at']   = $_tmp_repair->created_at;

                        $email_data['files'] = [];

                        foreach($_tmp_repair['attachments'] as $_rfile)
                        {
                            $email_data['files'][] = URL::to('storage').'/'.$_rfile->image_url;
                        }

                        Mail::to('inquiry@sisfs.com.au')
                            ->bcc(['gayan@sisfs.com.au','csriyarathne@gmail.com'])
                            ->queue(new RepairMail($email_data));

                        // Mail::send('emails.repair_notify_admin', ['data' => $email_data], function ($m)
                        // {
                        //     $m->from('admin@sisfs.com.au', 'Asset Maintenance');
                        //     $m->to(['inquiry@sisfs.com.au','gayan@sisfs.com.au','csriyarathne@gmail.com'])->subject("New Asset Maintenance Request");
                        // });

                        $response['status_code'] = 200;
                        $response['message'] = 'Success';
                        $response['debug'] = 'Repair created';
                    }else{
                        $response['status_code'] = 500;
                        $response['message'] = 'Faild';
                        $response['debug'] = 'Repair faild';
                    }
                }else{
                    $response['message'] = "User not found";
                    $response['status_code'] = 404;
                }

            });
            
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = [$e->getMessage(),$e->getLine()];

            return response()->json($response);
        }
    }
    
    /**
     * start task
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function startTask(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            DB::transaction(function () use($request,&$response)
            {
                if(auth()->user())
                {
                    $task = Task::find($request->task_id);

                    if($task)
                    {
                        $task->task_start_at = date('Y-m-d H:i:s');

                        $task->start_lat = $request->lat;
                        $task->start_lng = $request->lng;
                        $task->status = 1;
                        
                        if($task->save())
                        {
                            $is_section_exist = Section::where('id',$task->section_id)->where('status',0)->first();

                            if($is_section_exist)
                            {
                                $is_section_exist->status = 1;   
                                $is_section_exist->started_at = date('Y-m-d H:i:s');   
                                $is_section_exist->save();
                            }

                            if(isset($request->task_image))
                            {
                                $filePath = 'uploads/tasks';
                                
                                $this->common->makeDirNotExist($filePath, 0777, true);
                                $fileName = '';

                                $task_file = $request->task_image;

                                $extn = $task_file->getClientOriginalExtension(); //get extension

                                $fileName = 'Task-'.$task->id.'.'.$extn; //set file name

                                $destinationPath = storage_path($filePath); // destination
                                $task_file->move($destinationPath, $fileName);//move to file

                                $_img = storage_path().'/uploads/tasks/'.$fileName;
                                $parts = pathinfo($_img);
                                $degrees = 270;
                                $source = imagecreatefromjpeg($_img);
                                $rotate = imagerotate($source, $degrees, 0);
                                imagejpeg($rotate, $_img);

                                $task->image = "uploads/tasks/".$fileName;
                                $task->save();
                            }

                            $status = 'In-Progress';

                            $trans = JobTransaction::create([
                                'job_id' => $task->job_id,
                                'task_id' => $task->id,
                                'action' => 'Task Started',
                                'remark' => $task->reference_no.' Task now in-progress ',
                                'status' => $status,
                                'action_by' => auth()->user()->id
                            ]);

                            $_is_job_start = Task::where('job_id',$task->job_id)->where('status',1)->count();

                            if($_is_job_start==1)
                            {
                                $_job_exist = Job::where('id',$task->job_id)->with(['client'])->first();

                                $_job_exist->status = 1;
                                $_job_exist->save();

                                $_job_trans = JobTransaction::create([
                                    'job_id' => $_job_exist->id,
                                    'task_id' => null,
                                    'action' => 'Job In-Progress',
                                    'remark' => $_job_exist->reference_no.' Job In-Progress',
                                    'status' => 'Job In-Progress',
                                    'action_by' => auth()->user()->id
                                ]);

                                $summery['started_at'] = $task->task_start_at;
                                $summery['start_lat'] = $request->lat;
                                $summery['start_lng'] = $request->lng;

                                $employee = Employee::find(auth()->user()->employee_id);

                                Mail::to([$_job_exist->client->email,'inquiry@sisfs.com.au'])
                                    ->bcc(['gayan@sisfs.com.au','csriyarathne@gmail.com'])
                                    ->queue(new JobStartedMail($_job_exist,$summery,$employee));
                            }

                            $response['status_code'] = 200;
                            $response['message'] = 'Success';
                            $response['debug'] = 'Task Started';
                        }else{
                            $response['status_code'] = 500;
                            $response['message'] = 'Faild';
                            $response['debug'] = 'Task fail to start';
                        }
                    }
                }else{
                    $response['message'] = "User not found";
                    $response['status_code'] = 404;
                }

            });
            
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }
    
    /**
     * end task
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function endTask(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            DB::transaction(function () use($request,&$response)
            {
                if(auth()->user())
                {
                    $task = Task::find($request->task_id);

                    if($task)
                    {
                        $task->task_end_at = date('Y-m-d H:i:s');

                        $task->end_lat = $request->lat;
                        $task->end_lng = $request->lng;
                        $task->status = 2;
                        
                        if($task->save())
                        {
                            $status = 'Finished';

                            $trans = JobTransaction::create([
                                'job_id' => $task->job_id,
                                'task_id' => $task->id,
                                'action' => 'Task Finished',
                                'remark' => $task->reference_no.' Task completed',
                                'status' => $status,
                                'action_by' => auth()->user()->id
                            ]);

                            $_is_tasks_pending = Task::where('job_id',$task->job_id)->whereIn('status',[0,1])->count();

                            $_is_sections_tasks_pending = Task::where('section_id',$task->section_id)->whereIn('status',[0,1])->count();

                            if($_is_sections_tasks_pending == 0)
                            {
                                $task_section = Section::find($task->section_id);
                                $task_section->status = 2;
                                $task_section->end_at = date('Y-m-d H:i:s');
                                $task_section->save();
                            }

                            if($_is_tasks_pending == 0)
                            {
                                $job = Job::where('id',$task->job_id)->with(['client'])->first();

                                $job_summery = JobController::getJobSummeryDetails($job->id);

                                if($job)
                                {
                                    $job->status = 2;

                                    if($job->save())
                                    {
                                        $trans = JobTransaction::create([
                                            'job_id' => $job->id,
                                            'task_id' => null,
                                            'action' => 'Job Finished',
                                            'remark' => $job->reference_no.' Job Finished',
                                            'status' => 'Job Finished',
                                            'action_by' => auth()->user()->id
                                        ]);

                                        Mail::to([$job->client->email,'inquiry@sisfs.com.au'])
                                        ->bcc(['gayan@sisfs.com.au','csriyarathne@gmail.com'])
                                        ->queue(new JobFinishedMail($job,$job_summery));

                                        // Mail::send('emails.job_finished_customer', ['data' => $job,'summery'=>$job_summery], function ($m)use($job)
                                        // {
                                        //     $m->from('admin@sisfs.com.au', $job->reference_no.' Job Finished');
                                        //     $m->cc(['csriyarathne@gmail.com']);
                                        //     $m->to($job->client->email)->subject("SISFS Job Completed - ".$job->reference_no);
                                        // });

                                        // Mail::send('emails.job_finished_admin', ['data' => $job,'summery'=>$job_summery], function ($m)use($job)
                                        // {
                                        //     $m->from('admin@sisfs.com.au', 'Job Done');
                                        //     $m->to(['inquiry@sisfs.com.au','gayan@sisfs.com.au','csriyarathne@gmail.com'])->subject("Job Finished - ".$job->reference_no);
                                        // });
                                    }
                                }
                            }

                            $response['status_code'] = 200;
                            $response['message'] = 'Success';
                            $response['debug'] = 'Task Finished';
                        }else{
                            $response['status_code'] = 500;
                            $response['message'] = 'Faild';
                            $response['debug'] = 'Task fail to complete';
                        }
                    }
                }else{
                    $response['message'] = "User not found";
                    $response['status_code'] = 404;
                }

            });
            
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage().' - line '.$e->getLine().' - trace ---'.$e->getTraceAsString();

            return response()->json($response);
        }
    }
    
    /**
     * get Repair list json
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getRepairListJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $json = [];

                $repairs = Repair::whereNull('deleted_at')->where('created_by',auth()->user()->id)->with(['repairType','attachments','createdby.employee'])->get();

                foreach ($repairs as $repair)
                {

                    $dd = [];

                    $dd['id'] = $repair->id;
                    $dd['category'] = $repair['repairType']->name;
                    $dd['reference_no'] = $repair->reference_no;
                    $dd['asset'] = $repair->asset;
                    $dd['location'] = $repair->location;
                    $dd['lat'] = $repair->lat;
                    $dd['lng'] = $repair->lng;
                    $dd['remark'] = $repair->remark;
                    $dd['created_date'] = date('dd MM yyyy H:i:s',strtotime($repair->created_at));

                    if($repair->status==0){
                        $dd["status"] =  "PENDING";
                        $dd["status_id"] =  0;
                    }else if($repair->status==1){
                        $dd["status"] =  "IN-PROGRESS";
                        $dd["status_id"] =  1;
                    }else if($repair->status==2){
                        $dd["status"] =  "COMPLETED";
                        $dd["status_id"] =  2;
                    }

                    $dd['reported_user_name'] = $repair['createdby']['employee']->first_name.' '.$repair['createdby']['employee']->last_name;

                    if(isset($repair['createdby']['employee']->image) && $repair['createdby']['employee']->image!='')
                    {
                        $dd['assigned_user_image'] = URL::to('storage').'/'.$repair['createdby']['employee']->image;
                    }else{
                        $name = array_map(function($v) { return $v[0]; }, explode(' ', $repair['createdby']['employee']->first_name.' '.$repair['createdby']['employee']->last_name));

                        if(isset($name[1])){
                            $name = strtoupper($name[0].$name[1]);
                        }else{
                            $name = strtoupper($repair['createdby']['employee']->first_name[0].substr($repair['createdby']['employee']->first_name, -1));
                        }

                        $dd['reported_user_image'] = $name;

                        $dd['attachments'] = [];

                        foreach ($repair['attachments'] as $attachment)
                        {
                            $dd['attachments'][] = URL::to('storage').'/'.$attachment->image_url;       
                        }
                    }

                    array_push($json, $dd);

                }


                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    /**
     * get Inspection Jobs object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getInspectionJobsJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $inspectionJobs =  InspectionJob::whereNull('deleted_at')->with(['manager','job.category','job.client','tasks','pendingTasks','completedTasks','createdby'])->where('manager_id',auth()->user()->employee_id);

                $inspectionJobs = $inspectionJobs->orderBy('inspection_date','ASC')->get();

                $json = [];

                foreach ($inspectionJobs as $inspectJob)
                {
                    $dd = [];

                    $dd["id"] =  $inspectJob->id;
                    $dd["inspect_reference_no"] =  $inspectJob->reference_no;
                    $dd["manager"] =  $inspectJob['manager']->first_name.' '.$inspectJob['manager']->last_name;

                    $dd['manager_image'] = URL::to('storage').'/'.$inspectJob['manager']->image;

                    $dd["inspect_date"] =  $inspectJob->inspection_date;

                    $dd['tasks'] = count($inspectJob['tasks']);
                    $dd['pending_tasks'] = count($inspectJob['pendingTasks']);
                    $dd['inprogress_tasks'] = 0;
                    $dd['completed_tasks'] = count($inspectJob['completedTasks']);
                    
                    $dd["job_reference_no"] =  $inspectJob['job']->reference_no;
                    $dd["job_title"] =  $inspectJob['job']->job_title;
                    $dd['client_name'] = $inspectJob['job']['client']->first_name.' '.$inspectJob['job']['client']->last_name;
                    $dd['client_contact'] = $inspectJob['job']['client']->phone;
                    $dd["address"] =  $inspectJob['job']->address;
                    $dd["lat"] =  $inspectJob['job']->lat;
                    $dd["lng"] =  $inspectJob['job']->lng;

                    if(!$inspectJob->report_pdf)
                    {
                        $dd["report_pdf"] =  URL::to('storage').self::generateReportPdf($inspectJob->id);
                    }else{
                        $dd["report_pdf"] =  URL::to('storage').$inspectJob->report_pdf;
                    }

                    
                    if($inspectJob->status==0){
                        $dd["status"] =  "PENDING";
                    }else if($inspectJob->status==1){
                        $dd["status"] =  "IN-PROGRESS";
                    }else if($inspectJob->status==2){
                        $dd["status"] =  "COMPLETED";
                    }

                    $dd["category"] =  $inspectJob['job']['category']->name;

                    array_push($json,$dd);
                }

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    /**
     * get Inspection Section object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getInspectionJobSectionsJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $inspectionSections =  InspectionSection::whereNull('deleted_at')->where('inspection_job_id',$request->job_id)->with(['inspectJob','jobSection','tasks','pendingTasks','completedTasks','createdby']);

                $inspectionSections = $inspectionSections->orderBy('created_at','ASC')->get();

                $json = [];

                foreach ($inspectionSections as $inspectSection)
                {
                    $dd = [];

                    $dd["id"] =  $inspectSection->id;
                    $dd["name"] =  $inspectSection['jobSection']->name;
                    $dd["total_points"] =  $inspectSection->total_score;
                    $dd["scored_points"] =  $inspectSection->scored_points;
                    $dd["rate"] =  $inspectSection->percentage;

                    $dd['tasks'] = count($inspectSection['tasks']);
                    $dd['pending_tasks'] = count($inspectSection['pendingTasks']);
                    $dd['inprogress_tasks'] = 0;
                    $dd['completed_tasks'] = count($inspectSection['completedTasks']);

                    array_push($json,$dd);
                }

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    /**
     * get Inspection Section Task object list
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getInspectionJobSectionTasksJson(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            if(auth()->user())
            {
                $inspectionTasks =  InspectionTask::whereNull('deleted_at')->with(['createdby','task']);

                if(isset($request->section_id))
                {
                    $inspectionTasks = $inspectionTasks->where('inspect_section_id',$request->section_id);
                }

                $inspectionTasks = $inspectionTasks->orderBy('created_at','ASC')->get();

                $json = [];

                foreach ($inspectionTasks as $inspectTask)
                {
                    $dd = [];

                    $dd["id"] =  $inspectTask->id;
                    $dd["title"] =  $inspectTask['task']->title;
                    $dd["total_points"] =  10;
                    $dd["scored_points"] =  $inspectTask->scored_points;

                    array_push($json,$dd);
                }

                $response['status_code'] = 200;
                $response['data']  = $json;
                return $response;
            }

            $response['message'] = "User not found";
            $response['status_code'] = 404;
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    /**
     * Save Inspection Task rating
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function rateInspectTask(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            DB::transaction(function () use($request,&$response)
            {
                if(auth()->user())
                {
                    $task = InspectionTask::find($request->task_id);

                    if($task)
                    {
                        $task->scored_points = $request->scored_points;
                        $task->note = $request->note;
                        $task->status = 1;
                        
                        if($task->save())
                        {
                            if(isset($request->inspect_image))
                            {
                                $filePath = 'uploads/inspection';
                                    
                                $this->common->makeDirNotExist($filePath, 0777, true);
                                $fileName = '';

                                $_image = $request->inspect_image;

                                $extn = $_image->getClientOriginalExtension(); //get extension

                                $fileName = 'Task-Inspect-'.$task->id.'.'.$extn; //set file name

                                $destinationPath = storage_path($filePath); // destination
                                $_image->move($destinationPath, $fileName);//move to file

                                $_img = storage_path().'/uploads/inspection/'.$fileName;
                                $parts = pathinfo($_img);
                                $degrees = 270;
                                $source = imagecreatefromjpeg($_img);
                                $rotate = imagerotate($source, $degrees, 0);
                                imagejpeg($rotate, $_img);

                                $task->image = "uploads/inspection/".$fileName;
                                $task->save();
                            }

                            $this->updateInspectionPoints($task->inspect_section_id);


                            $is_task_exist = InspectionTask::whereNull('scored_points')->where('inspect_job_id',$task->inspect_job_id)->count();

                            $inspect_job = InspectionJob::where('id',$task->inspect_job_id)->with(['job.client','manager','sections.jobSection','sections.tasks.task','createdby'])->first();

                            if($is_task_exist == 0)
                            {
                                $inspect_job->status = 2;
                                
                                if($inspect_job->save())
                                {
                                    $labels = [];
                                    $series = [];

                                    foreach($inspect_job['sections'] as $section)
                                    {
                                        array_push($labels,$section['jobSection']->name);
                                        array_push($series,$section->scored_points?$section->scored_points:0);
                                    }

                                    $_tmp = [
                                      'type'=> 'bar',
                                      'data'=> [
                                            'labels'=> $labels,
                                            'datasets' => [[
                                                'label'=> 'Section Scored Points',
                                                'data'=> $series,
                                            ]]
                                        ]
                                    ];
                                    $_tmp = "https://quickchart.io/chart?c=".urlencode(json_encode($_tmp));

                                    $page1 =  view('InspectionManage::test')->with(['data'=>$inspect_job,'inspection_id' => $inspect_job->id,'encoded_url'=>$_tmp])->render();

                                    $pdffilename="Inspection Report ".$inspect_job->id.".pdf";

                                    // $pdf = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Inspection Report']);
                                    // PDF::SetMargins(5, 30, 5);
                                    PDF::SetTitle("Report - Inspection Report");
                                    PDF::SetFont('helvetica', 5);
                                    PDF::SetAutoPageBreak(TRUE, 30);
                                    PDF::AddPage('P', 'A4');
                                    PDF::writeHtml($page1);

                                    $pdffilePath = 'uploads/inspection_report';
                                    
                                    $this->common->makeDirNotExist($pdffilePath, 0777, true);

                                    $_file = storage_path('/uploads/inspection_report/'.$pdffilename);

                                    $inspect_job->report_pdf = '/uploads/inspection_report/'.$pdffilename;
                                    $inspect_job->save();

                                    PDF::output($_file,'F');

                                    $_job = Job::where('id',$inspect_job->job_id)->with(['client'])->first();
                                    // Log::info(json_encode($inspect_job->job_id));
                                    $job_summery = JobController::getJobSummeryDetails($inspect_job->job_id);

                                    Mail::to([$inspect_job->job->client->email,'inquiry@sisfs.com.au'])
                                        ->bcc(['gayan@sisfs.com.au','csriyarathne@gmail.com'])
                                        ->queue(new InspectionFinishedMail($inspect_job,$job_summery));

                                    // Mail::send('emails.inspection_finished_customer', ['data' => $inspect_job,'summery' => $job_summery], function ($m)use($inspect_job,$_file)
                                    // {
                                    //     $m->from('admin@sisfs.com.au', $inspect_job->reference_no.' Inspection Finished');
                                    //     $m->cc(['csriyarathne@gmail.com']);
                                    //     $m->to($inspect_job->job->client->email);
                                    //     $m->subject("SISFS Inspection Complete - ".$inspect_job->reference_no);
                                    //     $m->attach($_file, [
                                    //         'as' => 'report.pdf',
                                    //         'mime' => 'application/pdf',
                                    //     ]);
                                    // });

                                    // Mail::send('emails.inspection_finished_admin', ['data' => $inspect_job,'summery' => $job_summery], function ($m)use($inspect_job,$_file)
                                    // {
                                    //     $m->from('admin@sisfs.com.au', 'Inspection Done');
                                    //     $m->to(['inquiry@sisfs.com.au','gayan@sisfs.com.au','csriyarathne@gmail.com']);
                                    //     $m->subject("Inspection Finished - ".$inspect_job->reference_no);
                                    //     $m->attach($_file, [
                                    //         'as' => 'report.pdf',
                                    //         'mime' => 'application/pdf',
                                    //     ]);
                                    // });
                                }
                            }else{
                                $inspect_job->status = 1;
                                $inspect_job->save();
                            }

                            $response['status_code'] = 200;
                            $response['message'] = 'Success';
                            $response['debug'] = 'Task Rated';
                        }else{
                            $response['status_code'] = 500;
                            $response['message'] = 'Faild';
                            $response['debug'] = 'Task fail to rate';
                        }
                    }else{
                        $response['status_code'] = 500;
                        $response['message'] = 'Faild';
                        $response['debug'] = 'Inspection Task not found';
                    }
                }else{
                    $response['message'] = "User not found";
                    $response['status_code'] = 404;
                }

            });
            
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();
            $response['code'] = $e->getCode();
            $response['file'] = $e->getFile();
            $response['line'] = $e->getLine();

            return response()->json($response);
        }
    }

    public function updateInspectionPoints($section_id)
    {
        $scored_points_sum = InspectionTask::where('inspect_section_id',$section_id)->get()->sum('scored_points');

        $section = InspectionSection::find($section_id);

        if($section)
        {
            $section->scored_points = $scored_points_sum;
            $section->percentage = ($scored_points_sum/$section->total_score)*100;
            $section->save();

            $section_scored_points_sum = InspectionSection::where('inspection_job_id',$section->inspection_job_id)->get()->sum('scored_points');

            $_job = InspectionJob::find($section->inspection_job_id);

            if($_job)
            {
                $_job->scored_points = $section_scored_points_sum;
                $_job->percentage = ($section_scored_points_sum/$_job->total_points)*100;
                $_job->save();

                if ($_job->percentage>=0 && $_job->percentage<40) {    
                    $_job->rating = "Incomplete";
                }    
                else if ($_job->percentage>=40 && $_job->percentage<70) {    
                    $_job->rating = "Unsatisfactory";
                }    
                else if ($_job->percentage>=70 && $_job->percentage<85) {    
                   $_job->rating = "Below Average";
                }    
                else if ($_job->percentage>=85 && $_job->percentage<90) {    
                    $_job->rating = "Good";
                }    
                else if ($_job->percentage>=90 && $_job->percentage<95) {    
                    $_job->rating = "Very Good";
                }  
                else if ($_job->percentage>=95 && $_job->percentage<100) {    
                    $_job->rating = "Excellent";
                }  

                $_job->save();

            }
        }

    }

    public function generatePDF($id)
    {
        $inspection = InspectionJob::where('id',$id)->with(['job.client','manager','manager','sections.jobSection','sections.tasks.task','createdby'])->first();

        $labels = [];
        $series = [];

        foreach($inspection['sections'] as $section)
        {
            array_push($labels,$section['jobSection']->name);
            array_push($series,$section->scored_points?$section->scored_points:0);
        }

        $_tmp = [
          'type'=> 'bar',
          'data'=> [
                'labels'=> $labels,
                'datasets' => [[
                    'label'=> 'Section Scored Points',
                    'data'=> $series,
                ]]
            ]
        ];

        $_tmp = "https://quickchart.io/chart?c=".urlencode(json_encode($_tmp));

        return view('InspectionManage::test')->with(['data'=>$inspection,'inspection_id' => $inspection->id,'encoded_url'=>$_tmp])->render();
    }

    public function getRegularJobStatus(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            DB::transaction(function () use($request,&$response)
            {
                if(auth()->user())
                {
                    $job = Job::where('reference_no',$request->reference_no)->with(['client'])->first();

                    if($job)
                    {
                        if($job->status==0 || $job->status==2)
                        {
                            $response['data'] = 0;
                        }else{
                            $response['data'] = 1;
                        }

                        $response['status_code'] = 200;
                        $response['message'] = 'Success';

                         
                    }else{
                        $response['status_code'] = 500;
                        $response['message'] = 'Faild';
                        $response['debug'] = 'Job not found';
                    }
                }else{
                    $response['message'] = "User not found";
                    $response['status_code'] = 404;
                }

            });
            
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    /**
     * start Regular Job
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeRegularJobStatus(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            DB::transaction(function () use($request,&$response)
            {
                if(auth()->user())
                {
                    $job = Job::where('reference_no',$request->reference_no)->with(['client'])->first();

                    if($job)
                    {
                        if($request->status==0)
                        {
                            $status = 'In-Progress';
                            $action = 'Job Started';
                            $remark = $job->reference_no.' Job now in-progress /'.$request->lat.'/'.$request->lng;

                        }elseif($request->status==1)
                        {
                            $status = 'Finished';
                            $action = 'Job Finished';
                            $remark = $job->reference_no.' Job Finished /'.$request->lat.'/'.$request->lng;
                        }

                        $trans = JobTransaction::create([
                            'job_id' => $job->id,
                            'action' => $action,
                            'remark' => $remark,
                            'status' => $status,
                            'action_by' => auth()->user()->id
                        ]);

                        if($trans)
                        {
                            $employee = Employee::find(auth()->user()->employee_id);
                            Log::info(json_encode($employee));

                            if($request->status==0)
                            {
                                $job->status=1;

                                $reg_trans = RegularJobTransaction::create([
                                    'job_id' => $job->id,
                                    'started_at' => date('Y-m-d H:i:s'),
                                    'start_lat' => $request->lat,
                                    'start_lng' => $request->lng,
                                    'created_by' => auth()->user()->id,
                                ]);

                                self::regularJobTaskStatusChange($job->id,1,$request->lat,$request->lng);

                                Mail::to([$job->client->email,'inquiry@sisfs.com.au'])
                                    ->bcc(['gayan@sisfs.com.au','csriyarathne@gmail.com'])
                                    ->queue(new RegularJobStartedMail($job,$reg_trans,$employee));
                                
                                // Mail::send('emails.rjob_started_customer', ['data' => $job,'summery'=>$reg_trans,'employee'=> $employee,'user'=>auth()->user()->name], function ($m)use($job)
                                // {
                                //     $m->from('admin@sisfs.com.au', $job->reference_no.' Job Started');
                                //     $m->cc(['csriyarathne@gmail.com']);
                                //     $m->to($job->client->email)->subject("SISFS Job Started - ".$job->reference_no);
                                // });

                                // Mail::send('emails.rjob_started_admin', ['data' => $job,'summery'=>$reg_trans,'employee'=> $employee,'user'=>auth()->user()->name], function ($m)use($job)
                                // {
                                //     $m->from('admin@sisfs.com.au', 'Job Started');
                                //     $m->to(['inquiry@sisfs.com.au','gayan@sisfs.com.au','csriyarathne@gmail.com'])->subject("Job Started - ".$job->reference_no);
                                // });

                            }else{
                                $job->status=2;

                                $reg_trans = RegularJobTransaction::whereNull('ended_at')->where('job_id',$job->id)->where('created_by',auth()->user()->id)->first();

                                if($reg_trans)
                                {
                                    $reg_trans->ended_at = date('Y-m-d H:i:s');
                                    $reg_trans->end_lat = $request->lat;
                                    $reg_trans->end_lng = $request->lng;
                                    $reg_trans->save();

                                    $reg_trans->time_calc = $this->rcommon->calculateTimes($reg_trans->ended_at,$reg_trans->started_at);
                                    $reg_trans->time_calc_formated = $this->rcommon->formatTimes($this->rcommon->calculateTimes($reg_trans->ended_at,$reg_trans->started_at));
                                    $reg_trans->save();

                                    self::regularJobTaskStatusChange($job->id,2,$request->lat,$request->lng);

                                    Mail::to([$job->client->email,'inquiry@sisfs.com.au'])
                                    ->bcc(['gayan@sisfs.com.au','csriyarathne@gmail.com'])
                                    ->queue(new RegularJobFinishedMail($job,$reg_trans,$employee));

                                    // Mail::send('emails.rjob_finished_customer', ['data' => $job,'summery'=>$reg_trans,'employee'=> $employee,'user'=>auth()->user()->name], function ($m)use($job)
                                    // {
                                    //     $m->from('admin@sisfs.com.au', $job->reference_no.' Job Finished');
                                    //     $m->cc(['csriyarathne@gmail.com']);
                                    //     $m->to($job->client->email)->subject("SISFS Job Finished - ".$job->reference_no);
                                    // });

                                    // Mail::send('emails.rjob_finished_admin', ['data' => $job,'summery'=>$reg_trans,'employee'=> $employee,'user'=>auth()->user()->name], function ($m)use($job)
                                    // {
                                    //     $m->from('admin@sisfs.com.au', 'Job Finished');
                                    //     $m->to(['inquiry@sisfs.com.au','gayan@sisfs.com.au','csriyarathne@gmail.com'])->subject("Job Finished - ".$job->reference_no);
                                    // });
                                }
                            }

                            $job->save();
                        }

                        $response['status_code'] = 200;
                        $response['message'] = 'Success';
                        $response['debug'] = $action;

                         
                    }else{
                        $response['status_code'] = 500;
                        $response['message'] = 'Faild';
                        $response['debug'] = 'Job not found';
                    }
                }else{
                    $response['message'] = "User not found";
                    $response['status_code'] = 404;
                }

            });
            
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public static function regularJobTaskStatusChange($job_id,$status,$lat,$lng)
    {
        $job = Job::find($job_id);

        if($job)
        {
            $tasks = Task::where('job_id',$job->id)->get();

            foreach($tasks as $task)
            {
                $task->task_start_at = date('Y-m-d H:i:s');

                $task->assigned_to = auth()->user()->employee_id;
                $task->start_lat = $lat;
                $task->start_lng = $lng;
                $task->status = $status;
                
                if($task->save())
                {
                    $is_section_exist = Section::where('id',$task->section_id)->first();

                    if($is_section_exist)
                    {
                        $is_section_exist->status = $status;
                        $is_section_exist->started_at = date('Y-m-d H:i:s');   
                        $is_section_exist->save();
                    }

                    if($status == 1)
                    {
                        $_status = 'In-Progress';
                        $task_status = 'Task Started';
                    }else{
                        $_status = 'Finished';
                        $task_status = 'Task Finished';
                    }

                    $trans = JobTransaction::create([
                        'job_id' => $task->job_id,
                        'task_id' => $task->id,
                        'action' => $task_status,
                        'remark' => $task->reference_no.' '.$task_status.' ',
                        'status' => $_status,
                        'action_by' => auth()->user()->id
                    ]);
                }

            }

        }
    }

    /**
     * end Regular Job
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function endRegularJob(Request $request)
    {
        try {

            $response['status_code'] = 0;
            $response['message']     = "";
            $response['error']       = null;
            $response['debug']       = "";
            $response['data']        = "";

            DB::transaction(function () use($request,&$response)
            {
                if(auth()->user())
                {
                    $job = Job::where('reference_no',$request->reference_no)->with(['client'])->first();

                    if($job)
                    {
                        $status = 'Finished';

                        $trans = JobTransaction::create([
                            'job_id' => $job->id,
                            'action' => 'Job Finished',
                            'remark' => $job->reference_no.' Job Finished /'.$request->lat.'/'.$request->lng,
                            'status' => $status,
                            'action_by' => auth()->user()->id
                        ]);

                        $response['status_code'] = 200;
                        $response['message'] = 'Success';
                        $response['debug'] = 'Job Finsihed';

                         
                    }else{
                        $response['status_code'] = 500;
                        $response['message'] = 'Faild';
                        $response['debug'] = 'Job not found';
                    }
                }else{
                    $response['message'] = "User not found";
                    $response['status_code'] = 404;
                }

            });
            
            return $response;

        } catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function generateReportPdf($inspection_id)
    {
        $inspect_job = InspectionJob::where('id',$inspection_id)->with(['job.client','manager','manager','sections.jobSection','sections.tasks.task','createdby'])->first();

        $labels = [];
        
        $series = [];

        foreach($inspect_job['sections'] as $section)
        {
            array_push($labels,$section['jobSection']->name);
            array_push($series,$section->scored_points?$section->scored_points:0);
        }

        $_tmp = [
          'type'=> 'bar',
          'data'=> [
                'labels'=> $labels,
                'datasets' => [[
                    'label'=> 'Section Scored Points',
                    'data'=> $series,
                ]]
            ]
        ];
        $_tmp = "https://quickchart.io/chart?c=".urlencode(json_encode($_tmp));

        $page1 =  view('InspectionManage::test')->with(['data'=>$inspect_job,'inspection_id' => $inspect_job->id,'encoded_url'=>$_tmp])->render();

        $pdffilename="Inspection Report ".$inspect_job->id.".pdf";

        // $pdf = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Inspection Report']);
        // PDF::SetMargins(5, 30, 5);
        PDF::SetTitle("Report - Inspection Report");
        PDF::SetFont('helvetica', 5);
        PDF::SetAutoPageBreak(TRUE, 30);
        PDF::AddPage('P', 'A4');
        PDF::writeHtml($page1);

        $pdffilePath = 'uploads/inspection_report';
        
        $this->common->makeDirNotExist($pdffilePath, 0777, true);

        $_file = storage_path('uploads/inspection_report/'.$pdffilename);

        PDF::output($_file, 'F');

        $inspect_job->report_pdf = 'uploads/inspection_report/'.$pdffilename;
        $inspect_job->save();

        return $inspect_job->report_pdf;
    }

}
