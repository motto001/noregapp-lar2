<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daytypechange extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'daytypechanges';

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
    protected $fillable = ['day_id', 'daytype_id', 'pub', 'workernote', 'managernote'];

    
}
