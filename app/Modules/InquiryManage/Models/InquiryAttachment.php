<?php
namespace App\Modules\InquiryManage\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryAttachment extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'inquiry_attachment';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}
