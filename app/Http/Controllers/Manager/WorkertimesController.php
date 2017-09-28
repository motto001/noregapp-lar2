<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workertime;
use Illuminate\Http\Request;
use Session;

class WorkertimesController extends Controller
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
            $workertimes = Workertime::where('day_id', 'LIKE', "%$keyword%")
				->orWhere('timetype_id', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('workernote', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workertimes = Workertime::paginate($perPage);
        }

        return view('manager.workertimes.index', compact('workertimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.workertimes.create');
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
			'day_id' => 'required|integer',
			'Timetype_id' => 'required|integer',
			'start' => 'required|time',
			'end' => 'time',
			'hour' => 'required|integer|max:24',
			'managernote' => 'string|max:200',
			'workernote' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Workertime::create($requestData);

        Session::flash('flash_message', 'Workertime added!');

        return redirect('manager/workertimes');
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
        $workertime = Workertime::findOrFail($id);

        return view('manager.workertimes.show', compact('workertime'));
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
        $workertime = Workertime::findOrFail($id);

        return view('manager.workertimes.edit', compact('workertime'));
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
			'day_id' => 'required|integer',
			'Timetype_id' => 'required|integer',
			'start' => 'required|time',
			'end' => 'time',
			'hour' => 'required|integer|max:24',
			'managernote' => 'string|max:200',
			'workernote' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $workertime = Workertime::findOrFail($id);
        $workertime->update($requestData);

        Session::flash('flash_message', 'Workertime updated!');

        return redirect('manager/workertimes');
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
        Workertime::destroy($id);

        Session::flash('flash_message', 'Workertime deleted!');

        return redirect('manager/workertimes');
    }
}
