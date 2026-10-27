<?php
namespace App\Modules\RepairManage\Models;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'repairs';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

	public function repairType()
	{
		return $this->belongsTo('App\Modules\RepairManage\Models\RepairType','repair_type_id','id');
	}

	public function attachments()
	{
		return $this->hasMany('App\Modules\RepairManage\Models\RepairAttachment','repair_id','id');
	}

}
