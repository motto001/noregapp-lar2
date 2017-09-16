<?php

namespace App\Http\Controllers\Workadmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Worktime;
use Illuminate\Http\Request;
use Session;

class WorktimesController extends Controller
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
            $worktimes = Worktime::where('worker_id', 'LIKE', "%$keyword%")
				->orWhere('date', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('type', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $worktimes = Worktime::paginate($perPage);
        }

        return view('workadmin.worktimes.index', compact('worktimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('workadmin.worktimes.create');
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
			'worker_id' => 'required|integer',
			'date' => 'required|date',
			'start' => 'date_format:H:i',
			'end' => 'date_format:H:i',
			'hour' => 'required|date_format:H',
			'type' => 'required'
		]);
        $requestData = $request->all();
        
        Worktime::create($requestData);

        Session::flash('flash_message', 'Worktime added!');

        return redirect('workadmin/worktimes');
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
        $worktime = Worktime::findOrFail($id);

        return view('workadmin.worktimes.show', compact('worktime'));
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
        $worktime = Worktime::findOrFail($id);

        return view('workadmin.worktimes.edit', compact('worktime'));
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
			'worker_id' => 'required|integer',
			'date' => 'required|date',
			'start' => 'date_format:H:i',
			'end' => 'date_format:H:i',
			'hour' => 'required|date_format:H',
			'type' => 'required'
		]);
        $requestData = $request->all();
        
        $worktime = Worktime::findOrFail($id);
        $worktime->update($requestData);

        Session::flash('flash_message', 'Worktime updated!');

        return redirect('workadmin/worktimes');
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

        return redirect('workadmin/worktimes');
    }
}
