<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Worker;
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
				->orWhere('workrole_id', 'LIKE', "%$keyword%")
				->orWhere('status_id', 'LIKE', "%$keyword%")
				->orWhere(''workertype_id', 'LIKE', "%$keyword%")
				->orWhere(''workgroup_id', 'LIKE', "%$keyword%")
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
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workers = Worker::paginate($perPage);
        }

        return view('manager.workers.index', compact('workers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.workers.create');
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
			'ado' => 'strin|max:50',
			'tb' => 'string|max:50',
			'start' => 'required|date',
			'end' => 'date',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Worker::create($requestData);

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
			'fullname' => 'required|max:200',
			'cim' => 'required|max:200',
			'tel' => 'max:50',
			'birth' => 'required|date',
			'ado' => 'strin|max:50',
			'tb' => 'string|max:50',
			'start' => 'required|date',
			'end' => 'date',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
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
