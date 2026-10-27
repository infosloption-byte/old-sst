<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'appointments';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}
