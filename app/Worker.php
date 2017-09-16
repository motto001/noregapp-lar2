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
    protected $fillable = ['user_id','timeunit_id','status_id','workertype_id', 'cim', 'tel', 'birth', 'ado', 'tb', 'start', 'end', 'statusz'];

  
    public function user(){
     // return $this->belongsTo('App\User','user_id','id');
     return $this->belongsTo('App\User');
      }
      public function day()
      {
          return $this->hasMany('App\Day');
      }
      public function workertype()
      {
          return $this->belongsTo('App\Workertype');
      }
      public function status()
      {
          return $this->belongsTo('App\Status');
      }
      public function timeunit()
      {
          return $this->belongsTo('App\Timeunit');
      }

/*  public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }
      public function wuSearch($find){
      self::with('user')->where('name', $find)->where('email',$find)->get();
    }
    */

}