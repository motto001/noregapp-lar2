<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'days';

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
    protected $fillable = ['worker_id', 'year', 'mounth', 'day', 'type'];

    public function worker()
	{
		return $this->belongsTo('App\Worker');
	}
	
}
