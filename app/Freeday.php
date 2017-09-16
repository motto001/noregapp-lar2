<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Freeday extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'freedays';

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
    protected $fillable = ['worker_id', 'datum', 'pub'];
    /*
    public function worker(){
        // return $this->belongsTo('App\User','user_id','id');
        return $this->belongsTo('App\Worker');
         }
    */
}
