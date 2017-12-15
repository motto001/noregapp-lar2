<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\DB;
use App\Wroleunit;
use App\Daytype;
use App\Wroletime;
use Illuminate\Http\Request;
use Session;

class WroleunitsController extends Controller
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;
    protected $PAR= [
     
        'get_key'=>'wru', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
        'redirect'=>['base'=>'manager/wroleunits','wrole'=>'manager/wrole'],//A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view'=>'manager.wroleunits', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'crudview'=>'crudbase_2', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Műszakok',
        'getT'=>[],       
    ];
   
protected $val=[
	'name' => 'required|string',
    'unit' => 'required|string',
    'long' => 'required|integer',
    'note' => 'string|max:200|nullable',
    'pub' => 'integer'
];
protected $TPAR= [];
protected $BASE= [
    'search'=>false,
    'get'=>['wrole_id'=>null,'wrole_ret'=>null,'worker_id'=>null], //pl:'w_id'=>null a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
    'get_post'=>[],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
    'obname'=>'\App\Wroleunit',
    'ob'=>null,
    
];
protected $TBASE= [];

protected $val_edit= [];
   function __construct(Request $request){

    $this->setTask();
    $this->set_getT($request);
    $obname=$this->BASE['obname'];
    $this->BASE['ob']=new $obname();
    View::share('param',$this->PAR);
   }
    public function index_set($ob,$keyword,$getT,$perPage)
    {
    
        $data['list'] = Wroleunit::with('wroletime')->paginate($perPage);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create_set()
    {

        $data['basedaytype']=Daytype::get();
        $data['checked_daytype']=[5];
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request,$this->val);
        $requestData = $request->all();
        
        $wroleunit= Wroleunit::create($requestData);
        $wroleunit->daytype()->sync($request->daytype_id);
        Session::flash('flash_message', 'Workerday added!');
        // echo 'store';
         return redirect(\MoHandF::url($this->PAR['baseroute'], $this->PAR['getT']));

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit_set($id)
    {
        $checked_daytype=[];      
        $data = Wroleunit::with(['daytype','wroletime','wroletime.timetype'])->findOrFail($id);
        $data['basedaytype']=Daytype::get();
    
        foreach($data->daytype as $role){
            
            $checked_daytype[] =  $role->id;
        }
        $data['checked_daytype']=$checked_daytype;
        $data['list']=$data->wroletime;
        $data['id']=$id ;
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Wroleunit::destroy($id);
        //->timetype()->detach('timetype_id');
        \DB::table('wroleunit_daytype')->where('wroleunit_id', '=', $id)->delete();
        Session::flash('flash_message', 'Wroleunit deleted!');

        return redirect(\MoHandF::url($this->PAR['baseroute'], $this->PAR['getT']));
    }


 

}
