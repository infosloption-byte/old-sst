<?php
namespace App\Modules\RepairManage\Models;

use Illuminate\Database\Eloquent\Model;

class RepairAttachment extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'repair_attachment';

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

	public function repair()
	{
		return $this->belongsTo('App\Modules\RepairManage\Models\Repair','repair_id','id');
	}

}
