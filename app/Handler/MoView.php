<?php
namespace App\Handler;
use Illuminate\Http\Request;

class Moview
{
static public $GOB;
  public  $request;
function __construct(Request $request) {
    $this->request=$request;
}
    public function view( $view,$data,$dataname)
    {  
      //példa a conrollerben: 
      // use App\Facades\MoView; 
      //\App\Lib\MoView::$GOB['err2']='gggggggggggggg';  //json tömbbe írás a controllerből
      // return  \App\Lib\MoView::view( 'manager.users.index',$users,'users',$request->is('cors/*'));
    
    $$dataname=$data;

     // $cors=$this->request->is('cors/*');
      if (false) {

         $json= $data->toArray();
         $json['err']=self::$GOB;
            return response()->json($json,200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }
        else{
            return view($view, compact($dataname));
        }
      
    }
}