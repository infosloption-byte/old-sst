<?php
namespace App\Modules\JobManage\Models;

use Illuminate\Database\Eloquent\Model;

class RegularJobTransaction extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'regular_job_transaction';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function job()
	{
		return $this->belongsTo('App\Modules\JobManage\Models\Job','job_id','id');
	}

	public function actionby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}
