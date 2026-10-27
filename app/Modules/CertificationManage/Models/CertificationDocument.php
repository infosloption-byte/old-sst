<?php
namespace App\Modules\CertificationManage\Models;

/**
 * Certification Document Model Class
 *
 */
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificationDocument extends Model{

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'certification_docs';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function certification()
	{
		return $this->belongsTo('App\Modules\CertificationManage\Models\Certification','certification_id','id');
	}

}
