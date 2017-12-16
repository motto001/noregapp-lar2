<?php

namespace App\Handler\trt\crud;
use Illuminate\Http\Request;
use Session;

Trait CrudWithSetfunc
{

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

    public function index_set(){}
    public function index(Request $request)
    {
            $ob=$this->BASE['ob'];
            $perPage=$this->PAR['perpage'] ?? 50;
            $getT=$this->PAR['getT'] ?? ['a'=>'a'];
            $keyword = $request->get('search') ?? '';
            if (empty($keyword)) {  
                $this->BASE['data'] =$ob->paginate($perPage)->appends($getT) ;   
            } else {
                $this->BASE['data'] = $ob->where($this->get_searchT($keyword,'first'))
                                ->orWhere($this->get_searchT($keyword,'firstno'))
                                //->orderBy('id', 'desc')
                                ->paginate($perPage)->appends($getT) ;
            }  
            $funcT=$this->TBASE['index']['func'] ?? ['index_set'];
            $this->call_func($funcT);
            $data= $this->BASE['data'];
            return view($this->PAR['view'].'.index', compact('data'));
        
    }
  
    public function create_set() {}
    public function create()
    {    
        $funcT=$this->TBASE['create']['func'] ?? ['create_set'];
        $this->call_func($funcT);
        $data=$this->BASE['data'];
        return view($this->PAR['view'].'.create', compact('data'));
    }

    public function store_set(){ }
    public function store(Request $request)
    {
        
        $this->validate($request,$this->val );
        $this->BASE['data'] = $request->all();
        $funcT=$this->TBASE['store']['func'] ?? ['store_set'];
        $this->call_func($funcT);
        $this->BASE['ob']->create($this->BASE['data']);
        Session::flash('flash_message', trans('mo.itemadded'));
        return redirect(\MoHandF::url($this->PAR['route'].'/create', $this->PAR['getT']));
    }

    public function edit_set($id) {}
    public function edit($id)
    {  
        $this->BASE['id']=$id;
        $this->BASE['data'] =$this->BASE['ob']->findOrFail($id);
        $funcT=$this->TBASE['edit']['func'] ?? ['edit_set'];
        $this->call_func($funcT);
        $data=$this->BASE['data'];
        return view($this->PAR['view'].'.edit', compact('data'));
    }

    public function update_set(){}
    public function update($id, Request $request)
    {
        $this->BASE['id']=$id;
        $valT=$this->val_update ?? $this->val;

        $this->validate($request,$valT );
        $requestData = $request->all();
        $this->BASE['data'] = $request->all();

        $funcT=$this->TBASE['update']['func'] ?? ['update_set'];
        $this->call_func($funcT);

        $ob = $this->BASE['ob']->findOrFail($id);
        $ob->update($this->BASE['data']);
        Session::flash('flash_message',  trans('mo.item_updated'));
      return redirect(\MoHandF::url($this->PAR['route'], $this->PAR['getT']));

    }

    public function destroy_set($id){}
    public function destroy($id)
    { 
        $this->BASE['id']=$id;
        $this->BASE['ob']->destroy($id);
        $funcT=$this->TBASE['destroy']['func'] ?? ['destroy_set'];
        $this->call_func($funcT);
        Session::flash('flash_message', trans('mo.deleted'));
        return redirect(\MoHandF::url($this->PAR['route'], $this->PAR['getT']));
    }

    public function show_set($id){}
    public function show($id)
    {   
        $this->BASE['id']=$id;  
        $this->BASE['data'] =$this->BASE['ob']->findOrFail($id);

        $funcT=$this->TBASE['show']['func'] ?? ['show_set'];
        $this->call_func($funcT);

        $data=$this->BASE['data'];
        return view($this->PAR['view'].'.show', compact('data'));
    } 
}