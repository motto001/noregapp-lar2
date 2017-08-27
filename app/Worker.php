<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workers';

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
    protected $fillable = ['user_id', 'cim', 'tel', 'birth', 'ado', 'tb', 'start', 'end', 'statusz'];

    public function workeruser()
    {
      return $this->belongsTo('App\Workeruser','id');
    }
}
