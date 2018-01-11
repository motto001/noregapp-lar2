<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

//use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\DB;
use App\Wroleunit;
use App\Daytype;
use App\Wroletime;
use Illuminate\Http\Request;
use Session;

class WroleunitsController extends \App\Handler\MoController
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;

protected $par= [    
    'get_key'=>'wru', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
    'routes'=>['base'=>'manager/wroleunits','wrole'=>'manager/wrole'],//A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
    //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
    'view'=>'manager.wroleunits', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
    'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim'=>'Műszakok',       
];
protected $bas= [
    'search'=>false,
    'with'=>'wroletime',
    'get'=>['wrole_id'=>null,'worker_redir'=>null,'worker_id'=>null], //pl:'w_id'=>null a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be 
    'obname'=>'\App\Wroleunit',   
];
protected $val=[
	'name' => 'required|string',
    'unit' => 'required|string',
    'long' => 'required|integer',
    'note' => 'string|max:200|nullable',
    'pub' => 'integer'
];



public function create_set()
{

    $this->BASE['data']['basedaytype']=Daytype::get();
    $this->BASE['data']['checked_daytype']=[5];
   
}





public function edit_set()
{
    $id=$this->BASE['data']['id'];
    $checked_daytype=[];      
    $this->BASE['data'] = Wroleunit::with(['daytype','wroletime','wroletime.timetype'])->findOrFail($id);
   $this->BASE['data']['basedaytype']=Daytype::get();

    foreach($this->BASE['data']->daytype as $role){
        
        $checked_daytype[] =  $role->id;
    }
    $this->BASE['data']['checked_daytype']=$checked_daytype;
    $this->BASE['data']['list']=$this->BASE['data']->wroletime;
    
}


public function update($id, Request $request)
{
    $this->validate($request,$this->val);
    $requestData = $request->all();
    
    $wroleunit = Wroleunit::findOrFail($id);
    
    $wroleunit->update($requestData);

    $wroleunit->daytype()->sync($request->daytype_id);

    Session::flash('flash_message', 'Wroleunit updated!');

    return redirect(\MoHandF::url($this->PAR['baseroute'], $this->PAR['getT']));
}

public function destroy($id)
{
    Wroleunit::destroy($id);
    //->timetype()->detach('timetype_id');
    \DB::table('wroleunit_daytype')->where('wroleunit_id', '=', $id)->delete();
    Session::flash('flash_message', 'Wroleunit deleted!');

    return redirect(\MoHandF::url($this->PAR['baseroute'], $this->PAR['getT']));
}
 
}
