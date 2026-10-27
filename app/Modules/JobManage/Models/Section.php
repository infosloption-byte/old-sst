<?php
namespace App\Modules\JobManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'job_section';

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

	public function tasks()
	{
		return $this->hasMany('App\Modules\JobManage\Models\Task','section_id');
	}

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}
