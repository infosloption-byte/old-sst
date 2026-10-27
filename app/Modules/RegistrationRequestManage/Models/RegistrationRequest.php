<?php
namespace App\Modules\RegistrationRequestManage\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationRequest extends Model{
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'registration_requests';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}