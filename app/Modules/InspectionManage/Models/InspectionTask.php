<?php
namespace App\Modules\InspectionManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionTask extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'inspect_job_section_task';

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

	public function inspectionSection()
	{
		return $this->belongsTo('App\Modules\InspectionManage\Models\InspectionSection','inspect_section_id','id');
	}

	public function task()
	{
		return $this->belongsTo('App\Modules\JobManage\Models\Task','task_id','id');
	}

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}
