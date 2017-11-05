<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Day;
use App\Daytype;
use Illuminate\Http\Request;
use Session;

class DaysController extends Controller
{

    protected $paramT= [
        'baseroute'=>'manager/days',
        'baseview'=>'manager.days', 
        'cim'=>'Napok',
    ];
    protected $valT=[
        'worker_id' => 'integer',
        //'datum' => 'required|date_format:mm-dd',
        'datum' => 'required|string',
        'note' => 'string'
    ];
    
    function __construct(Request $request){ 
 
        $this->paramT['id']=$request->route('id') ;
        //$this->paramT['getT']['parrent_id']=Input::get('parrent_id') ?? 0;
        $this->paramT['getT']['worker_id']=Input::get('worker_id') ?? 0;
    
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

        if (!empty($keyword)) {
            $days = Day::with('daytype')->where('daytype_id', 'LIKE', "%$keyword%")
				->orWhere('datum', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $days = Day::with('daytype')->paginate($perPage);
        }

        $data['list']=$days;
        return view('crudbase.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //$data = Day::get();
        $data['daytype']=Daytype::get()->pluck('name','id');
        $data['datum']='01-01';
        return view('crudbase.create' ,compact('data'));
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
        $request->ev=$request->ev ?? '0000';
        $requestData['datum']= $request->ev.'-'. $request->datum;
        Day::create($requestData);

        Session::flash('flash_message', 'Day added!');

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
        $data = Day::findOrFail($id);

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
        $data = Day::findOrFail($id);
        $data['id']=$id ;
        $data['datum']=substr($data['datum'],5);
        $data['daytype']=Daytype::get()->pluck('name','id');
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
        $this->validate($request,$this->valT);
        $requestData = $request->all();
        $request->ev=$request->ev ?? '0000';
        $requestData['datum']= $request->ev.'-'. $request->datum;
        $day = Day::findOrFail($id);
        $day->update($requestData);

        Session::flash('flash_message', 'Day updated!');

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
        Day::destroy($id);

        Session::flash('flash_message', 'Day deleted!');

        return redirect($this->paramT['baseroute']);
    }
}
