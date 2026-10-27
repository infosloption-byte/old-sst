<?php
namespace System\Permissions\Models;

use Zizaco\Entrust\EntrustPermission;

/**
 * UserRole Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
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

	public function createdby()
	{
		 return $this->belongsTo('App\Models\User','created_by','id');
	}

}
