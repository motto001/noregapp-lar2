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
use App\Day;
use Illuminate\Http\Request;
use Session;

class WorkerdaysController extends \App\Handler\MoController
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
    protected $val_editT= [];

    function construct_baseval(){  $t = \Carbon::now();
        $this->paramT['baseval']['ev']= $t->year; 
        $this->paramT['baseval']['ho']=$t->month; 
        if(strlen($this->paramT['baseval']['ho'])<2){
            $this->paramT['baseval']['ho']='0'.$this->paramT['baseval']['ho'];
        }}

    public function index_data($request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $where[]= ['id', '<>','0']; //hogx mindenképpen legyen where
        if($this->paramT['getT']['w_id']>0){$where[]= ['worker_id', '=', $this->paramT['getT']['w_id']];}
       // if($this->paramT['getT']['daytype_id']>0){$where[]= ['daytype_id', '=', $this->paramT['daytype_id']];}

        if (!empty($keyword)) {
            $workerdays = Workerday::with('worker','daytype')
                ->where($where )
                //->orWhere($this->get_orwhereT($keyword))
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
       // $data['calendar']=$calendar->getMonthDays($this->paramT['getT']['ev'],$this->paramT['getT']['ho']);
       // $data['daytype']=Daytype::get()->pluck('name','id');
        $data['userid']=0;
        return $data;
    }
    public function getWorkerday($worker_id,$ev,$ho)
    {
        $res=[];
        $dayT= Day::where('datum',  'LIKE', $ev."-".$ho."%")
            ->orwhere('datum',  'LIKE', "0000-".$ho."%")
            ->get();

        foreach($dayT as $day) 
        {$res[$day->datum]=['datum'=>$day->datum,'id'=>$day->id,'daytype_id'=>$day->daytype_id,];}  

        $workerdayT= Workerday::where([
            ['worker_id', '=', $worker_id],
            ['datum',  'LIKE', $ev."-".$ho."%"],
            ])->get(); 
            foreach($workerdayT as $day) 
            {$res[$day->datum]=['datum'=>$day->datum,'id'=>$day->id,'daytype_id'=>$day->daytype_id,];}  
         
     return $res;    


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
