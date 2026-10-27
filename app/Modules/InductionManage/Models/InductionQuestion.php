<?php
namespace App\Modules\InductionManage\Models;

use Illuminate\Database\Eloquent\Model;

class InductionQuestion extends Model{
	
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
		return $this->hasMany('App\Modules\InductionManage\Models\InductionQuestionAnswer','question_id');
	}

}