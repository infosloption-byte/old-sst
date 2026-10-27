<?php

namespace App\Modules\CertificationManage\Logics;

use DB;
use PDF;
use Image;
use Sentinel;
use Response;
use Carbon\Carbon;
use App\Classes\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use System\Employee\Models\Employee;
use System\Department\Models\Department;

use App\Modules\CertificationManage\Models\Certification;
use App\Modules\CertificationManage\Models\CertificationDocument;
use App\Modules\CertificationManage\Models\CertificationQuestion;
use App\Modules\CertificationManage\Models\CertificationQuestionAnswer;

class CertificationLogic{
        
    public function __construct(Functions $common)
    {
        $this->common = $common;
    }

    public function getCertificationData($request)
    {
	    $user = \Auth::user();

		$data = Certification::whereNull('deleted_at')->with(['documents','questions.answers']);

		$data = $data->orderBy('created_at','DESC')->paginate(10);

		return $data;
	}

    public function getAllCertifications($request)
    {
	    $user = \Auth::user();

		$data = Certification::whereNull('deleted_at')->with(['documents','questions.answers']);

		$data = $data->orderBy('created_at','DESC')->get();

		return $data;
	}

    public function getCertificationList($request)
    {
	    $user = \Auth::user();

		$data = Certification::whereNull('deleted_at')->select(['id','title'])->get();

		return $data;
	}

