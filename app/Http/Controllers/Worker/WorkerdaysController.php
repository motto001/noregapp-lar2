<?php

namespace App\Http\Controllers\Worker;
use Illuminate\Support\Facades\View;
//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Handler\MoController;

use App\Workerday;
use App\Workerwrole;
use App\Workertime;
use App\Worker;
use App\Wrole;
use App\Wroleunit;
use App\Daytype;
use App\Day;
use Illuminate\Http\Request;
use Session;
//use Carbon\Carbon;
class WorkerdaysController extends MoController
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;
    protected $par= [
        //'baseroute'=>'workadmin/workerdays',
        'routes'=>['base'=>'worker/workerdays','worker'=>'manager/worker'],
        //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
        'view'=>'worker.workerdays', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Dolgozói napok',
        'getT'=>[],       
    ];
  
    protected $base= [
        'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['ev'=>null,'ho'=>null], //a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
       // 'get_post'=>['ev'=>null,'ho'=>null],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Workerday',
        'ob'=>null,
        'func'=>[  'set_task', 'set_getT','set_date', 'set_redir','set_routes','set_ob'],
        'with'=>['worker','daytype'],
    ];

    protected $val= [
      //  'worker_id' => 'required|integer',
        'daytype_id' => 'integer',
        'wish_id' => 'integer',
        'day' => 'integer|max:31',
        'datum' => 'date',
        'managernote' => 'string|max:150'
      //  'usernote' => 'string|max:150'
    ];
    protected $val_edit= [];

    function set_date(){

            $t = \Carbon::now();
           // $this->BASE['get_post']['ev']= $t->year; 
           // $this->BASE['get_post']['ho']=$t->month; 
           $this->BASE['data']['ev']=$this->PAR['getT']['ev'] ?? $t->year;
           $this->BASE['data']['ho']=$this->PAR['getT']['ho'] ?? $t->month;
            if(strlen($this->BASE['data']['ho'])<2){
                $this->BASE['data']['ho']='0'.$this->BASE['data']['ho'];
            }
           }
    public function index_set()
    {
        //$dt = Carbon::create($year, $month , 1, 0);
        $user_id=\Auth::user()->id;
        $worker_id=Worker::select('id')->where('user_id','=',$user_id)->first()->id;
       
        $where[]= ['id', '=', $worker_id]; 
        $ob=$this->BASE['ob'];
        $perPage=$this->PAR['perpage'] ?? 50;
        $getT=$this->PAR['getT'] ?? ['a'=>'a'];
        $data['daytype']=Daytype::get()->pluck('name','id');
         $workerdayT=$this->getWorkerday($worker_id,$this->BASE['data']['ev'],$this->BASE['data']['ho']);
         $calendar=new \App\Handler\Calendar;
         $calT=$calendar->getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']);
         $data['calendar']=\MoHandF::mergeAssoc($calT,$workerdayT);
         $data['years']=['2017','2018','2019'];

        $wrole_id=$this->getWrole_id('2018-11-21',$worker_id);
        //echo $wrole_id;
        $wroleunit_id= $this->getWroleunit_id('2018-11-21',$wrole_id); 
        //echo $wroleunit_id;

        // $data['list']=$list;
        /*
         foreach( $data['calendar'] as $datum=>$dataT)
         {
            $wrtimes=[];
           $wrole_id=$this->getWrole_id($datum,$worker_id) ?? 2 ;
         $wroleunit_id= $this->getWroleunit_id($datum,$wrole_id); 
            $wrtimes= Workertime::where('worker_id','=',$worker_id)
            ->where('datum','=',$datum)
            ->where('pub','=',0)->get(); 
         //   echo $wrole_id.'-----'.$wrole_id;
      $data['calendar'][$datum]['wrole_id']=$wrole_id;
      $data['calendar'][$datum]['wrunit_id']=1;      
        // $data['calendar'][$datum]['wrtimes']=$wrtimes;
         }*/
 
         $this->BASE['data']= array_merge($this->BASE['data'],$data);    
 
    }
    public function getWorkerday($worker_id,$ev,$ho)
    {
        $res=[];
        //-----------------------
        $dayT= Day::where('datum',  'LIKE', $ev."-".$ho."%")
            ->orwhere('datum',  'LIKE', "0000-".$ho."%")
            ->get();

        foreach($dayT as $day) 
        {$res[$day->datum]=['datatype'=>'day','datum'=>$day->datum,'id'=>$day->id,'daytype_id'=>$day->daytype_id,'wish_id'=>1];}  
        //------------------------
        $workerdayT= Workerday::where([
            ['worker_id', '=', $worker_id],
            ['datum',  'LIKE', $ev."-".$ho."%"],
            ])->get(); 
            foreach($workerdayT as $day) 
            {$res[$day->datum]=['datatype'=>'workerday','datum'=>$day->datum,'id'=>$day->id,'daytype_id'=>$day->daytype_id,'wish_id'=>$day->wish_id];
            
            }  
   //   print_r($worker_id);   
     return $res;    

    }

 public function getWrole_id($datum,$worker_id){
    
   $wrole= Workerwrole::where('worker_id','=',$worker_id)
   ->where('start','<',$datum)
   ->where('end','>',$datum)
   ->orWhere('end','=',null)
   ->orderBy('id','desc')
   ->first(); 
   $wrole_id = $wrole->wrole_id ?? 0;
   return  $wrole_id;
 }
 public function getWroleunit_id($datum,$wrole_id){
    $wroleunit_id=0;  
    //if($wrole_id!=2){
    $wrole= Wrole::with('wroleunit')->find($wrole_id);
    $wroleunits=$wrole->wroleunit;
    $longT=['hét'=>7,'nap'=>1];
    $long=0;
echo '----'.$datum.'----';
//print_r($wrole);
   $start=$wrole->start;
   //$actualstart=\Carbon::createFromFormat('Y-m-d',$start)->toDateString();
   $actualstart=\Carbon::createFromFormat('Y-m-d',$start);
  //echo $start.'----'.$datum.'----'; 
  
  //if($actualstart<$datum){echo $start;}
$oszlong=0;
print_r($wroleunits);
  foreach($wroleunits as $wroleunit){
   
       $longvalue=$longT[$wroleunit->unit];
       echo $longvalue.'----'.$wroleunit->unit;          
       $long=$longvalue*$wroleunit->long;
       $oszlong+=$long;
    }
  echo $oszlong;
  while($actualstart<=$datum)
   {
     
    $actualstart->addDays(10);
  
    }
    //echo $actualstart; 
  
  // return $wroleunit_id;
} 
public function getWroleTimes($wroleunit_id){
  

}

