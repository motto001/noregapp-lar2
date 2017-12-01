<?php

namespace App\Handler;
use Illuminate\Support\Facades\View;
//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class MoController extends Controller
{
    protected $paramT= [
        'baseroute'=>'workadmin/workerdays',
        'baseview'=>'workadmin.workerdays', 
        'crudview'=>'crudbase_2', 
        'cim'=>'Dolgozói napok',
       // 'funcT'=>[],   //lehet task kulcsal is csak az adott taskra 
        'get'=>['w_id'],
        'get_post'=>['ev','ho'],
        'ob'=>'\App\Day',
    ];
    protected $task_paramT= [];
    protected $valT= [];
    protected $val_editT= [];

    function get_searchT($keyword,$search_column){
        if(!is_array($search_column)){$search_column=explode(',',$search_column);}
        foreach($search_column as $key)
        {
            $res[]=[$key, 'LIKE', "%$keyword%"];
        }
        return $res;
    }
    function get_orwhereT($keyword){
        if(isset($this->paramT['orwhereT'])){$res=$this->paramT['orwhereT'];}
        else if(isset($this->paramT['search_column'])){$res=$this->get_searchT($keyword,$this->paramT['search_column']);}
        else{$res=['id', 'LIKE', "%$keyword%"];}
        return $res;
    }
    function set_getT(Request $request){
        foreach($this->paramT['get'] as $key){
            $baseval=$this->paramT['baseval'][$key] ?? '0';
            $this->paramT['getT'][$key]=Input::get($key) ?? $baseval;
        }
        foreach($this->paramT['get_post'] as $key){
            $baseval=$this->paramT['baseval'][$key] ?? '0';
            $this->paramT['getT'][$key]=Input::get($key) ?? $baseval;
            $this->paramT['getT'][$key]= $request->input($key, $this->paramT['getT'][$key]) ;
        }
    }

    function construct_handler(){

        $task=Input::get('task') ?? '';

        if($task==''){$task= \Route::getCurrentRoute()->getActionMethod();}
        $this->paramT['task'] =$task;

        if(isset($this->task_paramT[$task])){$this->paramT = array_merge($this->paramT, $this->task_paramT[$task]);}
        
    }  
    function construct_baseval(){}
    function __construct(Request $request){

        $this->construct_baseval(); 
        $this->set_getT($request);
        $this->construct_handler();
        View::share('param',$this->paramT);
       }
    public function index_data($request){return [];}

    public function index(Request $request)
    {
        if($this->paramT['task']!='index'){$this->paramT['task']();}
        else
        {
            $data=$this->index_data($request);
            return view($this->paramT['crudview'].'.index', compact('data'));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->paramT['ob']::destroy($id);

        Session::flash('flash_message', trans('mo.deleted'));

        return redirect($this->paramT['baseroute']);
    }
}