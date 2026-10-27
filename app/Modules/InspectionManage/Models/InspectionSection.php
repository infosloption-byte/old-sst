<?php
namespace App\Modules\InspectionManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionSection extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'inspect_job_section';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function inspectJob()
	{
		return $this->belongsTo('App\Modules\InspectionManage\Models\InspectionJob','inspect_job_id','id');
	}

	public function jobSection()
	{
		return $this->belongsTo('App\Modules\JobManage\Models\Section','job_section_id','id')->withTrashed();
	}

	public function tasks()
	{
		return $this->hasMany('App\Modules\InspectionManage\Models\InspectionTask','inspect_section_id','id');
	}

	public function pendingTasks()
	{
		return $this->hasMany('App\Modules\InspectionManage\Models\InspectionTask','inspect_section_id','id')->where('status',0);
	}

	public function completedTasks()
	{
		return $this->hasMany('App\Modules\InspectionManage\Models\InspectionTask','inspect_section_id','id')->where('status',1);
	}

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}
