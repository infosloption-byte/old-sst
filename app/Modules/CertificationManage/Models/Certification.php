<?php
namespace App\Modules\CertificationManage\Models;

/**
 * Certification Model Class
 *
 */
use Illuminate\Database\Eloquent\Model;

class Certification extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'certification';

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

	public function documents()
	{
		return $this->hasMany('App\Modules\CertificationManage\Models\CertificationDocument','certification_id');
	}

	public function questions()
	{
		return $this->hasMany('App\Modules\CertificationManage\Models\CertificationQuestion','certification_id');
	}

}
