<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSectionTask extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'master_section_task';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function masterSection()
	{
		return $this->belongsTo('App\Models\MasterSection','master_section_id','id');
	}

	public function taskCategory()
	{
		return $this->belongsTo('App\Modules\JobManage\Models\TaskCategory','task_category_id','id');
	}

}
