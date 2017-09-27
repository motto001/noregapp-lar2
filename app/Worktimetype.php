<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worktimetype extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'worktimetypes';

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

    public function worktimeunit()
	{
		return $this->hasOne('App\Worktimeunit');
	}
	
}
