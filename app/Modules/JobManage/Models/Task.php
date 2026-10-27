<?php
namespace App\Modules\JobManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'job_section_task';

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

	public function section()
	{
		return $this->belongsTo('App\Modules\JobManage\Models\Section','section_id','id');
	}

	public function category()
	{
		return $this->belongsTo('App\Modules\JobManage\Models\TaskCategory','task_category_id','id');
	}

	public function assignTo()
	{
		return $this->belongsTo('System\Employee\Models\Employee','assigned_to','id');
	}

	public function masterTask()
	{
		return $this->belongsTo('App\Models\MasterSectionTask','master_task_id','id');
	}

	public function transactions()
	{
		return $this->hasMany('App\Modules\JobManage\Models\JobTransaction','task_id')->orderBy('created_at','DESC');
	}

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}
