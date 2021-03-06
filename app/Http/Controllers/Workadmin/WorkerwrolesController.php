<?php

namespace App\Http\Controllers\Workadmin;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Wrole;

use App\Worker;
use App\Wroleunit;
use Illuminate\Http\Request;
use Session;

class WorkerwrolesController extends \App\Handler\MoController
{
use  \App\Handler\trt\crud\CrudWithSetfunc;
use  \App\Handler\trt\SetController;

protected $par= [ 
    'create_button'=>false,  
    'get_key'=>'wwrole', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
    'routes'=>['base'=>'workadmin/workerwroles','worker'=>'manager/worker'],//A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
    //'baseview'=>'workadmin.workerdays', //nem használt a view helyettesíti
    'view'=>'workadmin.workerwroles', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
    'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim'=>'Felhasználók munkarendjei',  
    'getT'=>['worker_id'=>'0','wrole_id'=>'0'],     
];
protected $base= [
    'search'=>false,
  'with'=>['worker_with_user','wrole'],
    'get'=>['wrole_id'=>null,'wwrole_redir'=>null,'worker_id'=>null], //pl:'w_id'=>null a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be 
    'obname'=>'\App\Workerwrole',   
];


protected $val= [
    'worker_id' => 'required|integer',
    'wrole_id' => 'required|integer',
    'start' => 'required|date',
    'end' => 'date',
    'note' => 'string|max:150'
  // 'usernote' => 'string|max:150'
];
public function index_set()
{
   
    $this->BASE['data']['wroles']=Wrole::get()->toarray();
    $this->BASE['data']['workers']=Worker::with('user')->get()->toarray();
    $this->BASE['data']['workers'][]=['id'=>0,'user'=>['name'=>'Mind']];
}

public function index_base(){
    $ob=$this->BASE['ob'];
    $perPage=$this->PAR['perpage'] ?? 50;
   
    $this->index_set();
    if(is_callable([$this->BASE['request'], 'get'])) {$keyword = $this->BASE['request']->get('search') ?? '';} 
    else{$keyword = '';}
    $with=$this->BASE['with'] ?? '';
    if ($with=='') {  
        $ob_base =$ob ;   
    } else {
        $ob_base = $ob->with($with);
    } 
    $worker_id=$this->PAR['getT']['worker_id'] ?? '0';
    if ($worker_id!='0') {  
        $ob_base =$ob_base->where('worker_id','=',$worker_id);   
    }
    if (empty($keyword)) {  
        $this->BASE['data']['list'] =$ob_base->paginate($perPage)->appends($this->PAR['getT']) ;   
    } else {
        $this->BASE['data']['list'] = $ob_base->where($this->get_searchT($keyword,'first'))
                        ->orWhere($this->get_searchT($keyword,'firstno'))
                        //->orderBy('id', 'desc')
                        ->paginate($perPage)->appends($this->PAR['getT']) ;
    }
    
}


public function create_set()
{
    $this->BASE['data']['workers']=Worker::with('user')->get()->toarray();
    $this->BASE['data']['workers'][]=['id'=>0,'user'=>['name'=>'Mind']];
}
 public function edit_set()
 {
    // $this->BASE['data']['wroleunits_all']=Wroleunit::get();
     $this->BASE['data']['wrole']=Wrole::get()->pluck('name','id');
 }

    public function addwrole()
    {
        $this->BASE['ob']->insert(
        [
        'worker_id' => $this->PAR['getT']['worker_id'], 
        'wrole_id' => $this->PAR['getT']['wrole_id'],
        'start' => \Carbon\Carbon::now()->format('Y-m-d'),
        ]);
        return  redirect(\MoHandF::url($this->PAR['routes']['base'], $this->PAR['getT']));  
   }
   /* public function delunit()
    {
        $this->BASE['id']=$id;
        $this->BASE['ob_res']= $this->BASE['ob']->destroy($id);
        return  redirect(\MoHandF::url($this->PAR['routes']['base'], $this->PAR['getT']));  
        /*
        $url=\MoHandF::url('manager/wroles/'.$this->PAR['getT']['wrole_id'].'/edit', $this->PAR['getT']);
        header("Location:$url");
        die(); 
         
    }*/
}
