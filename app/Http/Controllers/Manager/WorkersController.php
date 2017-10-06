<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Worker;
use App\User;
use App\Wrole;
use App\Timeframe;
use App\Status;
use App\Workertype;
use App\Workergroup;


use Illuminate\Http\Request;
use Session;

class WorkersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $workers = Worker::where('user_id', 'LIKE', "%$keyword%")
				->orWhere('wrole_id', 'LIKE', "%$keyword%")
				->orWhere('status_id', 'LIKE', "%$keyword%")
				->orWhere('workertype_id', 'LIKE', "%$keyword%")
				->orWhere('workergroup_id', 'LIKE', "%$keyword%")
				->orWhere('salary', 'LIKE', "%$keyword%")
				->orWhere('salary_type', 'LIKE', "%$keyword%")
				->orWhere('position', 'LIKE', "%$keyword%")
				->orWhere('foto', 'LIKE', "%$keyword%")
				->orWhere('fullname', 'LIKE', "%$keyword%")
				->orWhere('cim', 'LIKE', "%$keyword%")
				->orWhere('tel', 'LIKE', "%$keyword%")
				->orWhere('birth', 'LIKE', "%$keyword%")
				->orWhere('ado', 'LIKE', "%$keyword%")
				->orWhere('tb', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workers = Worker::paginate($perPage);
        }
       /* if(isset($workers->status_id)){
           $status= Status::where('id', '=', $workers->status_id )
        ->select('id', 'name');
        $workers['status']=$status;  
        }else{ $workers['status']=["id"=>"0","name"=>"nics"]; }
       */

        return view('manager.workers.index', compact('workers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $worker = Worker::get();
        $worker['user']=User::get()->pluck('name','id');
        $worker['wrole']=Wrole::get()->pluck('name','id');
        $worker['base_timeframe']=Timeframe::get(['id','name'])->toarray();
        $worker['checked_timeframe']=[1];
        $worker['status']=Status::get()->pluck('name','id');
        $worker['workertype']=Workertype::get()->pluck('name','id');
        $worker['workergroup']=Workergroup::get()->pluck('name','id');

        return view('manager.workers.create',compact('worker'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'fullname' => 'required|max:200',
			'cim' => 'required|max:200',
			'tel' => 'max:50',
			'birth' => 'required|date',
			'ado' => 'string|max:50',
			'tb' => 'string|max:50',
			'start' => 'required|date',
            'end' => 'date|nullable',
            'note' => 'string|nullable',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
      //  print_r($requestData);
      //  Worker::create($requestData);
       Worker::create($requestData)->timeframe()->sync($request->timeframe_id);
        Session::flash('flash_message', 'Worker added!');

        return redirect('manager/workers');
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

        return view('manager.workers.show', compact('worker'));
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

        return view('manager.workers.edit', compact('worker'));
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
        $this->validate($request, [
            'workergroup_id'=>'integer',
			'fullname' => 'required|max:200',
			'cim' => 'required|max:200',
			'tel' => 'max:50',
			'birth' => 'required|date',
			'ado' => 'strin|max:50',
			'tb' => 'string|max:50',
			'start' => 'required|date',
            'end' => 'date|nullable',
            'note' => 'string|nullable',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
    //'checked_timeframe' ,base_timeframe
        
        $worker = Worker::findOrFail($id);
        $worker->update($requestData);

        Session::flash('flash_message', 'Worker updated!');

        return redirect('manager/workers');
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
        Worker::destroy($id);

        Session::flash('flash_message', 'Worker deleted!');

        return redirect('manager/workers');
    }
}
