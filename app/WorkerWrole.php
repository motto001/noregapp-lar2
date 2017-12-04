<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerWrole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'worker_wroles';

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
    protected $fillable = ['worker_id', 'wrole_id', 'start', 'end', 'pub'];
    //protected $guarded = [];
   
    public function worker()
    {
        return $this->belongsTo('App\Worker');
    }
    public function wrole()
    {
        return $this->belongsTo('App\Wrole');
    }
    public function wroleFull()
    {
        return $this->belongsTo('App\Wrole')->with('full');
    }
    
}
