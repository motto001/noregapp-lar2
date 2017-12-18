<?php

namespace App\Handler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;


/*

//use pp\facades\MoHand;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

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
    'varname'=>'param', // ezen a néven kapják meg a view-ek a $PAR-t
    'get_key'=>'', //pl.:'wrtime' Láncnál ezzel az előtaggal azonosítja a a controller a rávonatkozó get tagokat
    'route'=>'',//nem használjuk! helyette a ['redir']['base'] van 
    'redir'=>[],//láncnál ezt használjuk route helyett
    //pl.:['base'=>'manager/wroletimes','wru'=>'manager/wroleunits']
    //A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz 
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
    'perpage'=>50, //táblázat ennyi elemet listáz
    'search_column'=>'',
    //pl.:'daytype_id,datum,managernote,usernote'
    // ha a search be van kapcsolva ezekben a mezőkben keres
    'get'=>[],
    //pl.:['wru_id'=>'0','wru_ret'=>null,'wrole_id'=>null,'wrole_ret'=>null,'worker_id'=>null], //többszörös lánc!
    //a trait setController->set_getT() ez alapján tölti fel a PAR['getT']-t.
    //Ha az aktuális url get paraméterei Között szerepel a tömb kulcsai közül valamelyik, akor azt  az url ben szereplő értékkell, bemásolja a PAR['getT']-be.
    //Ha az url-ben nem szerepel  akkor az itt szereplő értékkel kerül be a PAR['getT']-be
    //Ha az url-ben nem szerepel és az érték null nem kerül bea PAR['getT']-be.
    'get_post'=>[],//ugyanaz mint a 'get' csak  ha van ilyen kulcs a postban azzal felülírja
    'obname'=>'\App\Wroletime',
     //a $this->set_ob() funkció ( acontroller tartalmazza csak a 'func'-tömbbe szerepelnie kell) 
     //ez alapján készíti el az aktuális objektumot aZ 'ob' kulcsra
    'ob'=>null,
    'request',  //construktor másolja ide az aktuális requestet
    'data'=>[], // az aktuális viewnek átadott adatok
    'func'=>[ // a constructor által lefuttatni kívánt funkciók  
    'set_base', //Az alap értékek beállítása ($PAR,$BASE stb)minden childnél definiállni kell   
    'set_task', //\App\Handler\trt\SetController
    'set_getT', //\App\Handler\trt\SetController
    'getT_honosit', //\App\Handler\trt\SetController, eltávolítja a 'getT' kulcsai elől 
    'set_ob',   //$this, a fő objektumot állítja elő az 'ob'-ba az 'obname' alapján
],
];
/**
 * taskok base értékei, a Handler\trt\SetController->set_task() az aktuális task kulcsa alatt szereplő értékekkel felül írja a $BASE értékeit
 */
protected $TBASE= [
    'index'=> ['task_func'=>['index_set']], // az aktuális task (index) által lefuttatni kívánt funkciók 
    'create'=> ['task_func'=>['create_set']],
    'store'=> ['task_func'=>['store_set']],
    'edit'=> ['task_func'=>['edit_set']],
    'update'=> ['task_func'=>['update_set']],
    'destroy'=> ['task_func'=>['destroy_set']],
    'show'=> ['task_func'=>['show_set']],
];
/**
 * a create task validációs tömbje
 */
protected $val= [];//pl.:['wroleunit_id' => 'required|integer','end' => 'date_format:H:i','note' => 'string|max:200|nullable']   
/**
 *  az update task validációs tömbje ha üres az update is a $val-t használja 
 */
protected $val_update= [];

function set_ob(){
    $obname=$this->BASE['obname'];
    $this->BASE['ob']=new $obname();  
}
function call_func($funcT){
        foreach($funcT as $func){
            if(is_callable([$this, $func])) {$this->$func();}  
            else{
                Log::error('Hiányzó controller funkció', ['func' => $func]);
                //error_log('Some message:Hiányzó controller funkció.');
                //$output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
                //$output->writeln('hello');
        }       
}}
/**
 * ha a controller azonosítójával redir érték érkezik (BASE['get_key']_redir)
 * akkor a redir tömb annak megfelelő kulcsú routjára irányít 
 * ha nincs akkor a $this->BASE['redir']['base'] kulcs alatt lévő routra
 */
public function   base_redirect(){
    if(isset($this->PAR['getT'][$this->BASE['get_key'].'_redir']))
    {$redir=$this->BASE['redir'][$this->PAR['getT'][$this->BASE['get_key'].'_redir']];}
    else{$redir=$this->BASE['redir']['base'];}
   return  redirect(\MoHandF::url($redir, $this->PAR['getT']));  
 }
/**
 * trait-el felülírható ha pl json kimenetet akarunk
 */
 public function   base_view($task='index'){
    $data=$this->BASE['data'];
    return view($this->PAR['view'].'.'.$task, compact('data')); 
 }
    function __construct(Request $request){

        $this->BASE['request']=$request;
        $this->set_base();  
        $this->call_func($this->BASE['func']);       
        $share_param_name=$this->PAR['varname'] ?? 'param';
        View::share($share_param_name,$this->PAR);     
        $task=$this->PAR['task'] ?? \Route::getCurrentRoute()->getActionMethod();
        if($task!=\Route::getCurrentRoute()->getActionMethod()) {return $this->$task();}
       }

}