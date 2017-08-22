<?php

namespace App\Http\Controllers\Worker;

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
            $worktimes = Worktime::where('user_id', 'LIKE', "%$keyword%")
				->orWhere('year', 'LIKE', "%$keyword%")
				->orWhere('mounth', 'LIKE', "%$keyword%")
				->orWhere('day', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('type', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $worktimes = Worktime::paginate($perPage);
        }

        return view('worker.worktimes.index', compact('worktimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('worker.worktimes.create');
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
			'year' => 'required|min:2000|max:2100',
			'mounth' => 'required|max:12',
			'day' => 'required|max:31',
			'hour' => 'max:24'
		]);
        $requestData = $request->all();
        
        Worktime::create($requestData);

        Session::flash('flash_message', 'Worktime added!');

        return redirect('worker/worktimes');
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

        return view('worker.worktimes.show', compact('worktime'));
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

        return view('worker.worktimes.edit', compact('worktime'));
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
			'year' => 'required|min:2000|max:2100',
			'mounth' => 'required|max:12',
			'day' => 'required|max:31',
			'hour' => 'max:24'
		]);
        $requestData = $request->all();
        
        $worktime = Worktime::findOrFail($id);
        $worktime->update($requestData);

        Session::flash('flash_message', 'Worktime updated!');

        return redirect('worker/worktimes');
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

        return redirect('worker/worktimes');
    }
}
