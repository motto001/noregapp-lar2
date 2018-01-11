<?php

namespace App\Http\Controllers\Manager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Wrole;
use App\Wroleunit;
use Illuminate\Http\Request;
use Session;

class WrolesController extends \App\Handler\MoController
{
use  \App\Handler\trt\crud\CrudWithSetfunc;
use  \App\Handler\trt\SetController;

public function set_base(){
 $this->PAR['routes']['base']= 'manager/wroles';
 $this->PAR['routes']['worker']= 'manager/worker';
 $this->PAR['view']= 'manager.wroles';
 $this->PAR['crudview']= 'crudbase_3';    
 $this->PAR['cim']= 'Munkarendek';
// $this->PAR['search']= false;
 $this->BASE['obname']= '\App\Wrole'; 
 $this->BASE['func']= ['set_ob','set_getT','set_task']; 
 $this->BASE['get']= ['unitid'=>null,'wroleid'=>null]; 

}
 protected $val = [
        'name' => 'required|string|max:200',
        'note' => 'string|max:200|nullable',
        'start' => 'string|max:200|nullable',
        'pub' => 'integer'
 ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index_set()
    {
        $request=$this->BASE['request'];
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $wroles = Wrole::where('name', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $wroles = Wrole::paginate($perPage);
        }
        $this->BASE['data']['list']=$wroles;
    }
    public function edit_set()
    {

            $id=$this->BASE['id'];
            $data = Wrole::with('wroleunit')->findOrFail($id);
            //$data['wroleunits']=
            $data['id']=$id ;
            $this->BASE['data'] = $data;

      //  $this->BASE['data']['wroleunits']=[];
        $this->BASE['data']['wroleunits_all']=Wroleunit::get();
    }
    public function addunit()
    {
       // $this->BASE['getT']['unitid']; $this->BASE['getT']['wroleid'];
       DB::table('wrole_wroleunit')->insert(
        ['wrole_id' => $this->PAR['getT']['wroleid'], 'wroleunit_id' => $this->PAR['getT']['unitid']]);
    //  return  redirect(\MoHandF::url('manager/wroles/'.$this->PAR['getT']['wroleid'].'/edit', $this->PAR['getT']));  
   
   $url=\MoHandF::url('manager/wroles/'.$this->PAR['getT']['wroleid'].'/edit', $this->PAR['getT']);
   //echo $url;
   header("Location:$url");
    die();
  
    // return  redirect('http://localhost:8000/manager/wroles/4/edit');
    //die();
    // echo '--wroleid:'.$this->PAR['getT']['wroleid'].'--unitid:'.$this->PAR['getT']['unitid'].'-basetask:'.\Route::getCurrentRoute()->getActionMethod().'-task:'.\Route::getCurrentRoute()->getActionMethod();
 // echo \MoHandF::url('manager/wroles/'.$this->PAR['getT']['wroleid'].'/edit', $this->PAR['getT']);
    }
    public function delunit()
    {
       // $this->BASE['getT']['unitid']; $this->BASE['getT']['wroleid'];
       DB::table('wrole_wroleunit')->where([
           ['wrole_id', '=', $this->PAR['getT']['wroleid']],['wroleunit_id', '=', $this->PAR['getT']['unitid']]])
           ->delete(); 
           $url=\MoHandF::url('manager/wroles/'.$this->PAR['getT']['wroleid'].'/edit', $this->PAR['getT']);
           header("Location:$url");
           die();  
    }
}
