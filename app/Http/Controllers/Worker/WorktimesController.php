<?php

namespace App\Http\Controllers\Worker;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Workeruser;
use App\Worktime;
use Illuminate\Http\Request;
use Session;
use App\facades\MoView;
use App\facades\WorkerusersH;
use Carbon\Carbon;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use Auth;
class WorktimesController extends Controller
{
    protected $year=0;
    protected $month=1;
    protected $day=1;
    protected $userid=0;

     public function baseData($request)
     {
        $data['workerusers']=WorkerusersH::getList($request,4); 
        $data['days']=WorkerusersH::getDays([],[],$this->year,$this->month);
        $data['months']=WorkerusersH::getMonths($this->month);
        $data['year']=$this->year;
        $data['month']=$this->month;
        $data['day']=$this->day;
        $data['userid']=$this->userid;
        if($this->userid>0){$data['username']=User::find($this->userid)->name;}
        else{$data['username']='noname';}
        return $data;
     }

    public function index(Request $request)
    {
     $current = new Carbon();    
    $this->year= $current->year;
    $this->month= $current->month; 
    $this->day= $current->day; 

    $data=$this->baseData($request);
    // return MoView::view( 'worker.worktimes.days',$data,'data',$request->is('cors/*'));
    return view('worker.worktimes.days', compact('data'));

    }
    public function index2($year,$month,$day,$userid)
    {
        $this->year=$year;
        $this->month=$month;
        $this->day=$day;
        $this->userid=Auth::id();
        $request=new Request();
        $data=$this->baseData($request);
       // return MoView::view( 'worker.worktimes.days',$data,'data',$request->is('cors/*'));
        return view('worker.worktimes.days', compact('data'));
       // return  $this->index($request);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($year,$month,$day,$userid)
    {
        $this->year=$year;
        $this->month=$month;
        $this->day=$day;
        $this->userid=Auth::id();
        $request=new Request();
        $data=$this->baseData($request);
        $data['worktimes']=  Worktime::where('worker_id', '=', $userid)->get();
       // return view('workadmin.workerdays.create');
      // return MoView::view( 'worker.worktimes.create',$data,'data',$request->is('cors/*'));
      return view('worker.worktimes.create', compact('data'));
    }

   
 
}
