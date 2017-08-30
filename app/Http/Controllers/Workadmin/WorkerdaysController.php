<?php

namespace App\Http\Controllers\Workadmin;

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

class WorkerdaysController extends Controller
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
    // return MoView::view( 'workadmin.workerdays.days',$data,'data',$request->is('cors/*'));
    return view('workadmin.workerdays.days', compact('data'));

    }
    public function index2($year,$month,$day,$userid)
    {
        $this->year=$year;
        $this->month=$month;
        $this->day=$day;
        $this->userid=$userid;
        $request=new Request();
        $data=$this->baseData($request);
     // return MoView::view( 'workadmin.workerdays.days',$data,'data',$request->is('cors/*'));
    return view('workadmin.workerdays.days', compact('data'));
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
        $this->userid=$userid;
        $request=new Request();
        $data=$this->baseData($request);
        $data['worktimes']=  Worktime::where('worker_id', '=', $userid)->get();
    // return MoView::view( 'workadmin.workerdays.days',$data,'data',$request->is('cors/*'));
    return view('workadmin.workerdays.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */




/*
public function store($year,$month,$day,$userid)
    {
        $this->validate($request, [
			'worker_id' => 'required|integer',
			'date' => 'required|date',
			'start' => 'date_format:H:i',
			'end' => 'date_format:H:i',
			'hour' => 'required|date_format:H',
			'type' => 'required'
        ]);
        $request=new Request();
        $requestData = $request->all();
        print_r($requestData);
        
        Worktime::create($requestData);

        Session::flash('flash_message', 'Worktime added!');

        return redirect('/workadmin/workerdays/create/'.$year.'/'.$month.'/'.$day.'/'.$userid);
    }*/

     
    public function store(Request $request)
    {/*
        $this->validate($request, [
			'worker_id' => 'required|integer',
			'date' => 'required|date',
			'start' => 'date_format:H:i',
			'end' => 'date_format:H:i',
			'hour' => 'required|date_format:H',
			'type' => 'required'
        ]);*/
      
        $requestData = $request->all();
        print_r($requestData);
        
        Worktime::create($requestData);

        Session::flash('flash_message', 'Worktime added!');

        return redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $worker = Worker::findOrFail($id);

        return view('workadmin.workers.show', compact('worker'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $worker = Worker::findOrFail($id);

        return view('workadmin.workers.edit', compact('worker'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, $this->$valid);
        $requestData = $request->all();
        
        $worker = Worker::findOrFail($id);
        $worker->update($requestData);

        Session::flash('flash_message', 'Worker updated!');

        return redirect('workadmin/workers');
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
        Worktime::destroy($id);
        
         Session::flash('flash_message', 'Worktime deleted!');

        return redirect($_SERVER['HTTP_REFERER']);
    }
}
