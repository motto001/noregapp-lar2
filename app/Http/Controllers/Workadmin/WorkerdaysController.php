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

class WorkerdaysController extends Controller
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;
    protected $PAR= [
        'baseroute'=>'workadmin/workerdays',
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'crudview'=>'crudbase_2', //ha tud majd formot és táblát generálni ez lesz a view
        'view'=>'workadmin.workerdays', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'cim'=>'Dolgozói napok',
        'getT'=>[],       
    ];
   
    protected $TPAR= [];
    protected $BASE= [
        'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['w_id'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
        'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Workerday',
        'ob'=>null,
        
    ];
    protected $TBASE= [];
    protected $val= [
        'worker_id' => 'required|integer',
        'daytype_id' => 'integer',
        'day' => 'integer|max:31',
        'datum' => 'date',
        'managernote' => 'string|max:150'
      //  'usernote' => 'string|max:150'
    ];
    protected $val_edit= [];

    function __construct(Request $request){

            $t = \Carbon::now();
            $this->BASE['get_post']['ev']= $t->year; 
            $this->BASE['get_post']['ho']=$t->month; 
            if(strlen($this->BASE['get_post']['ho'])<2){
                $this->BASE['get_post']['ho']='0'.$this->BASE['get_post']['ho'];
            }
           // $this->$PAR['view']=  $this->$PAR['baseview']; //a setTask() felülírja ha a $TPAR['task']['view'] meg van adva
            $this->setTask();
            $this->set_getT($request);
            $obname=$this->BASE['obname'];
            $this->BASE['ob']=new $obname();
            View::share('param',$this->PAR);
           }
    public function index_set($ob,$keyword,$getT,$perPage)
    {
          
        if($this->PAR['getT']['w_id']>0){$where[]= ['worker_id', '=', $this->PAR['getT']['w_id']];}
        else{$where[]= ['id', '<>','0']; }//hogx mindenképpen legyen where
    
        if (empty($keyword)) {  
            $list =$ob->with('worker','daytype')
                    ->where($where )
                    ->orderBy('id', 'desc')
                    ->paginate($perPage)->appends($getT) ;   
        } else {
            $list = $ob->where($this->get_searchT($keyword,'first'))
                        ->orWhere($this->get_searchT($keyword,'firstno'))
                        ->orderBy('id', 'desc')
			            ->paginate($perPage)->appends($getT) ;
        }  
 
        $data['years']=['2017','2018'];
        $data['list']=$list;
        $calendar=new \App\Handler\Calendar;
        $data['workers']=Worker::with('user')->get();
        $data['workers'][]=['name'=>'osszes worker','id'=>0,'user'=>['name'=>'összes']];
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

    public function create_set()
    {
       
        $workerdayT=[];
        $data['daytype']=Daytype::get()->pluck('name','id');    
        $data['workers']=Worker::with('user')->get();
     
        if(isset($this->PAR['getT']['w_id']) && $this->PAR['getT']['w_id']>0)
        {
            $workerdayT=$this->getWorkerday($this->PAR['getT']['w_id'],$this->PAR['getT']['ev'],$this->PAR['getT']['ho']);
            $calendar=new \App\Handler\Calendar;
            $calT=$calendar->getMonthDays($this->PAR['getT']['ev'],$this->PAR['getT']['ho']);
            $data['calendar']=\MoHandF::mergeAssoc($calT,$workerdayT);
        }

        return $data;
    }
//az egész store-t felül kell írni 
    public function store(Request $request)
    {
        $this->validate($request,$this->val );
        $requestData = $request->all();
        $requestData['datum']=$this->PAR['getT']['ev'].'-'.$this->PAR['getT']['ho'].'-'.$requestData['day'];
        $days = Workerday::select('id')->where([['datum', '=', $requestData['datum']],['worker_id', '=', $requestData['worker_id']]])->first();
        if(isset( $days->id) && $days->id>0){
            $this->update($days->id,$request);
        }
        else{
        Workerday::create($requestData);
        Session::flash('flash_message', 'Workerday added!');
       // echo 'store';
        return redirect(\MoHandF::url($this->PAR['baseroute'].'/create', $this->PAR['getT']));
        }
  
    }


    public function show_set($id)
    {
        $data = Workerday::findOrFail($id);

        return $data;
    }


    public function edit_set($id)
    {  
        $data = Workerday::with('worker')->findOrFail($id);
        $data['id']=$id ;
        $data['daytype']=Daytype::get()->pluck('name','id');
        return $data;
    }

    public function update_set($id,$valT,$request)
    { 
        $this->validate($request,$valT );
        $requestData = $request->all();
        if(isset($requestData['day'])){
            $requestData['datum']=$this->PAR['getT']['ev'].'-'.$this->PAR['getT']['ho'].'-'.$requestData['day'];
        }
        return $requestData;
    }
}
