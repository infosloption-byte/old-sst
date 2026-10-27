<?php
namespace App\Modules\InspectionManage\Controllers;

use DB;
use PDF;
use Excel;
use Image;
use Sentinel;
use Response;
use Exception;

use Carbon\Carbon;
// use App\Classes\PdfTemplate;

use App\Models\User;

use App\Classes\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;

use System\Employee\Models\Employee;

use App\Modules\JobManage\Models\Client;

use App\Modules\JobManage\Models\Job;
use App\Modules\JobManage\Models\Section;
use App\Modules\JobManage\Models\Task;

use App\Modules\InspectionManage\Models\InspectionJob;
use App\Modules\InspectionManage\Models\InspectionSection;
use App\Modules\InspectionManage\Models\InspectionTask;
use App\Modules\InspectionManage\Logics\InspectionLogic;

class InspectionController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Inspection Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/
	/**
	 * Create a new controller instance. 
	 *
	 * @return void
	 */
	public function __construct(InspectionLogic $inspectionLogic,Functions $common)
	{
		$this->middleware('auth');
		$this->inspectionLogic = $inspectionLogic;
		$this->common = $common;
	}

	/**
	 * Show the inspection list screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		return view('InspectionManage::index',compact('request'));
	}

	/**
	 * Show the inspection detail view screen to the user.
	 *
	 * @return Response
	 */
	public function viewDetails(Request $request)
	{
		$inspect_job = InspectionJob::where('id',$request->inspection_id)->with(['job.client','manager','manager','sections.jobSection','sections.tasks.task','createdby'])->first();

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
        
        PDF::output($_file, 'F');

        $inspect_job->report_pdf = '/uploads/inspection_report/'.$pdffilename;
        $inspect_job->save();

		return view('InspectionManage::view')->with(['inspection_id'=>$request->inspection_id]);
	}

	/**
	 * Json of the inspection detail to the user.
	 *
	 * @return Response
	 */
	public function getInpectionDetails(Request $request)
	{
		$inspection = InspectionJob::where('id',$request->inspection_id)->with(['job.client','manager','manager','sections.jobSection','sections.tasks.task','createdby'])->first();

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

        $inspection['chart'] = $_tmp;

		return $inspection;
	}

	/**
	 * Pdf view of the inspection detail to the user.
	 *
	 * @return Response
	 */
	public function exportReportPdf(Request $request)
	{
		// PDF::SetTitle('Hello World');
		// PDF::AddPage();
		// PDF::Write(0, 'Hello World');
		// PDF::Output('hello_world.pdf');

		$inspection = InspectionJob::where('id',$request->inspection_id)->with(['job.client','manager','manager','sections.jobSection','sections.tasks.task','createdby'])->first();

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

		foreach($inspection['sections'] as $section)
		{
			foreach($section['tasks'] as $task)
			{
				$_img = storage_path().'/'.$task->image;
				$parts = pathinfo($_img);

				$extensions = $parts['extension'];

		        if($extensions == "jpeg" || $extensions == "jpg"){

		            $degrees = 90;

		            $source = imagecreatefromjpeg($_img);

		            $rotate = imagerotate($source, $degrees, 0);

		            imagejpeg($rotate, $_img);

		        }elseif($extensions == "png"){  
		                
		            $degrees = 90;

		            $source = imagecreatefromjpeg($_img);

		            $rotate = imagerotate($source, $degrees, 0);

		            imagepng($rotate, $_img);
		        }

			}
		}

		if($inspection)
		{
            $page1 =  view('InspectionManage::test')->with(['data'=>$inspection,'inspection_id' => $inspection->id,'encoded_url'=>$_tmp])->render();
        }else{
            return response()->view("errors.404");
        }

        $filename="Inspection Report";

        // $pdf = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Inspection Report']);
        // PDF::SetMargins(5, 30, 5);
        PDF::SetTitle("Report - Inspection Report");
        PDF::SetFont('helvetica', 5);
        PDF::SetAutoPageBreak(TRUE, 30);
        PDF::AddPage('P', 'A4');
        PDF::writeHtml($page1);
        PDF::output($filename.".pdf", 'I');

		// return $inspection;
	}

	/**
	 * Show the inspection list screen to the user.
	 *
	 * @return Response
	 */
	public function getInspectionList(Request $request)
	{
		$inspections = InspectionJob::whereNull('deleted_at')->with(['job.client','manager','createdby']);

		if($request->status && $request->status != null && $request->status != '')
		{
			$inspections = $inspections->where('status',$request->status);
		}

		if($request->manager && $request->manager != null && $request->manager != '')
		{
			$inspections = $inspections->where('assigned_manager_id',$request->manager);
		}

		if($request->client && $request->client != null && $request->client != '')
		{
			$inspections = $inspections->whereIn('job_id',function($qry)use($request)
			{
				$qry->select('id')->from('job')->where('client_id',$request->client);
			});
		}

		if($request->keyword && $request->keyword != null && $request->keyword != '')
		{
			$inspections = $inspections->where(function($aa) use($request){
				$aa->where('reference_no','LIKE','%'.$request->keyword.'%');
			});
		}

		$inspections = $inspections->paginate(10);

		return response()->json($inspections);
	}

}
