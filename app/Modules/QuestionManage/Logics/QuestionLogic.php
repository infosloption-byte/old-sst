<?php

namespace App\Modules\QuestionManage\Logics;

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

use App\Modules\QuestionManage\Models\Question;
use App\Modules\QuestionManage\Models\QuestionAnswer;

class QuestionLogic{
        
    public function __construct(Functions $common)
    {
        $this->common = $common;
    }

    public function getQuestionData($request)
    {
	    $user = \Auth::user();

		$data = Question::whereNull('deleted_at')->with(['answers']);

		if(isset($request->keyword) && $request->keyword!='')
		{
			$data = $data->where('question','like','%'.$request->keyword.'%');
		}

		$data = $data->get();

		return $data;
	}

    public function createQuestion($request)
    {
	    $response = [];

    	try{

	    	DB::transaction(function () use($request,&$response)
			{
				$question = Question::create([
		    		'question' => $request->question,
		    		'created_by' => \Auth::getUser()->id
		    	]);

		    	if($question)
		    	{
		    		foreach ($request['answers'] as $k=>$value)
		    		{
		    			$answer = QuestionAnswer::create([
		    				'question_id' => $question->id,
		    				'answer' => $value
		    			]);

		    			if($request->real_answer == $k+1)
		    			{
		    				$question->answer = $answer->id;
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
				$question = Question::find($request->question_id);

				if($question)
		    	{
					$question->question = $request->edit_question;

		    		foreach ($request['edit_answers_id'] as $k=>$value)
		    		{
		    			$answer = QuestionAnswer::find($value);

		    			if($answer)
		    			{
		    				$answer->answer = $request['edit_answers'][$k];
		    				$answer->save();

		    				if($request->edit_real_answer == $answer->id){
		    					$question->answer = $answer->id;
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
   
}