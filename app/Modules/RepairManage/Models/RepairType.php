<?php
namespace App\Modules\RepairManage\Models;

use Illuminate\Database\Eloquent\Model;

class RepairType extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'repair_type';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}
