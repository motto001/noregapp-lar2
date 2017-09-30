<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wroleunit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wroleunits';

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
    protected $fillable = ['wrole_id', 'start', 'end', 'hour', 'note', 'pub'];
   
    public function daytype()
    {
        return $this->belongsToMany('App\Daytype');
    }
    public function wrole()
    {
        return $this->belongsTo('App\Wrole');
    }
    public function wroletime()
    {
        return $this->hasMany('App\wroletime');
    }
    
}
