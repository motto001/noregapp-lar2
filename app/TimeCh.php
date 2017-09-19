<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmeCh extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_ch';

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
    protected $fillable = ['time_id','type_id',  'start', 'end', 'hour','workernote','managernote','pub'];

    public function day()
	{
		return $this->belongsTo('App\Day');
	}
    public function type()
	{
		return $this->belongsTo('App\DayType');
	}
}
