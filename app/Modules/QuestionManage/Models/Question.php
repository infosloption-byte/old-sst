<?php
namespace App\Modules\QuestionManage\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model{
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'induction_questions';

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

	public function answers()
	{
		return $this->hasMany('App\Modules\QuestionManage\Models\QuestionAnswer','question_id');
	}

}