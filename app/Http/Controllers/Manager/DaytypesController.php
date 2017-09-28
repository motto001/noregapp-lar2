<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Daytype;
use Illuminate\Http\Request;
use Session;

class DaytypesController extends Controller
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
            $daytypes = Daytype::where('name', 'LIKE', "%$keyword%")
				->orWhere('szorzo', 'LIKE', "%$keyword%")
				->orWhere('fixplusz', 'LIKE', "%$keyword%")
				->orWhere('color', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $daytypes = Daytype::paginate($perPage);
        }

        return view('manager.daytypes.index', compact('daytypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.daytypes.create');
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
			'name' => 'required|string',
			'szorzo' => 'number',
			'fixplusz' => 'integer',
			'color' => 'string',
			'note' => 'string'
		]);
        $requestData = $request->all();
        
        Daytype::create($requestData);

        Session::flash('flash_message', 'Daytype added!');

        return redirect('manager/daytypes');
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
        $daytype = Daytype::findOrFail($id);

        return view('manager.daytypes.show', compact('daytype'));
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
        $daytype = Daytype::findOrFail($id);

        return view('manager.daytypes.edit', compact('daytype'));
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
			'name' => 'required|string',
			'szorzo' => 'number',
			'fixplusz' => 'integer',
			'color' => 'string',
			'note' => 'string'
		]);
        $requestData = $request->all();
        
        $daytype = Daytype::findOrFail($id);
        $daytype->update($requestData);

        Session::flash('flash_message', 'Daytype updated!');

        return redirect('manager/daytypes');
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
        Daytype::destroy($id);

        Session::flash('flash_message', 'Daytype deleted!');

        return redirect('manager/daytypes');
    }
}
