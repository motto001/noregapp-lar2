<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worktime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'worktimes';

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
    protected $fillable = ['day_id',  'start', 'end', 'hour', 'type'];

    public function day(){
    // return $this->belongsTo('App\User','user_id','id');
    return $this->belongsTo('App\Day');
    }
  

	
}
