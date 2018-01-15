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

protected $par= [    
    'get_key'=>'wrole', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
    'routes'=>['base'=>'manager/wroles','worker'=>'manager/worker'],//A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
    //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
    'view'=>'manager.wroles', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
    'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim'=>'Munkarendek',       
];
protected $base= [
    'search'=>false,
    'with'=>'wroleunit',
    'get'=>['wrole_id'=>null,'unit_id'=>null,'wrole_redir'=>null,'worker_id'=>null], //pl:'w_id'=>null a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be 
    'obname'=>'\App\Wrole',   
    'func'=>['set_ob','set_getT','set_redir','set_task'],  
];


 protected $val = [
        'name' => 'required|string|max:200',
        'note' => 'string|max:200|nullable',
        'start' => 'string|max:200|nullable',
        'pub' => 'integer'
 ];
 public function edit_set()
 {
     $this->BASE['data']['wroleunits_all']=Wroleunit::get();
 }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
    */
    /*
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
 */
    public function addunit()
    {
         DB::table('wrole_wroleunit')->insert(
        ['wrole_id' => $this->PAR['getT']['wrole_id'], 'wroleunit_id' => $this->PAR['getT']['unit_id']]);
    //  return  redirect(\MoHandF::url('manager/wroles/'.$this->PAR['getT']['wrole_id'].'/edit', $this->PAR['getT']));  
   
         $url=\MoHandF::url('manager/wroles/'.$this->PAR['getT']['wrole_id'].'/edit', $this->PAR['getT']);
 
         header("Location:$url");
         die();
   }
    public function delunit()
    {
        DB::table('wrole_wroleunit')->where([
        ['wrole_id', '=', $this->PAR['getT']['wrole_id']],['wroleunit_id', '=', $this->PAR['getT']['unit_id']]])
        ->delete(); 
        $url=\MoHandF::url('manager/wroles/'.$this->PAR['getT']['wrole_id'].'/edit', $this->PAR['getT']);
        header("Location:$url");
        die();  
    }
}
