<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostTransaction extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cost_transaction';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function costType()
	{
		return $this->belongsTo('App\Models\CostType','cost_type_id','id');
	}

	public function createdby()
	{
		return $this->belongsTo('App\Models\User','created_by','id');
	}

}
