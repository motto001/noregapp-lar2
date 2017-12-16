<?php

namespace App\Handler\trt;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
/**
 * function: set_getT($request)---------------
 * bejövő adat:$BASE['get'],$BASE['get_post'] /lehet üres,nemlétező
 * ir:PAR['getT']
 * function: setTask()------------------------
 * bejövő adat:$TBASE,$TPAR /lehet üres,nemlétező
 * ir:PAR,BASE
 * létrehoz:PAR['task']
 */
Trait SetController
{
/**
 * PAR['getT'] tömböt állítja be, 
 * BASE['get'] kulcsait csak a getben nézi
 * BASE['get_post'] kulcsai a get ben és a postban is. Ha mindkettőben van  a get-et tartja meg.
 * BASE['get'],BASE['get_post'] értékei az alapértelmezett értékek ha null és nincs más érték,nem kerül be a PAR['getT']-be
 */
function set_getT(Request $request){

        foreach($this->BASE['get'] as $key=>$val){
            $val=Input::get($key) ?? $val;
            if($val!=null){
                $this->PAR['getT'][$key]= $val; 
            }  
        }
        foreach($this->BASE['get_post'] as $key=>$val){
            
            $val= $request->input($key, $val) ;
            $val=Input::get($key) ?? $val;
           
            if($val!=null){
               $this->PAR['getT'][$key]= $val; 
            }   
        }
    }
/**
 * A PAR['task']-oz állítja be. A PAR-t a TPAR['task']-al a BASE-t TBASE['task']-al mergeli
 */
    function setTask(){

        $task=Input::get('task') ?? '';

        if($task==''){$task= \Route::getCurrentRoute()->getActionMethod();}
        $this->PAR['task'] =$task;

        if(isset($this->TPAR) && isset($this->TPAR[$task]))
        {$this->PAR = array_merge($this->PAR, $this->TPAR[$task]);}  
        if(isset($this->TBASE) && isset($this->TBASE[$task]))
        {$this->BASE = array_merge($this->BASE, $this->TBASE[$task]);} 
    }  


}

