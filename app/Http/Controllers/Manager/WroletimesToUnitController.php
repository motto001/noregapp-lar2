<?php

namespace App\Http\Controllers\Manager;

//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Timetype;
use App\Wroletime;
use Illuminate\Http\Request;
use Session;

class WroletimesToUnitController extends Controller
{
    /**
     * validációs szabályok 
     */
protected $valT=[
	'wroleunit_id' => 'required|integer',
    'timetype_id' => 'required|integer',
    'start' => 'required|date_format:H:i',
    'end' => 'date_format:H:i',
    'hour' => 'required|integer|max:24',
    'managernote' => 'string|max:200|nullable',
    'workernote' => 'string|max:200|nullable',
    'pub' => 'integer'
];
/**
 * minden viewnwk megosztott paraméterek
 */
protected $paramT= [
            'baseroute'=>'manager/wroletimes-to-unit',
            'baseview'=>'manager.wroletimestounit', 
            'cim'=>'Idők',
];

   function __construct(){

        View::share('param',$this->paramT);
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
 
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $routeparam=$request->get('routeparam');
      
       // $data['routeparam']=$_GET['routeparam'];
        if (!empty($keyword)) {
            $wroletimes2 = Wroletime::where('wroleunit_id', '=', $unit_id)
				->orWhere('timetype_id', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('workernote', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $wroletimes2 = Wroletime::where('wroleunit_id', '=',$routeparam)
            ->with('timetype')->paginate($perPage);
        }
     //  print_r($wroletimes2);
        $data['list']=$wroletimes2;
        $data['wroleunit_id']=$routeparam;
        $data['routeparam']='?routeparam='.$routeparam;
        $data['backurl']='manager/wroleunits/'.$routeparam.'/edit';

        return view('crudbase.index', compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */

    public function create(Request $request)
    {
       // $wroletimes = Wroletime::get();
        $data['timetype']= Timetype::pluck('name','id');
        $data['wroleunit_id']= $request->get('routeparam');
        $data['routeparam']='?routeparam=' .$request->get('routeparam');
        $data['cancelurl']=$this->paramT['baseroute'].'/'.$data['routeparam'];  
        return view('crudbase.create',compact('data'));
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
        $this->validate($request, $this->valT);
        $requestData = $request->all();
       // $routeparam=$request->get('routeparam');
         $wroletime=Wroletime::create($requestData);

        Session::flash('flash_message', 'Wroletime added!');

        return redirect($this->paramT['baseroute'].'/?routeparam='.$wroletime->wroleunit_id);
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
        $data = Wroletime::findOrFail($id);
        $data['timetype']= Timetype::pluck('name','id');
        $data['wroleunit_id']= $data->wroleunit_id;
      //  $routeparam=$request->get('routeparam');
        $data['routeparam']='?routeparam='.$data->wroleunit_id;
        $data['cancelurl']=$this->paramT['baseroute'].'/'.$data['routeparam'];       
        $data->start=substr( $data->start, 0, -3);
        $data->end=substr( $data->end, 0, -3);
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
        $this->validate($request, $this->valT);
        $requestData = $request->all();
        
        $wroletime = Wroletime::findOrFail($id);
        $wroletime->update($requestData);
       // $routeparam=$request->get('routeparam');
        Session::flash('flash_message', 'Wroletime updated!');

        return redirect($this->paramT['baseroute'].'/?routeparam='.$wroletime->wroleunit_id);
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
        //$wroletime = Wroletime::findOrFail($id);
        $wroletime=Wroletime::find($id);
        Wroletime::destroy($id);
       // $routeparam=$request->get('routeparam');
        Session::flash('flash_message', 'Wroletime deleted!');

        return redirect($this->paramT['baseroute'].'/?routeparam='.$wroletime->wroleunit_id);
    }
}
