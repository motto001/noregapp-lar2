<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workerday;
use Illuminate\Http\Request;
use Session;

class WorkerdaysController extends Controller
{
    protected $paramT= [
        'baseroute'=>'workadmin/workerdays',
        'baseview'=>'workadmin.workerdays', 
        'cim'=>'Dolgozói napok',
    ];
    protected $valT= [
        'worker_id' => 'integer',
        'daytype_id' => 'integer',
        'datum' => 'required|date',
        'managernote' => 'string|max:150',
        'usernote' => 'string|max:150'
    ];
    function __construct(Request $request){
    
        $this->paramT['id']=$request->route('id') ;
        $this->paramT['parrent_id']=Input::get('parrent_id') ?? 0;
        $this->paramT['daytype_id']=Input::get('daytype_id') ?? 0;

        $this->paramT['route_param']='/?parrentid='.$this->paramT['parrent_id']
        .'&parrentid='.$this->paramT['parrent_id'];
      
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
        $where[]= ['id', '<>','0']; //hogx mindenképpen legyen where
        if($this->paramT['parrent_id']>0){$where[]= ['worker_id', '=', $this->paramT['parrent_id']];}
        if($this->paramT['daytype_id']>0){$where[]= ['daytype_id', '=', $this->paramT['daytype_id']];}

        if (!empty($keyword)) {
            $workerdays = Workerday::where($where )
				->orWhere('daytype_id', 'LIKE', "%$keyword%")
				->orWhere('datum', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('usernote', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workerdays = Workerday::where($where )
            ->paginate($perPage);
        } 

        $data['list']=$workerdays;
        return view('crudbase.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('crudbase.create');
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
        $this->validate($request,$this->valT );
        $requestData = $request->all();
        
        Workerday::create($requestData);

        Session::flash('flash_message', 'Workerday added!');

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
        $data = Workerday::findOrFail($id);

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
        $data = Workerday::findOrFail($id);
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
        $this->validate($request,$this->valT );
        $requestData = $request->all();
        
        $workerday = Workerday::findOrFail($id);
        $workerday->update($requestData);

        Session::flash('flash_message', 'Workerday updated!');

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
        Workerday::destroy($id);

        Session::flash('flash_message', 'Workerday deleted!');

        return redirect($this->paramT['baseroute']);
    }
}
