<?php

namespace App\Http\Controllers\Manager;

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
            $worktimes = Worktime::where('name', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $worktimes = Worktime::paginate($perPage);
        }

        return view('manager.worktimes.index', compact('worktimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.worktimes.create');
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
			'name' => 'required|string|max:200',
			'note' => 'string|max:200'
		]);
        $requestData = $request->all();
        
        Worktime::create($requestData);

        Session::flash('flash_message', 'Worktime added!');

        return redirect('manager/worktimes');
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

        return view('manager.worktimes.show', compact('worktime'));
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

        return view('manager.worktimes.edit', compact('worktime'));
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
			'name' => 'required|string|max:200',
			'note' => 'string|max:200'
		]);
        $requestData = $request->all();
        
        $worktime = Worktime::findOrFail($id);
        $worktime->update($requestData);

        Session::flash('flash_message', 'Worktime updated!');

        return redirect('manager/worktimes');
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

        return redirect('manager/worktimes');
    }
}
