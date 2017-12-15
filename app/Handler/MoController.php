<?php

namespace App\Handler;
/*
use Illuminate\Support\Facades\View;
//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
*/

class MoController extends Controller
{
//  use  App\Handler\trt\crud\Crud; vagy App\Handler\trt\crud\CrudWithSetfunc
// use  \App\Handler\trt\SetController;

/***
 * minden view-el megosztott adatok
 */
protected $PAR= [ 
    'varname'=>'param', // ezen a néven kapják meg a view-ek
    'get_key'=>'', //pl.:'wrtime' Láncnál ezzel az előtaggal azonosítja a a controller arávonatkozó get tagokat
    'route'=>'',//pl.:'manager/wroletimes' A controller base routja
    'ret'=>'',
    // lánc esetén a hívő controller routja. Ide irányt vissza az ktuzális feladat elvégzése után
    //setController->set_getT() állítja be az url PAR['get_key'].'_ret" kulcsa alapján
    'view'=>'', 
    //pl.:'manager.wrunit_times'
    //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
    'crudview'=>'crudbase_2', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim'=>'',  //a templétben megjelenő cím
    'getT'=>[], 
    //pl.: ['wru'=>'0']
    // A templéttel megosztott get tömb.A $this->url()  ebből generálja az url get paramétereit (MoHandF::url()-t használja)
    'search'=>true,  // ha false kikapcsolja az index táblázat kereső mezőjét
    
];
/**
 * taskok PAR értékei, a Handler\trt\SetController->set_task() az aktuális task kulcsa alatt szereplő értékekkel felül írja a $PAR értékeit
 */
protected $TPAR= [];

/**
 * a controlleráltal használt alap adatok, paraméterek 
 */
protected $BASE= [
    'redirect'=>[],
    //pl.:['base'=>'manager/wroletimes','wru'=>'manager/wroleunits']
    //A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
    'search_column'=>'daytype_id,datum,managernote,usernote',// ha a search be van kapcsolva ezekben a mezőkben keres
    'get'=>[],
    //pl.:['wru_id'=>'0','wru_ret'=>null,'wrole_id'=>null,'wrole_ret'=>null,'worker_id'=>null], //többszörös lánc!
    //a trait setController->set_getT() ez alapján tölti fel a PAR['getT']-t.
    //Ha az aktuális url get paraméterei Között szerepel a tömb kulcsai közül valamelyik, akor azt  az url ben szereplő értékkell, bemásolja a PAR['getT']-be.
    //Ha az url-ben nem szerepel  akkor az itt szereplő értékkel kerül be a PAR['getT']-be
    //Ha az url-ben nem szerepel és az érték null nem kerül bea PAR['getT']-be.
    'get_post'=>[],//ugyanaz mint a 'get' csak  ha van ilyen kulcs a postban azzal felülírja
    'obname'=>'\App\Wroletime',
     //ha becsatoljuk és futtatjuk a Handler\trt\SetController->set_ob() funkciót ez alapján készíti el az aktuális objektumot aZ 'ob' kulcsra
    'ob'=>null, 
    'data'=>[], // az aktuális viewnek átadott adatok
    'func'=>[], // a constructor által lefuttatni kívánt funkciók  
];
/**
 * taskok base értékei, a Handler\trt\SetController->set_task() az aktuális task kulcsa alatt szereplő értékekkel felül írja a $BASE értékeit
 */
protected $TBASE= [
  //pl.: 'index'=> ['task_func'=>['set_index']] // az aktuális task (index) által lefuttatni kívánt funkciók 
];
/**
 * a create task validációs tömbje
 */
protected $val= [];//pl.:['wroleunit_id' => 'required|integer','end' => 'date_format:H:i','note' => 'string|max:200|nullable']   
/**
 *  az update task validációs tömbje ha üres az update is a $val-t használja 
 */
protected $val_update= [];

   // function __construct(){ //le kell tesztelni hogy request nélkülis működik-e
    function __construct(Request $request){

        if(is_callable([$this, "set_base"])) {$this->base();} 
        if(is_callable([$this, "set_task"])) {$this->set_task();} 
        if(is_callable([$this, "set_getT"])) {$this->set_getT();} 
        if(is_callable([$this, "set_route"])) {$this->set_route();} 

        $create_OB=$this->BASE['create_OB'] ?? true;
        if($create_OB){
            $obname=$this->BASE['obname'];
            $this->BASE['ob']=new $obname(); 
        }
        $share_param=$this->BASE['share_param'] ?? true;
        $share_param_name=$this->BASE['share_param_name'] ?? 'param';
        if($share_param){
            View::share($share_param_name,$this->PAR);
        }
        $task=$this->PAR['task'] ?? '';
        if($task!='')
        {
            return $this->$task();
        }

       }

}