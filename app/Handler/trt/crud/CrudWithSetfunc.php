<?php

namespace App\Handler\trt\crud;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Input;
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
    public function index_set(){ 
      //  
     }
    public function index_base(){
        $ob=$this->BASE['ob'];
        $perPage=$this->PAR['perpage'] ?? 50;
        $getT=$this->PAR['getT'] ?? ['a'=>'a'];
        $keyword = $this->BASE['request']->get('search') ?? '';
        $with=$this->BASE['with'] ?? '';
        if ($with=='') {  
            $ob_base =$ob ;   
        } else {
            $ob_base = $ob->with($with);
        } 

        if (empty($keyword)) {  
            $this->BASE['data']['list'] =$ob_base->paginate($perPage)->appends($getT) ;   
        } else {
            $this->BASE['data']['list'] = $ob_base->where($this->get_searchT($keyword,'first'))
                            ->orWhere($this->get_searchT($keyword,'firstno'))
                            //->orderBy('id', 'desc')
                            ->paginate($perPage)->appends($getT) ;
        }
        
    }
    public function index(Request $request)
    {
        $task=Input::get('task') ?? \Route::getCurrentRoute()->getActionMethod();
        if($task!= \Route::getCurrentRoute()->getActionMethod()) {return $this->$task();}

            $funcT=$this->TBASE['index']['task_func'] ?? ['index_set','index_base'];
            $this->call_func($funcT);
          //  $data= $this->BASE['data'];

           if(method_exists($this, 'index_view')) {return  $this->index_view();}  
            else{return $this->base_view('index');}
       // return  \MoViewF::view( $this->PAR['view'].'.index',$data);
            
    }
  
    public function create_set() {}
    public function create()
    {    
        $funcT=$this->TBASE['create']['task_func'] ?? ['create_set'];
        $this->call_func($funcT);
       
        if(method_exists($this, 'create_view')) {return  $this->create_view();}  
        else{return $this->base_view('create');}
    }

    public function store_set(){ }
    public function store(Request $request)
    {
        
        $this->validate($request,$this->val );
        $this->BASE['data'] = $request->all();
        $funcT=$this->TBASE['store']['task_func'] ?? ['store_set'];
        $this->call_func($funcT);
        $this->BASE['ob']->create($this->BASE['data']);
        Session::flash('flash_message', trans('mo.itemadded'));
        if(method_exists($this, 'store_redirect')) {return $this->store_redirect();}  
        else{return $this->base_redirect();}
    }

    public function edit_set() {}
    public function edit($id)
    {  
        $this->BASE['id']=$id;
        $this->BASE['data'] =$this->BASE['ob']->findOrFail($id);

        $funcT=$this->TBASE['edit']['task_func'] ?? ['edit_set'];
        $this->call_func($funcT);
        $data=$this->BASE['data'];
        if(method_exists($this, 'edit_view')) {return $this->edit_view();}  
        else{return  $this->base_view('edit');}
    }

    public function update_set(){}
    public function update($id, Request $request)
    {
        $this->BASE['id']=$id;
        $valT=$this->val_update ?? $this->val;

        $this->validate($request,$valT );
        $requestData = $request->all();
        $this->BASE['data'] = $request->all();

        $funcT=$this->TBASE['update']['task_func'] ?? ['update_set'];
        $this->call_func($funcT);

        $ob = $this->BASE['ob']->findOrFail($id);
        $ob->update($this->BASE['data']);
        Session::flash('flash_message',  trans('mo.item_updated'));
        if(method_exists($this, 'update_redirect')) {return $this->update_redirect();}  
        else{return $this->base_redirect();}

    }

    public function destroy_set(){}
    public function destroy($id)
    { 
        $this->BASE['id']=$id;
        $this->BASE['ob']->destroy($id);
        $funcT=$this->TBASE['destroy']['task_func'] ?? ['destroy_set'];
        $this->call_func($funcT);
        Session::flash('flash_message', trans('mo.deleted'));
        if(method_exists($this, 'destroy_redirect')) {return $this->destroy_redirect();}  
        else{return $this->base_redirect();}
       // return redirect(\MoHandF::url($this->PAR['route'], $this->PAR['getT']));
    }

    public function show_set(){}
    public function show($id)
    {   
        $this->BASE['id']=$id;  
        $this->BASE['data'] =$this->BASE['ob']->findOrFail($id);

        $funcT=$this->TBASE['show']['task_func'] ?? ['show_set'];
        $this->call_func($funcT);

        $data=$this->BASE['data'];
        if(method_exists($this, 'destroy_view')) {return $this->destroy_view();}  
        else{return $this->base_view('show');}
        //return view($this->PAR['view'].'.show', compact('data'));
    } 
}