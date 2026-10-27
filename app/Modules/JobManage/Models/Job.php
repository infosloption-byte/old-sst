<?php
namespace App\Modules\JobManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'job';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function category()
	{
		return $this->belongsTo('App\Modules\JobManage\Models\JobCategory','job_category_id','id');
	}

	public function client()
	{
		return $this->belongsTo('System\Employee\Models\Employee','client_id','id');
	}

	public function inspection()
	{
		return $this->hasOne('App\Modules\InspectionManage\Models\InspectionJob','job_id','id');
	}

	public function sections()
	{
		return $this->hasMany('App\Modules\JobManage\Models\Section','job_id');
	}

	public function tasks()
	{
		return $this->hasMany('App\Modules\JobManage\Models\Task','job_id');
	}

	public function transactions()
	{
		return $this->hasMany('App\Modules\JobManage\Models\JobTransaction','job_id')->orderBy('created_at','DESC');
	}

	public function regularTransactions()
	{
		return $this->hasMany('App\Modules\JobManage\Models\RegularJobTransaction','job_id')->orderBy('created_at','DESC');
	}

	public function costLogs()
	{
		return $this->hasMany('App\Models\CostTransaction','reference_id')->where('reference_type','JOB')->orderBy('effective_date','DESC');
	}

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}
