<?php
namespace App\Modules\CertificationManage\Models;

/**
 * Employee Certification Model Class
 *
 */
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeCertification extends Model{

	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'employee_certification';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function employee()
	{
		return $this->belongsTo('System\Employee\Models\Employee','employee_id','id');
	}

	public function certification()
	{
		return $this->belongsTo('App\Modules\CertificationManage\Models\Certification','certification_id','id');
	}

}
