<?php

namespace App\Http\Controllers\Workadmin;
use Illuminate\Support\Facades\View;
//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workerday;
use App\Worker;
use App\Daytype;
use Illuminate\Http\Request;
use Session;

class WorkerdaysController extends Controller
{
    protected $paramT= [
        'baseroute'=>'workadmin/workerdays',
        'baseview'=>'workadmin.workerdays', 
        'crudview'=>'crudbase_1', 
        'cim'=>'Dolgozói napok'
      
    ];

    protected $valT= [
        'worker_id' => 'required|integer',
        'daytype_id' => 'integer',
        'datum' => 'required|date',
        'managernote' => 'string|max:150',
        'usernote' => 'string|max:150'
    ];
    function __construct(Request $request){
    
        $this->paramT['id']=$request->route('id') ;//day id

        $this->paramT['getT']['w_id']=Input::get('w_id') ?? 0; //worker id
        $this->paramT['getT']['w_id']= $request->input('worker_id', $this->paramT['getT']['w_id']) ;
        $t = \Carbon::now();
        $this->paramT['getT']['ev']=Input::get('ev') ?? $t->year; 
        $this->paramT['getT']['ho']=Input::get('ho') ?? $t->month; 

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
        $perPage = 2;
        $where[]= ['id', '<>','0']; //hogx mindenképpen legyen where
        if($this->paramT['getT']['w_id']>0){$where[]= ['worker_id', '=', $this->paramT['getT']['w_id']];}
       // if($this->paramT['getT']['daytype_id']>0){$where[]= ['daytype_id', '=', $this->paramT['daytype_id']];}

        if (!empty($keyword)) {
            $workerdays = Workerday::with('worker','daytype')
                ->where($where )
				->orWhere('daytype_id', 'LIKE', "%$keyword%")
				->orWhere('datum', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
                ->orWhere('usernote', 'LIKE', "%$keyword%")
                ->orderBy('id', 'desc')
				->paginate($perPage)->appends($this->paramT['getT']) ;
        } else {
            $workerdays = Workerday::with('worker','daytype')
            ->where($where )
            ->orderBy('id', 'desc')
            ->paginate($perPage)->appends($this->paramT['getT']) ;
        } 
        $data['years']=['2017','2018'];
        $data['list']=$workerdays;
        $calendar=new \App\Handler\Calendar;
        $data['workers']=Worker::with('user')->get();
        $data['workers'][]=['name'=>'osszes worker','id'=>0,'user'=>['name'=>'összes']];
       // print_r( $data['workers']);
        $data['calendar']=$calendar->getDays($this->paramT['getT']['ev'],$this->paramT['getT']['ho']);
       // $data['daytype']=Daytype::get()->pluck('name','id');
        $data['userid']=0;
        return view($this->paramT['crudview'].'.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
       // $data = Days::get();
        $data['daytype']=Daytype::get()->pluck('name','id');
        
        $data['workers']=Worker::with('user')->get();
        
        $calendar=new \App\Handler\Calendar;
        $data['calendar']=$calendar->getDays($this->paramT['getT']['ev'],$this->paramT['getT']['ho']);
        
      //  return view('crudbase.create');
        return view($this->paramT['crudview'].'.create', compact('data'));
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
        $days = Workerday::select('id')->where([['datum', '=', $requestData['datum']],['worker_id', '=', $requestData['worker_id']]])->first();
        if(isset( $days->id) && $days->id>0){
            //$request=new Requests();
            $this->update($days->id,$request);
        }
        else{
        Workerday::create($requestData);
        Session::flash('flash_message', 'Workerday added!');
       // echo 'store';
        return redirect(\MoHandF::url($this->paramT['baseroute'].'/create', $this->paramT['getT']));
        }
       //return redirect($this->paramT['baseroute'].'/create');
      // $this->create();
      
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
        $this->validate($request,$this->valT );
        $requestData = $request->all();
        
        $workerday = Workerday::findOrFail($id);
        $workerday->update($requestData);

        Session::flash('flash_message', 'Workerday updated!');

       // return redirect($this->paramT['baseroute']);
       return redirect(\MoHandF::url($this->paramT['baseroute'].'/create', $this->paramT['getT']));
//echo 'update';
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
