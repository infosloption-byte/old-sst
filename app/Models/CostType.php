<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostType extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cost_type';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}
