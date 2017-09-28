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

    public function wroleunit()
	{
		return $this->hasMany('App\Wroleunit');
	}
	
}
