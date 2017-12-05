<?php
//nem használt amezőit átvette a wrole-------------------------
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
    protected $fillable = ['name','daytype',  'unit', 'long', 'note', 'pub'];

    public function daytype()
    {
        return $this->belongsToMany('App\Daytype','wroleunit_daytype');
    }
    public function wroletime()
    {
        return $this->hasMany('App\Wroletime');
    }
}
