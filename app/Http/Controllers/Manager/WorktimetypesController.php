<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Worktimetype;
use Illuminate\Http\Request;
use Session;

class WorktimetypesController extends Controller
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
            $worktimetypes = Worktimetype::where('name', 'LIKE', "%$keyword%")
				->orWhere('szorzo', 'LIKE', "%$keyword%")
				->orWhere('fixplusz', 'LIKE', "%$keyword%")
				->orWhere('color', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $worktimetypes = Worktimetype::paginate($perPage);
        }

        return view('manager.worktimetypes.index', compact('worktimetypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.worktimetypes.create');
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
			'szorzo' => 'number',
			'fixplusz' => 'integer',
			'color' => 'string|max:200',
			'note' => 'string|max:200'
		]);
        $requestData = $request->all();
        
        Worktimetype::create($requestData);

        Session::flash('flash_message', 'Worktimetype added!');

        return redirect('manager/worktimetypes');
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
        $worktimetype = Worktimetype::findOrFail($id);

        return view('manager.worktimetypes.show', compact('worktimetype'));
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
        $worktimetype = Worktimetype::findOrFail($id);

        return view('manager.worktimetypes.edit', compact('worktimetype'));
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
			'szorzo' => 'number',
			'fixplusz' => 'integer',
			'color' => 'string|max:200',
			'note' => 'string|max:200'
		]);
        $requestData = $request->all();
        
        $worktimetype = Worktimetype::findOrFail($id);
        $worktimetype->update($requestData);

        Session::flash('flash_message', 'Worktimetype updated!');

        return redirect('manager/worktimetypes');
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
        Worktimetype::destroy($id);

        Session::flash('flash_message', 'Worktimetype deleted!');

        return redirect('manager/worktimetypes');
    }
}
