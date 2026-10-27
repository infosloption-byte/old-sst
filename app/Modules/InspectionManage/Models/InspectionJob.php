<?php
namespace App\Modules\InspectionManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionJob extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'inspect_job';

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

	public function manager()
	{
		return $this->belongsTo('System\Employee\Models\Employee','manager_id','id');
	}

	public function sections()
	{
		return $this->hasMany('App\Modules\InspectionManage\Models\InspectionSection','inspection_job_id','id');
	}

	public function tasks()
	{
		return $this->hasMany('App\Modules\InspectionManage\Models\InspectionTask','inspect_job_id','id');
	}

	public function pendingTasks()
	{
		return $this->hasMany('App\Modules\InspectionManage\Models\InspectionTask','inspect_job_id','id')->where('status',0);
	}

	public function completedTasks()
	{
		return $this->hasMany('App\Modules\InspectionManage\Models\InspectionTask','inspect_job_id','id')->where('status',1);
	}

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}