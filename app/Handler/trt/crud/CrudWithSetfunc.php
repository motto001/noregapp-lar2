<?php

namespace App\Handler\trt\crud;
use Illuminate\Http\Request;
use Session;
//use App\Http\Requests;
/*
use Illuminate\Support\Facades\View;
//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;


*/
Trait CrudWithSetfunc
{

     /* a  construktor által minden  view-el megosztott adatok
    protected $PAR= [
      
        'baseroute'=>'workadmin/workerdays',
        'baseview'=>'workadmin.workerdays', 
        'crudview'=>'crudbase_2', 
        'crudview_task'=>['index'=>'crudbase_2'], // task függvény vagy a setje felülírhatja vele a 'crudview'-et

        'getT'=>[]; //index_data használja, pagernek kell, beállítja ha nincs. Ha máshova is kell . Használjuk a Handlr\trt\setControllert
       
    ];
    protected $BASE= [
    /* 
        'view'=>'', //controler állítja be a $PAR alapján. Task függvények ezt használják!.
        'obname'=>'\App\Workerday',
        'perpage'=>50,      //index_data használja beállítja ha nincs 
        'search_column'=>[] //index_data->get_searchT használja  ha nincs: [['id', '>', "0"]] 
        'ob'=>null,      // construktornak kell előállítani 
      
    ];
    protected $val= [
      //  'worker_id' => 'required|integer',
    ];
    protected $val_update= [];
    */ 
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

    public function index_set($ob,$keyword,$getT,$perPage)
    {
    
        if (empty($keyword)) {  
            $dat =$ob->paginate($perPage)->appends($getT) ;   
        } else {
            $dat = $ob->where($this->get_searchT($keyword,'first'))
                            ->orWhere($this->get_searchT($keyword,'firstno'))
                            //->orderBy('id', 'desc')
			                ->paginate($perPage)->appends($getT) ;
        }  
        return $dat;
    }

    public function index(Request $request)
    {
            $ob=$this->BASE['ob'];
            $perPage=$this->PAR['perpage'] ?? 50;
            $getT=$this->PAR['getT'] ?? ['a'=>'a'];
            $keyword = $request->get('search') ?? '';
            $data=$this->index_set($ob,$keyword,$getT,$perPage);
            return view($this->PAR['view'].'.index', compact('data'));
        
    }
  
    public function create_set()
    { $data=[]; return $data;}

    public function create()
    {
        $data=$this->create_set();
        return view($this->PAR['view'].'.create', compact('data'));
    }

    public function store_set($request)
    { 
        $this->validate($request,$this->valT );
        $requestData = $request->all();
        return $requestData;
    }
    public function store(Request $request)
    {
        
        $requestData =$this->store_set($request);
        $this->BASE['ob']->create($requestData);
        Session::flash('flash_message', trans('mo.itemadded'));
        return redirect(\MoHandF::url($this->PAR['baseroute'].'/create', $this->PAR['getT']));
    }
    public function edit_set($id)
    { 
        $data =$this->BASE['ob']->findOrFail($id);
        return $data;
    }
    public function edit($id)
    {  
        $data =$this->edit_set($id);
        return view($this->PAR['view'].'.edit', compact('data'));
    }

    public function update_set($id,$valT,$request)
    { 
        $this->validate($request,$valT );
        $requestData = $request->all();
        return $requestData;
    }
    public function update($id, Request $request)
    {
        $valT=$this->val_update ?? $this->val;
        $requestData = $this->update_set($id,$valT,$request);
       
        $this->BASE['ob']->update($requestData);
        Session::flash('flash_message',  trans('mo.item_updated'));
       return redirect(\MoHandF::url($this->PAR['baseroute'], $this->PAR['getT']));

    }

    public function destroy_set($id)
    { $this->BASE['ob']->destroy($id);}

    public function destroy($id)
    { 
        $this->destroy_set($id);
        Session::flash('flash_message', trans('mo.deleted'));
        return redirect(\MoHandF::url($this->PAR['baseroute'], $this->PAR['getT']));
    }
    public function show_set($id)
    {  
        $data =$this->BASE['ob']->findOrFail($id);
        return $data;
    }
    public function show($id)
    {     
        $data =$this->show_set($id);
        return view($this->PAR['view'].'.show', compact('data'));
    } 
}