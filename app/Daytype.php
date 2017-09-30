<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daytype extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'daytypes';

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
    protected $fillable = ['name', 'szorzo', 'fixplusz', 'color', 'note'];
  
    public function timeunit()
    {
        return $this->belongsToMany('App\Timeunit');
    }  
    public function day()
    {
        return $this->hasOne('App\Day');
    }  
    public function chworkerday()
    {
        return $this->hasOne('App\chworkerday');
    }  
    
}
