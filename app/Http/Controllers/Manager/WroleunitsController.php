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
/**
 * validációs szabályok 
 */
protected $valT=[
	'name' => 'required|string',
    'unit' => 'required|string',
    'long' => 'required|integer',
    'note' => 'string|max:200|nullable',
    'pub' => 'integer'
];
/**
 * minden viewnwk megosztott paraméterek
 */
protected $paramT= [
    'baseroute'=>'manager/wroleunits',
    'baseview'=>'manager.wroleunits', 
    'cim'=>'Munkarend egység',
];

   function __construct(Request $request){ 
    $this->paramT['id']=$request->route('id') ?? 0; ;
    $this->paramT['parrent_id']=Input::get('parrent_id') ?? 0;
    
    if($this->paramT['parrent_id']>0){
        $this->paramT['route_param']='/?parrentid='.$this->paramT['parrent_id'];}
    else{
        $this->paramT['route_param']='';}

    View::share('param',$this->paramT);
   }
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $wroleunits = Wroleunit::where('name', 'LIKE', "%$keyword%")
				->orWhere('unit', 'LIKE', "%$keyword%")
				->orWhere('long', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $wroleunits = Wroleunit::paginate($perPage);
        }
        $data['list']=$wroleunits;
        return view('crudbase.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $data['basedaytype']=Daytype::get();
        $data['checked_daytype']=[5];
        return view('crudbase.create', compact('data'));
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
        $this->validate($request,$this->valT);
        $requestData = $request->all();
        
        $wroleunit= Wroleunit::create($requestData);
        $wroleunit->daytype()->sync($request->daytype_id);
        Session::flash('flash_message', 'Wroleunit added!');

        return redirect($this->paramT['baseroute']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $data = Wroleunit::findOrFail($id);

        return view($this->paramT['baseview'].'.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
              
        $data = Wroleunit::with(['daytype','wroletime','wroletime.timetype'])->findOrFail($id);
        $data['basedaytype']=Daytype::get();
    
        foreach($data->daytype as $role){
            
            $checked_daytype[] =  $role->id;
        }
        $data['checked_daytype']=$checked_daytype;
        $data['list']=$data->wroletime;
        $data['id']=$id ;
        return view('crudbase.edit', compact('data'));
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
        $this->validate($request, [
		
		]);
        $requestData = $request->all();
        
        $wroleunit = Wroleunit::findOrFail($id);
        
        $wroleunit->update($requestData);

        $wroleunit->daytype()->sync($request->daytype_id);

        Session::flash('flash_message', 'Wroleunit updated!');

        return redirect($this->paramT['baseroute']);
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
        DB::table('wroleunit_daytype')->where('wroleunit_id', '=', $id)->delete();
        Session::flash('flash_message', 'Wroleunit deleted!');

        return redirect($this->paramT['baseroute']);
    }



    
     public function wroleunitToModal($wroleid)
    {
        $wroleunits2 = Wroleunit::get();
       // print_r($wroleunits);
       $wroleunits['wroleunits']=$wroleunits2;
        $wroleunits['wrole_id']=$wroleid;
        return view('manager.wroleunits.wroleunit-to-selectmodal', compact('wroleunits'));
    }
    public function showToModal($id)
    {
        $wroleunit = Wroleunit::with(['daytype','wroletime','wroletime.timetype'])->findOrFail($id);
        $wroleunit['basedaytype']=Daytype::get();
    
        foreach($wroleunit->daytype as $role){
            
            $checked_daytype[] =  $role->id;
        }
        $wroleunit['checked_daytype']=$checked_daytype;
        return view('manager.wroleunits.show-to-modal', compact('wroleunit'));
    }
    public function timedel($id)
    {
        Wroletime::destroy($id);
        return redirect($this->paramT['basroute']);
    }

}
