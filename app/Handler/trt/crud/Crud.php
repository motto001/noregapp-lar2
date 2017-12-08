<?php

namespace App\Handler\trt\crud;
/*
use Illuminate\Support\Facades\View;
//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
*/
Trait Crud
{
   /**
    *  a  construktor által minden  view-el megosztott adatok
    */
    protected $PAR= [
     /*   
        'baseroute'=>'workadmin/workerdays',
        'baseview'=>'workadmin.workerdays', 
        'crudview'=>'crudbase_2', 
        'crudview_task'=>['index'=>'crudbase_2'], // task függvény vagy a setje felülírhatja vele a 'crudview'-et

        'getT'=>['a'=>'a']; //index_data használja beállítja ha nincs .
     */   
    ];
    protected $BASE= [
        /* 
         'view'=>'', //controler állítja be a $PAR alapján. Task függvények ezt használják!.
        'obname'=>'\App\Workerday',
        'perpage'=>50,      //index_data használja beállítja ha nincs 
        'search_column'=>[] //index_data->get_searchT használja  ha nincs: [['id', '>', "0"]] 
        'ob'=>null,      // használja: 
      */   
       ];
    protected $val= [
      //  'worker_id' => 'required|integer',
    ];
    protected $val_update= [];
/**
 * A BASE['search_column'] mezőkből  csinál  where tömböt. Ha $resmod = first csak az első elemmel tér vissza (keresés where)
 * Ha $resmod =firstno akkor az első elem nélkül tér vissza egyébként a teljes whre tömbel.
 * Ha nincs BASE['search_column'] akkor a $res=[['id', '>', "0"]] 
 */
    function get_searchT($keyword,$resmod='all'){
        $res=[];
        if(isset($this->BASE['search_column'])){
            if(!is_array($this->BASE['search_column'])){$this->BASE['search_column']=explode(',',$this->BASE['search_column']);}
            foreach($this->BASE['search_column'] as $key)
            {
                $res[]=[$key, 'LIKE', "%$keyword%"];
            }
            if($resmod='firstno'){ unset($res[0]);}
            else if($resmod='first'){$res=$res[0];}
            }
            if(empty($res)){$res[]=['id', '>', "0"];} 
    return $res;
    }

    public function index_data($ob,$keyword='')
    {
  
        $perPage=$this->PAR['perpage'] ?? 50;
        $getT=$this->PAR['getT'] ?? ['a'=>'a'];
        if (empty($keyword)) {  
            $workerdays =$ob->paginate($perPage)->appends($getT) ;   
        } else {
            $workerdays = $ob->where($this->get_searchT($keyword,'first'))
                            ->orWhere($this->get_searchT($keyword,'firstno'))
                            //->orderBy('id', 'desc')
			                ->paginate($perPage)->appends($getT) ;
        }  
        return $workerdays;
    }

    public function index(Request $request)
    {
        $obname=$this->BASE['obname'] ;
        $ob=new $obname();
        $keyword = $request->get('search') ?? '';
            $data=$this->index_data($ob,$keyword);
            $view=$this->PAR['crudview_task']['index'] ?? $this->PAR['crudview'];
            return view($this->BASE['view'].'index', compact('data'));
        
    }
  
    public function create()
    {
        $data=[];
        return view($this->BASE['view'].'create', compact('data'));
    }
    public function store(Request $request)
    {
        $this->validate($request,$this->valT );
        $requestData = $request->all();
        $obname=$this->BASE['obname'] ;
        $ob=new $obname();
        $ob->create($requestData);
        Session::flash('flash_message', trans('mo.itemadded'));
        return redirect(\MoHandF::url($this->paramT['baseroute'].'/create', $this->paramT['getT']));
    }

    public function edit($id)
    {  
        $data =$this->BASE['ob']->findOrFail($id);
        return view($this->BASE['view'].'edit', compact('data'));
    }


    public function update($id, Request $request)
    {
        $val=$this->val ?? $this->val_update;
        $this->validate($request,$val );
        $requestData = $request->all();
        $ob = $this->BASE['ob']->findOrFail($id);
        $ob->update($requestData);
        Session::flash('flash_message',  trans('mo.item_updated'));
       return redirect(\MoHandF::url($this->paramT['baseroute'], $this->paramT['getT']));

    }
    public function destroy($id)
    { 
        $this->BASE['ob']->destroy($id);
        Session::flash('flash_message', trans('mo.deleted'));
        return redirect(\MoHandF::url($this->paramT['baseroute'], $this->paramT['getT']));
    }

    public function show($id)
    {
       
        $data =$this->BASE['ob']->findOrFail($id);
        return view($this->BASE['view'].'show', compact('data'));
    } 
}