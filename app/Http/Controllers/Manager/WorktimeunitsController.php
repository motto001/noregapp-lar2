<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Worktimeunit;
use Illuminate\Http\Request;
use Session;

class WorktimeunitsController extends Controller
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
            $worktimeunits = Worktimeunit::where('worktimetype_id', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $worktimeunits = Worktimeunit::paginate($perPage);
        }

        return view('manager.worktimeunits.index', compact('worktimeunits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.worktimeunits.create');
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
			'worktimetype_id' => 'required|integer',
			'start' => 'required|time',
			'end' => 'time',
			'hour' => 'required|number|max:24',
			'note' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Worktimeunit::create($requestData);

        Session::flash('flash_message', 'Worktimeunit added!');

        return redirect('manager/worktimeunits');
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
        $worktimeunit = Worktimeunit::findOrFail($id);

        return view('manager.worktimeunits.show', compact('worktimeunit'));
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
        $worktimeunit = Worktimeunit::findOrFail($id);

        return view('manager.worktimeunits.edit', compact('worktimeunit'));
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
			'worktimetype_id' => 'required|integer',
			'start' => 'required|time',
			'end' => 'time',
			'hour' => 'required|number|max:24',
			'note' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $worktimeunit = Worktimeunit::findOrFail($id);
        $worktimeunit->update($requestData);

        Session::flash('flash_message', 'Worktimeunit updated!');

        return redirect('manager/worktimeunits');
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
        Worktimeunit::destroy($id);

        Session::flash('flash_message', 'Worktimeunit deleted!');

        return redirect('manager/worktimeunits');
    }
}
