<?php

namespace App\Handler\trt\crud;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Image;
Trait CrudWithSetfunc
{
    //kép kezelő:https://github.com/Intervention/image
    public function image_upload(){ 
        if(Input::file())
        {
        $imageinputmezo=$this->TBASE['imageinputmezo'] ?? 'image' ;
        $image = Input::file($imageinputmezo);
        $imagedatamezo=$this->TBASE['imagedatamezo'] ?? 'foto' ;
        $filename=$this->TBASE['image']['name'] ?? time() . '.' . $image->getClientOriginalExtension();
        $path= $this->TBASE['image']['savepath'] ?? 'images';
        $widt=$this->TBASE['image']['widt'] ?? 600;
        $height=$this->TBASE['image']['height'] ?? 600;
        $thumb= $this->TBASE['image']['thumb'] ?? true;   

    
        $imagepath = public_path($path.'/' . $filename);
        if(!is_dir ( public_path($path) )){
            mkdir(public_path($path), 777);
            mkdir(public_path($path.'/thumb'), 777);
        }
        \Image::make($image->getRealPath())->resize($widt, $height)->save($imagepath);
        //thumb ----------------------------
        if($thumb) {         
        $th_path= $this->TBASE['image']['thumb_savepath'] ?? $path.'/thumb';
        $thumb_widt=$this->TBASE['image']['thumb_widt'] ?? 100;
        $thumb_height=$this->TBASE['image']['thumb_height'] ?? 100;
        $thumb_path = public_path($th_path.'/' . $filename);
            \Image::make($image->getRealPath())->resize($thumb_widt, $thumb_height)->save($thumb_path);
        }   

         $this->BASE['data'][$imagedatamezo]=  $th_path.'/' . $filename;
        }
           
    }
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
    public function index_set(){ }
    public function search(){
    /*return  $this->BASE['ob']
    ->where('user_id', 'LIKE', "%$keyword%")
    ->orWhere('wrole_id', 'LIKE', "%$keyword%")
    ->orWhere('status_id', 'LIKE', "%$keyword%")
    ->paginate($perPage);*/
    return '';
    }
    public function index_base(){
        $ob=$this->BASE['ob'];
        $perPage=$this->PAR['perpage'] ?? 50;
        $getT=$this->PAR['getT'] ?? ['a'=>'a'];

        if(is_callable([$this->BASE['request'], 'get'])) {$keyword = $this->BASE['request']->get('search') ?? '';} 
        else{$keyword = '';}
        $with=$this->BASE['with'] ?? '';
        if ($with=='') {  
            $ob_base =$ob ;   
        } else {
            $ob_base = $ob->with($with);
           
        } 

        if (empty($keyword)) {  
            $this->BASE['data']['list'] =$ob_base->paginate($perPage)->appends($getT) ;   
          //  print_r($this->BASE['data']['list']);
        } else {
            $this->BASE['data']['list'] = $this->search();
            if($this->BASE['data']['list']==''){ $this->BASE['data']['list'] =$ob_base->paginate($perPage)->appends($getT) ;  }
        }
        
    }
    public function index(Request $request)
    {
    
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

        $funcT=$this->TBASE['store']['task_func'] ?? ['store_set','image_upload'];
        $this->call_func($funcT);

        $this->BASE['ob_res']= $this->BASE['ob']->create($this->BASE['data']);

        Session::flash('flash_message', trans('mo.itemadded'));
        if(method_exists($this, 'store_redirect')) {return $this->store_redirect();}  
        else{return $this->base_redirect();}
    }

    public function edit_set() {}
    public function edit($id)
    {  
        $this->BASE['id']=$id;
        $this->BASE['data'] =$this->BASE['ob']->findOrFail($id);

        $funcT=$this->TBASE['edit']['task_func'] ?? ['edit_set','image_upload'];
      
        $this->call_func($funcT);
        $data=$this->BASE['data'];
      
        if(method_exists($this, 'edit_view')) {return $this->edit_view();}  
        else{return  $this->base_view('edit');}
    }
    public function update_file(){}
    public function update_set(){}
    public function update($id, Request $request)
    {
        $this->BASE['id']=$id;
        
        $valT=$this->val_update ?? $this->val;

        $this->validate($request,$valT );
        $requestData = $request->all();
        $this->BASE['data'] = $request->all();

        $this->BASE['ob_res']=$this->BASE['ob']->findOrFail($id);

        $funcT=$this->TBASE['update']['task_func'] ?? ['update_set','image_upload'];
        $this->call_func($funcT);

        $this->BASE['ob_res']->update($this->BASE['data']);

        Session::flash('flash_message',  trans('mo.item_updated'));
        if(method_exists($this, 'update_redirect')) {return $this->update_redirect();}  
        else{return $this->base_redirect();}

    }

    public function destroy_set(){}
    public function destroy($id)
    { 
        $this->BASE['id']=$id;
        $this->BASE['ob_res']= $this->BASE['ob']->destroy($id);

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