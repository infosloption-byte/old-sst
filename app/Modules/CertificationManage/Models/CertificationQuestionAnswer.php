<?php
namespace App\Modules\CertificationManage\Models;

/**
 * Certification Question Answer Model Class
 *
 */
use Illuminate\Database\Eloquent\Model;

class CertificationQuestionAnswer extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'certification_question_answers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function question()
	{
		return $this->belongsTo('App\Modules\CertificationManage\Models\CertificationQuestion','question_id','id');
	}

}
