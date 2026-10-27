<?php
namespace System\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Employee extends Model{

	use NodeTrait;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'employee';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];


	public function user()
	{
		return $this->belongsTo('App\Models\User','id','employee_id');
	}

	public function department()
	{
		return $this->belongsTo('System\Department\Models\Department','department_id','id');
	}

    public function supervisor()
    {
        return $this->belongsTo('System\Employee\Models\Employee','parent_id','id');
    }

    public function designation()
    {
        return $this->belongsTo('App\Models\Designation','designation_id','id');
    }

    public function certification()
    {
        return $this->belongsTo('App\Modules\CertificationManage\Models\EmployeeCertification','id','employee_id');
    }


}
