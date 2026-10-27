<?php
namespace System\UserRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;
use System\UserRoles\Models\Permission;
use System\UserRoles\Models\PermissionRole;


class UserRole extends EntrustRole{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function permissions()
	{
		 return $this->belongsToMany('System\UserRoles\Models\Permission','permission_role','role_id','permission_id');
	}

	public function createdby()
	{
		 return $this->belongsTo('App\Models\User','created_by','id');
	}

}