	public function createCertificate($request)
    {
	    $response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$certificate = Certification::create([
		    		'title'  => $request->title,
		    		'created_by' => \Auth::user()->id
		    	]);

		    	if($certificate)
		    	{
		    		if ($request->hasFile('certificate_image'))
                    {
                    	$filePath = 'uploads/certificates';
                        
                        $this->common->makeDirNotExist($filePath, 0777, true);
                        $fileName = '';

                        $certificateImage = $request->file('certificate_image');

                        $extn = $certificateImage->getClientOriginalExtension(); //get extension

                        $fileName = $certificate->title.'.'.$extn; //set file name

                        $destinationPath = storage_path($filePath); // destination
                        $certificateImage->move($destinationPath, $fileName);//move to file

                        $certificate->certificate_image = $fileName;
                        $certificate->save();
                    }

                    if(isset($request->documents))
                    {
                    	foreach ($request->documents as $k=>$value)
                    	{
                    		$filePath = 'uploads/documents';
	                        
	                        $this->common->makeDirNotExist($filePath, 0777, true);
	                        $fileName = '';

	                        $extn = $value->getClientOriginalExtension(); //get extension

	                        $fileName = $certificate->title.'_'.$k.'.'.$extn; //set file name

	                        $destinationPath = storage_path($filePath); // destination
	                        $value->move($destinationPath, $fileName);//move to file

	                        CertificationDocument::create([
	                        	'certification_id' => $certificate->id,
	                        	'file_name' => $fileName
	                        ]);
		                    
                    	}
                    }

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Certificate created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Certificate creation faild';
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

    public function removeDocument($request)
    {
    	$response = [];

    	DB::transaction(function () use($request,&$response)
		{
	    	if(file_exists(storage_path('uploads/documents/'.$request->file_name)))
	        {
	            unlink(storage_path('uploads/documents/'.$request->file_name));
	        }

	        CertificationDocument::where('id',$request->doc_id)->delete();

	    	$response = Certification::where('id',$request->certificate_id)->with(['documents','questions.answers'])->first();

	    });

		return $response;
	}

    public function updateCertificate($request)
    {
	    $response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				
		    	$certificate = Certification::find($request->certificate_id);

		    	if($certificate)
		    	{
		    		$certificate->title  = $request->edit_title;
		    		$certificate->save();

		    		if ($request->hasFile('edit_certificate_image'))
                    {
                    	if(file_exists(storage_path('uploads/certificates/'.$certificate->certificate_image)))
                    	{
				            unlink(storage_path('uploads/certificates/'.$certificate->certificate_image));

				            $certificate->certificate_image = '';
				            $certificate->save();
				        }

                    	$filePath = 'uploads/certificates';
                        
                        $this->common->makeDirNotExist($filePath, 0777, true);
                        $fileName = '';

                        $certificateImage = $request->file('edit_certificate_image');

                        $extn = $certificateImage->getClientOriginalExtension(); //get extension

                        $fileName = $certificate->title.'.'.$extn; //set file name

                        $destinationPath = storage_path($filePath); // destination
                        $certificateImage->move($destinationPath, $fileName);//move to file

                        $certificate->certificate_image = $fileName;
                        $certificate->save();
                    }

                    if(isset($request->edit_documents) && count($request->edit_documents)>0)
                    {
                    	foreach ($request->edit_documents as $k=>$value)
                    	{
                    		$docs = CertificationDocument::create([
	                        	'certification_id' => $certificate->id
	                        ]);

                    		$filePath = 'uploads/documents';
	                        
	                        $this->common->makeDirNotExist($filePath, 0777, true);
	                        $fileName = '';

	                        $extn = $value->getClientOriginalExtension(); //get extension

	                        $fileName = $certificate->title.'_'.$docs->id.'.'.$extn; //set file name

	                        $destinationPath = storage_path($filePath); // destination
	                        $value->move($destinationPath, $fileName);//move to file

	                        $docs->file_name = $fileName;
	                        $docs->save();
		                    
                    	}
                    }

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Certificate updated';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Certificate update faild';
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

    public function getQuestionData($request)
    {
	    $user = \Auth::user();

		$data = CertificationQuestion::whereNull('deleted_at')->with(['certification','realanswer','answers']);

		if(isset($request->keyword) && $request->keyword!='')
		{
			$data = $data->where('question','like','%'.$request->keyword.'%');
		}

		if(isset($request->certificate) && ($request->certificate!='' || $request->certificate!=0))
		{
			$data = $data->where('certification_id',$request->certificate);
		}

		$data = $data->orderBy('certification_id','asc')->orderBy('question','asc')->paginate(10);

		return $data;
	}

    public function createQuestion($request)
    {
	    $response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$question = CertificationQuestion::create([
		    		'certification_id'  => $request->selected_certificate,
		    		'question'    	=> $request->question
		    	]);

		    	if($question)
		    	{
		    		foreach ($request['answers'] as $k=>$value)
		    		{
		    			$answer = CertificationQuestionAnswer::create([
		    				'question_id' => $question->id,
		    				'answer' => $value
		    			]);

		    			if($request->real_answer == $k+1)
		    			{
		    				$question->exact_answer_id = $answer->id;
		    				$question->save();
		    			}
		    		}

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Question created';
		    	}else{
		    		$response['status_code'] = 500;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Question creation faild';
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

    public function updateQuestion($request)
    {
	    $response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$question = CertificationQuestion::find($request->question_id);

				if($question)
		    	{
					$question->certification_id  = $request->edit_certificate;
					$question->question    	= $request->edit_question;

		    		foreach ($request['edit_answers_id'] as $k=>$value)
		    		{
		    			$answer = CertificationQuestionAnswer::find($value);

		    			if($answer)
		    			{
		    				$answer->answer = $request['edit_answers'][$k];
		    				$answer->save();

		    				if($request->edit_real_answer == $answer->id){
		    					$question->exact_answer_id = $answer->id;
		    					$question->save();
		    				}
		    			}
		    		}

		    		$response['status_code'] = 200;
		    		$response['message'] = 'Success';
		    		$response['debug'] = 'Question updated';
		    	}else{
		    		$response['status_code'] = 404;
		    		$response['message'] = 'Faild';
		    		$response['debug'] = 'Question cannot found';
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

    public function uploadQuestions($request)
    {
	    $response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$path = $request->file('files')->getRealPath();
	            $data = Excel::load($path, function($reader) {
	                $reader->formatDates(true, 'Y-m-d');
	            })->get()->toArray();

	    		$user = \Auth::user();

			    foreach ($data as $row)
			    {
			    	$question = CertificationQuestion::where('certification_id',$request->q_certificate)->where('question',$row['question'])->first();

			    	if(!$question){
				    	$question = CertificationQuestion::create([
				    		'certification_id'  => $request->q_certificate,
				    		'question'    	=> $request->question
				    	]);
				    }

			    	if($question)
			    	{
			    		$answer = CertificationQuestionAnswer::create([
		    				'question_id' => $question->id,
		    				'answer' => $row['answer']
		    			]);

		    			if(isset($row['real_answer']) && ($row['real_answer']=='YES'||$row['real_answer']=='yes'))
		    			{
		    				$question->exact_answer_id = $answer->id;
		    				$question->save();
		    			}
		    		}
			    }

			    $response['status_code'] = 200;
	    		$response['message'] = 'Success';
	    		$response['debug'] = 'Questions uploaded';
				
			});

			return $response;

		} catch (Exception $e) {
            $response['status_code'] = 500;
            $response['message'] = "Internal Server Error";
            $response['debug'] = $e->getMessage();

            return response()->json($response);
        }
	}
   
}