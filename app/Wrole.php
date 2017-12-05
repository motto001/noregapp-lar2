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
  
    public function daytype()
	{
		return $this->belongsToMany('App\Daytype','wrole_daytype');
    } 
    public function wroletime()
	{
		return $this->belongsToMany('App\Wroletime','wrole_wroletime');
    }  
    public function worker()
	{
		return $this->hasMany('App\Worker');
	}
	
}
