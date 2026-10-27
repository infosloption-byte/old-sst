<?php
namespace App\Modules\CertificationManage\Models;

/**
 * Certification Question Model Class
 *
 */
use Illuminate\Database\Eloquent\Model;

class CertificationQuestion extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'certification_questions';

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

	public function realanswer()
	{
		return $this->hasOne('App\Modules\CertificationManage\Models\CertificationQuestion','exact_answer_id','id');
	}

	public function answers()
	{
		return $this->hasMany('App\Modules\CertificationManage\Models\CertificationQuestionAnswer','question_id');
	}

}
