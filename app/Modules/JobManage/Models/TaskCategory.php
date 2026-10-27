<?php
namespace App\Modules\JobManage\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'task_category';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}
