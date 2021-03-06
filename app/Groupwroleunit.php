<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupwroleunit extends Model
{
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'grouproleunit';

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
     * 
     */
    protected $fillable = ['worker_id', 'wroleunit_id','wish_id', 'start', 'end', 'pub'];
    //protected $guarded = [];
    public function worker_with_user()
    {
        return $this->belongsTo('App\Worker')->with('user');;
    }
    public function workergroup()
    {
        return $this->belongsTo('App\Worker');
    }
    public function worker()
    {
        return $this->belongsTo('App\Worker');
    }
    public function wroleunit()
    {
        return $this->belongsTo('App\Wroleunit');
    }
  
    
}
