<?php
namespace App\Modules\QuestionManage\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model{
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'induction_question_answers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}