<?php
namespace System\UserRoles\Models;

use Zizaco\Entrust\EntrustPermission;

class PermissionRole extends EntrustPermission{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permission_role';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];


}
