<?php
namespace System\UserRoles\Models;

use Zizaco\Entrust\EntrustPermission;


class Permission extends EntrustPermission{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permissions';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];


}
