<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Workersfull;
use App\User;
use App\Wrole;
use App\Timeframe;
use App\Status;
use App\Workertype;
use App\Workergroup;

use Illuminate\Http\Request;
use Session;

class WorkersfullController extends Controller
{

    protected $paramT= [
        'baseroute'=>'manager/workersfull',
        'baseview'=>'manager.workersfull', 
        'cim'=>'Dolgozó',
];

    protected $valT= [
    'fullname' => 'required|max:200',
    'cim' => 'required|max:200',
    'tel' => 'max:50|nullable',
    'birth' => 'required|date',
    'ado' => 'string|max:50|nullable',
    'tb' => 'string|max:50|nullable',
    'start' => 'required|date',
    'end' => 'date|nullable',
    'note' => 'date|nullable',
    'pub' => 'integer'
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

        if (!empty($keyword)) {
            $data2 = Workersfull::where('user_id', 'LIKE', "%$keyword%")
				->orWhere('wrole_id', 'LIKE', "%$keyword%")
				->orWhere('status_id', 'LIKE', "%$keyword%")
				->orWhere('workertype_id', 'LIKE', "%$keyword%")
				->orWhere('workergroup_id', 'LIKE', "%$keyword%")
				->orWhere('salary', 'LIKE', "%$keyword%")
				->orWhere('salary_type', 'LIKE', "%$keyword%")
				->orWhere('position', 'LIKE', "%$keyword%")
				->orWhere('foto', 'LIKE', "%$keyword%")
				->orWhere('fullname', 'LIKE', "%$keyword%")
				->orWhere('cim', 'LIKE', "%$keyword%")
				->orWhere('tel', 'LIKE', "%$keyword%")
				->orWhere('birth', 'LIKE', "%$keyword%")
				->orWhere('ado', 'LIKE', "%$keyword%")
				->orWhere('tb', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $data2 = Workersfull::paginate($perPage);
        }
        $data['list']=$data2;
        return view('crudbase.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        $data = Workersfull::get();
        $data['user']=User::get()->pluck('name','id');
        $data['wrole']=Wrole::get()->pluck('name','id');
        $data['base_timeframe']=Timeframe::get(['id','name'])->toarray();
        $data['checked_timeframe']=[1];
        $data['status']=Status::get()->pluck('name','id');
        $data['workertype']=Workertype::get()->pluck('name','id');
        $data['workergroup']=Workergroup::get()->pluck('name','id');

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
        $this->validate($request,$this->valT);
        $requestData = $request->all();
        
       $datas= Workersfull::create($requestData);
       $datas->timeframe()->sync($request->timeframe_id);
        Session::flash('flash_message', 'Workersfull added!');

        return redirect('manager/workersfull');
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
        $data = Workersfull::findOrFail($id);

        return view('manager.workersfull.show', compact('workersfull'));
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
        $data= Workersfull::with(['timeframe'])->findOrFail($id);

        $data['user']=User::get()->pluck('name','id');
        $data['wrole']=Wrole::get()->pluck('name','id');
        $data['base_timeframe']=Timeframe::get(['id','name'])->toarray();
        foreach($data->timeframe as $item){
            
            $checked[] =  $item->id;
        }
        $data['checked_timeframe']=$checked;
        $data['status']=Status::get()->pluck('name','id');
        $data['workertype']=Workertype::get()->pluck('name','id');
        $data['workergroup']=Workergroup::get()->pluck('name','id');
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
        
        $data = Workersfull::findOrFail($id);
        $data->update($requestData);

        Session::flash('flash_message', 'Workersfull updated!');

        return redirect('manager/workersfull');
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
        Workersfull::destroy($id);

        Session::flash('flash_message', 'Workersfull deleted!');

        return redirect('manager/workersfull');
    }
}