public function edit_set()
{

    $user_id=\Auth::user()->id;
    $worker_id=Worker::select('id')->where('user_id','=',$user_id)->first()->id;
   
    $where[]= ['id', '=', $worker_id]; 
    $ob=$this->BASE['ob'];
    $perPage=$this->PAR['perpage'] ?? 50;
    $getT=$this->PAR['getT'] ?? ['a'=>'a'];
      
     $list =$ob->with('worker','daytype')
                 ->where($where )
                 ->orderBy('id', 'desc')
                 ->paginate($perPage)->appends($getT) ;   
     
     $workerdayT=$this->getWorkerday($worker_id,$this->BASE['data']['ev'],$this->BASE['data']['ho']);
     $calendar=new \App\Handler\Calendar;
     $calT=$calendar->getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']);
     $data['calendar']=\MoHandF::mergeAssoc($calT,$workerdayT);
     $data['years']=['2017','2018'];
     $data['list']=$list;
     $data['daytype']=Daytype::get()->pluck('name','id');   
     $calendar=new \App\Handler\Calendar;
     $data['workers']=Worker::with('user')->get();
     $data['workers'][]=['name'=>'osszes worker','id'=>0,'user'=>['name'=>'összes']];
     $data['userid']=$user_id;
     $this->BASE['data']= array_merge($this->BASE['data'],$data); 


}

/*
    public function create_set()
    {
       
        $workerdayT=[];
        $data['daytype']=Daytype::get()->pluck('name','id');    
        $data['workers']=Worker::with('user')->get();
     
        if(isset($this->PAR['getT']['w_id']) && $this->PAR['getT']['w_id']>0)
        {

            $workerdayT=$this->getWorkerday($this->PAR['getT']['w_id'],$this->BASE['data']['ev'],$this->BASE['data']['ho']);
            $calendar=new \App\Handler\Calendar;
            $calT=$calendar->getMonthDays($this->BASE['data']['ev'],$this->BASE['data']['ho']);
            $data['calendar']=\MoHandF::mergeAssoc($calT,$workerdayT);
        }

        $this->BASE['data']= array_merge($this->BASE['data'],$data);
    }
    */
//az egész store-t felül kell írni 
    public function store(Request $request)
    {
        $this->validate($request,$this->val );
        $this->BASE['data'] = $request->all();
        $user_id=\Auth::user()->id;
        $worker_id=Worker::select('id')->where('user_id','=',$user_id)->first()->id;
      //  echo $user_id.'------'. $worker_id;
        $this->BASE['data']['worker_id']=$worker_id;
      //  $this->BASE['data']['datum']=$this->BASE['data']['ev'].'-'.$this->BASE['data']['ho'].'-'.$requestData['day'];
        $days = Workerday::select('id')->where([['datum', '=', $this->BASE['data']['datum']],['worker_id', '=', $worker_id]])->first();
      
      //  $funcT=$this->TBASE['store']['task_func'] ?? ['store_set'];
      //  $this->call_func($funcT);
        
        if(isset( $days->id) && $days->id>0){
            $this->BASE['ob']=$this->BASE['ob']->findOrFail($days->id);
            $this->BASE['ob']->update($this->BASE['data']);
        }
        else{
            $this->BASE['ob']->create($this->BASE['data']);
        }

        Session::flash('flash_message', trans('mo.itemadded'));
        if(method_exists($this, 'store_redirect')) {return $this->store_redirect();}  
        else{return $this->base_redirect();}



  
    }
    public function del()
    { 
        $id=Input::get('id');

        $this->BASE['ob']=$this->BASE['ob']->findOrFail($id);
        $daytype_id= $this->BASE['ob']->daytype_id;
        $this->BASE['ob']->update(['wish_id'=>$daytype_id]);

       // $this->destroy($id);
       // Session::flash('flash_message', trans('mo.deleted'));
        //return redirect('/manager/wroleunits/'.$this->PAR['getT']['wru_id'].'/edit');
       return $this->base_redirect();
    }

}
