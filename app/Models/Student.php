<?php namespace chineseClass\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {
	public $timestamps = false;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'students';

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
	protected $hidden = ['id'];

	public function teachers()
    {
        return $this->belongsToMany('chineseClass\Models\Teacher');
    }
}
