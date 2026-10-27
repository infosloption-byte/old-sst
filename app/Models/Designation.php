<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'designation';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}
