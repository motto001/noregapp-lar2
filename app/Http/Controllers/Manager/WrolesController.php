<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Wrole;
use App\Wroleunit;
use Illuminate\Http\Request;
use Session;

class WrolesController extends \App\Handler\MoController
{
use  \App\Handler\trt\crud\CrudWithSetfunc;
use  \App\Handler\trt\SetController;

public function set_base(){
 $this->PAR['routes']['base']= 'manager/wroles';
 $this->PAR['routes']['worker']= 'manager/worker';
 $this->PAR['view']= 'manager.wroles';
 $this->PAR['crudview']= 'crudbase_3';    
 $this->PAR['cim']= 'Munkarendek';
// $this->PAR['search']= false;
 $this->BASE['obname']= '\App\Wrole'; 
 $this->BASE['func']= ['set_ob']; 

}
 protected $val = [
        'name' => 'required|string|max:200',
        'note' => 'string|max:200|nullable',
        'start' => 'string|max:200|nullable',
        'pub' => 'integer'
 ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index_set()
    {
        $request=$this->BASE['request'];
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $wroles = Wrole::where('name', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $wroles = Wrole::paginate($perPage);
        }
        $this->BASE['data']['list']=$wroles;
    }



    public function wroleunitSelectToSave($wroleunit_id,$wrole_id)
    {
        DB::table('wroleunit_wrole')->insert(
            ['wroleunit_id' =>$wroleunit_id , 'wrole_id' => $wrole_id]
        );
        return redirect('manager/wroles/'.$wrole_id.'/edit');
    }
    public function wroleunitToDel($wroleunit_id,$wrole_id)
    {
      DB::table('wroleunit_wrole')
        ->where('wroleunit_id', '=', $wroleunit_id)
        ->where('wrole_id', '=', $wrole_id)
        ->delete();;
        return redirect('manager/wroles/'.$wrole_id.'/edit');
    }




}
