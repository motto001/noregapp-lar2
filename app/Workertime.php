<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workertime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workertimes';

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
    protected $fillable = ['day_id', 'timetype_id', 'start', 'end', 'hour', 'managernote', 'workernote'];
   
    public function day()
    {
        return $this->belongsTo('App\Day');
    }
    public function timetype()
    {
        return $this->belongsTo('App\Timetype');
    }
}
