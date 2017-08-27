<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workeruser extends Model
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
    protected $fillable = ['user_id', 'cim', 'tel', 'birth', 'ado', 'tb', 'start', 'end', 'statusz'];
    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }
    public function wuSearch($find){
        self::with('user')->where('name', $find)->where('email',$find)->get();
   }

    
}
