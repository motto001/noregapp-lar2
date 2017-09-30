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
    protected $fillable = ['user_id', 'wrole_id', 'status_id', 'workertype_id', 'workergroup_id', 'salary', 'salary_type', 'position', 'foto', 'fullname', 'cim', 'tel', 'birth', 'ado', 'tb', 'start', 'end', 'note', 'pub'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function workrole()
    {
        return $this->belongsTo('App\Workrole');
    }
    public function status()
    {
        return $this->belongsTo('App\status');
    }
    public function workertype()
    {
        return $this->belongsTo('App\Workertype');
    }
    public function workergroup()
    {
        return $this->belongsToMany('App\Workergroup');
    }
    public function day()
    {
        return $this->hasMany('App\day');
    }
    public function chworkerday()
    {
        return $this->hasMany('App\Chworkerday');
    }
    public function chworkertime()
    {
        return $this->hasMany('App\Chworkertime');
    }
    public function timeframe()
    {
        return $this->belongsToMany('App\Timeframe');
    }
    
}