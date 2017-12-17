<?php

namespace App\Http\Controllers\Workadmin;
use Illuminate\Support\Facades\View;
//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Worker;
use App\WorkerWrole;
use App\Day;
use Illuminate\Http\Request;
use Session;

class WorkerwroleController extends \App\Handler\MoController
{
    protected $paramT= [
        'baseroute'=>'workadmin/workerdays',
        'baseview'=>'workadmin.workerdays', 
        'crudview'=>'crudbase_2', 
        'cim'=>'Dolgozói napok',
        'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['w_id'], //a mocontroller automatikusan feltölti a getből a $this->paramT['getT']-be
        'get_post'=>['ev','ho'],//a mocontroller automatikusan feltölti a getből a $this->paramT['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'ob'=>'\App\Workerday',
    ];
    protected $task_paramT= [];
    protected $valT= [
        'worker_id' => 'required|integer',
        'daytype_id' => 'integer',
        'day' => 'integer|max:31',
        'datum' => 'date',
        'managernote' => 'string|max:150'
      //  'usernote' => 'string|max:150'
    ];
 


    public function index_set($request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
       
        $workerdayT=[];
        $data['daytype']=Daytype::get()->pluck('name','id');    
        $data['workers']=Worker::with('user')->get();
       // $dayT= Day::where([['datum',  'LIKE', $this->paramT['getT']['ev']."-".$this->paramT['getT']['ho']."%"],])->get();
        if(isset($this->paramT['getT']['w_id']) && $this->paramT['getT']['w_id']>0)
        {
            $workerdayT=$this->getWorkerday($this->paramT['getT']['w_id'],$this->paramT['getT']['ev'],$this->paramT['getT']['ho']);
            $calendar=new \App\Handler\Calendar;
            $calT=$calendar->getMonthDays($this->paramT['getT']['ev'],$this->paramT['getT']['ho']);
            $data['calendar']=\MoHandF::mergeAssoc($calT,$workerdayT);
        }
       // print_r($dayT);
      //  return view('crudbase.create');
        return view($this->paramT['baseview'].'.form', compact('data'));
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
        $requestData['datum']=$this->paramT['getT']['ev'].'-'.$this->paramT['getT']['ho'].'-'.$requestData['day'];
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
        $data = Workerday::with('worker')->findOrFail($id);
        $data['id']=$id ;
        $data['daytype']=Daytype::get()->pluck('name','id');
        return view($this->paramT['baseview'].'.edit_form', compact('data'));
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
        if(isset($requestData['day'])){
            $requestData['datum']=$this->paramT['getT']['ev'].'-'.$this->paramT['getT']['ho'].'-'.$requestData['day'];
        }
        
        $workerday = Workerday::findOrFail($id);
        $workerday->update($requestData);

        Session::flash('flash_message', 'Workerday updated!');

       // return redirect($this->paramT['baseroute']);
       return redirect(\MoHandF::url($this->paramT['baseroute'], $this->paramT['getT']));
//echo 'update';
    }

}
