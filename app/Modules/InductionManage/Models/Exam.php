<?php
namespace App\Modules\InductionManage\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model{
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_exam';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function user()
	{
		return $this->belongsTo('App\Models\User','user_id','id');
	}

	public function question()
	{
		return $this->belongsTo('App\Modules\InductionManage\Models\InductionQuestion','q_id','id');
	}

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}