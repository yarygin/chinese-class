<?php namespace chineseClass\Models;

use Illuminate\Database\Eloquent\Model;
use chineseClass\Models\Teacher;
use DB;

class Teacher extends Model {
	public $timestamps = false;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'teachers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id_teacher'];



	/**
	 * method to get students list.
	 *
	 * @var array
	 */
	public function students()
	{
		return $this->belongsToMany('chineseClass\Models\Student');
	}
}
