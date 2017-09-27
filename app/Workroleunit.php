<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workroleunit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workroleunits';

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
    protected $fillable = ['workrole_id', 'timeunit_id', 'worktime_id'];

    
}
