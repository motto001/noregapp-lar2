<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Timetype;
use App\Wroletime;
use App\Wroleunit;
use Illuminate\Http\Request;
use Session;

class WroletimesController extends Controller
{
    use \App\Handler\trt\crud\CrudWithSetfunc;
    use  \App\Handler\trt\SetController;
    protected $PAR= [
        'baseroute'=>'manager/wroletimes',
        'view'=>'manager.wrunit_times', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        'crudview'=>'crudbase_2', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim'=>'Műszak idők',
        'getT'=>['wru'=>'0'],   
        'search'=>false,   
    ];
   
    protected $TPAR= [];
    protected $BASE= [
        //'search_column'=>'daytype_id,datum,managernote,usernote',
        'get'=>['wru'=>'0','wruvissza'=>null], //Ha a wrolunitból hvjuk a wruvissza true lesz, a store az update és a delete visszaírányít az aktuális wroleunitra.mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be
        'get_post'=>[],//a mocontroller automatikusan feltölti a getből a $this->PAR['getT']-be ha van ilyen kulcs a postban azzal felülírja
        'obname'=>'\App\Wroletime',
        'ob'=>null,
        
    ];
    protected $TBASE= [];
    protected $val= [
        'wroleunit_id' => 'required|integer',
        'timetype_id' => 'required|integer',
        'start' => 'required|date_format:H:i',
        'end' => 'date_format:H:i',
        'hour' => 'required|integer|max:24',
        'managernote' => 'string|max:200|nullable',
        'workernote' => 'string|max:200|nullable',
        'pub' => 'integer'
    ];
    protected $val_edit= [];
    function __construct(Request $request){
        
                $this->setTask();
                $this->set_getT($request);
                $obname=$this->BASE['obname'];
                $this->BASE['ob']=new $obname();
                View::share('param',$this->PAR);
               }

    public function index_set($ob,$keyword,$getT,$perPage)
    {
        if(isset($this->PAR['task']) && !empty($this->PAR['task']) )
        {
            $task=$this->PAR['task'];
            return $this->$task();
         }
          
        if($this->PAR['getT']['wru']>0){$where[]= ['wroleunit_id', '=', $this->PAR['getT']['wru']];}
        else{$where[]= ['id', '<>','0']; }//hogx mindenképpen legyen where
    
            $list =$ob->with('timetype','wroleunit')
                    ->where($where )
                    ->orderBy('id', 'desc')
                    ->paginate($perPage)->appends($getT) ;   
         
      // print_r($this->PAR['getT']);
        $data['list']=$list;
        $data['wroleunit']=Wroleunit::get();
        return $data;
    }
  

    public function create_set()
    {
       
        $wroletime = Wroletime::get();
        $wroletime['wroleunit']= Wroleunit::get();
        $wroletime['timetype']= Timetype::pluck('name','id');
        $wroletime['wroleunit_id']= 0;

        return $wroletime;
    }

    public function store(Request $request)
    {
        
        $requestData =$this->store_set($request);
        $this->BASE['ob']->create($requestData);
        Session::flash('flash_message', trans('mo.itemadded'));
        if($this->PAR['getT']['wruvissza']){
            return redirect('/manager/wroleunits/'.$this->PAR['getT']['wru'].'/edit');
        }else{
            return redirect(\MoHandF::url($this->PAR['baseroute'].'/create', $this->PAR['getT']));
        }
        
    }


    public function edit_set($id)
    {  
        $data = Wroletime::findOrFail($id);
        $data['timetype']= Timetype::pluck('name','id');
        $data['id']=$id ;
        return $data;
    }
    public function update($id, Request $request)
    {
        $valT=$this->val_update ?? $this->val;
        $requestData = $this->update_set($id,$valT,$request);
        $ob = $this->BASE['ob']->findOrFail($id);
        $ob->update($requestData);
        Session::flash('flash_message',  trans('mo.item_updated'));
        if($this->PAR['getT']['wruvissza']){
            return redirect('/manager/wroleunits/'.$this->PAR['getT']['wru'].'/edit');
        }else{   
            return redirect(\MoHandF::url($this->PAR['baseroute'], $this->PAR['getT']));
        }
    }
    public function del()
    { 
        $id=Input::get('id');
        $this->destroy_set($id);
        Session::flash('flash_message', trans('mo.deleted'));
        return redirect('/manager/wroleunits/'.$this->PAR['getT']['wru'].'/edit');
    }

    public function destroy($id)
    { 
        $this->destroy_set($id);
        Session::flash('flash_message', trans('mo.deleted'));
        if($this->PAR['getT']['wruvissza']){
            return redirect('/manager/wroleunits/'.$this->PAR['getT']['wru'].'/edit');
        }else{  
        return redirect(\MoHandF::url($this->PAR['baseroute'], $this->PAR['getT']));
        }
    }
}
