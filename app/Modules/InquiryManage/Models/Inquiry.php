<?php
namespace App\Modules\InquiryManage\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'inquiries';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function client()
	{
		return $this->belongsTo('System\Employee\Models\Employee','client_id','id');
	}

	public function attachments()
	{
		return $this->hasMany('App\Modules\InquiryManage\Models\InquiryAttachment','inquiry_id','id');
	}

	public function job()
	{
		return $this->hasOne('App\Modules\JobManage\Models\Job','id','job_id');
	}

}
