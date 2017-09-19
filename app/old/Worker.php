<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
   protected $guarded = ['id', 'created_at', 'updated_at'];  
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
    protected $fillable = ['user_id',
    'unit_id', 'workrole_id', 'workertype_id' ,
    'status_id', 'frame_id','framestart',
     'salary','position', 'foto','fullname',
     'cim', 'tel', 'birth', 'ado', 'tb',
      'start', 'end','pub' ];

  
    public function user(){
     // return $this->belongsTo('App\User','user_id','id');
    return $this->belongsTo('App\User');
      }

    public function workrole(){
    return $this->belongsTo('App\Workrole');
    }

    public function timeunit(){
    return $this->belongsTo('App\Timeunit');
    }
//nem fontos a timeunittot is lehet használni a frame iddel:
    public function frame(){ 
    return $this->belongsTo('App\Timeunit','frame_id','id');
    }

    public function status()
    {
     return $this->belongsTo('App\Status');
    }
    public function workertype()
    {
    return $this->belongsTo('App\Workertype');
    }


    public function day()
    {
    return $this->hasMany('App\Day');
    }
    public function daych()
    {
    return $this->hasMany('App\Daych');
    }  
      
    public function time_ch()
    {
    return $this->hasMany('App\Timech');
    }  
      
}