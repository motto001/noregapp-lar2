<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workrole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workroles';

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

    public function workroleunit()
	{
		return $this->hashasMany('App\Workroleunit');
	}
	
}
