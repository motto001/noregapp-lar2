<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worktimeunit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'worktimeunits';

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
    protected $fillable = ['worktimetype_id', 'start', 'end', 'hour', 'note', 'pub'];

    public function worktimetype()
	{
		return $this->belongsTo('App\Worktimetype');
	}
	
}
