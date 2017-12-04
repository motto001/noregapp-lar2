<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wrole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wroles';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'note', 'start', 'pub'];
    public function workerwrole()
	{
		return $this->hasMany('App\WorkerWrole');
    } 
    public function full()
	{
		return $this->hasMany('App\WorkerWrole');
    } 
    public function wroleunit()
	{
		return $this->belongsToMany('App\Wroleunit','wroleunit_wrole');
    }  
    public function worker()
	{
		return $this->hasMany('App\Worker');
	}
	
}
