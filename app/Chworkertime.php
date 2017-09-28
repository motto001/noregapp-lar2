<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chworkertime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chworkertimes';

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
    protected $fillable = ['workerday_id', 'workertime_id', 'timetype_id', 'start', 'end', 'hour', 'managernote', 'workernote', 'pub'];

    
}
