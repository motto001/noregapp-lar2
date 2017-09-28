<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Timetype;
use Illuminate\Http\Request;
use Session;

class TimetypesController extends Controller
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
            $timetypes = Timetype::where('name', 'LIKE', "%$keyword%")
				->orWhere('szorzo', 'LIKE', "%$keyword%")
				->orWhere('fixplusz', 'LIKE', "%$keyword%")
				->orWhere('color', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $timetypes = Timetype::paginate($perPage);
        }

        return view('manager.timetypes.index', compact('timetypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.timetypes.create');
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
        
        Timetype::create($requestData);

        Session::flash('flash_message', 'Timetype added!');

        return redirect('manager/timetypes');
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
        $timetype = Timetype::findOrFail($id);

        return view('manager.timetypes.show', compact('timetype'));
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
        $timetype = Timetype::findOrFail($id);

        return view('manager.timetypes.edit', compact('timetype'));
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
        
        $timetype = Timetype::findOrFail($id);
        $timetype->update($requestData);

        Session::flash('flash_message', 'Timetype updated!');

        return redirect('manager/timetypes');
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
        Timetype::destroy($id);

        Session::flash('flash_message', 'Timetype deleted!');

        return redirect('manager/timetypes');
    }
}
