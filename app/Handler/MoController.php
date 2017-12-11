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
//  use  App\Handler\trt\crud\Crud; vagy App\Handler\trt\crud\CrudWithSetfunc
 use  \App\Handler\trt\SetController;
    
    protected $PAR= [];
    protected $TPAR= [];
    protected $BASE= [];
    protected $TBASE= [];
    protected $val= [];
    protected $val_edit= [];

    function construct_handler(){

    }  
    function __construct(Request $request){

       // $this->$PAR['view']=  $this->$PAR['baseview'];
        $this->setTask();
        $this->set_getT($request);
        $this->construct_handler();
        $obname=$this->BASE['obname'];
        $this->BASE['ob']=new $obname();
        View::share('param',$this->PAR);
       }

}