<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daytimechange extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'daytimechanges';

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
    protected $fillable = ['day_id', 'worktimetype_id', 'start', 'end', 'hour', 'managernote', 'worjernote', 'pub'];

    
}
