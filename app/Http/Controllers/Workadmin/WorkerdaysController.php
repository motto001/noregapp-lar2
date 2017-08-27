<?php

namespace App\Http\Controllers\Workadmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Workeruser;
//use App\Worker;
use Illuminate\Http\Request;
use Session;
use App\Facades\MoView;
use App\Facades\WorkerusersH;

class WorkerdaysController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
    $data['workerusers']=WorkerusersH::getList($request,2); 
    $data['mounth']='0';
    $data['user']='0';
    $data['year']='0';
     return MoView::view( 'workadmin.workerdays.index',$data,'data',$request->is('cors/*'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('workadmin.workers.create');
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
        $this->validate($request, $this->$valid);
        $requestData = $request->all();
        
        Worker::create($requestData);

        Session::flash('flash_message', 'Worker added!');

        return redirect('workadmin/workers');
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
        Worker::destroy($id);

        Session::flash('flash_message', 'Worker deleted!');

        return redirect('workadmin/workers');
    }
}
