<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workertype;
use Illuminate\Http\Request;
use Session;

class WorkertypesController extends Controller
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
            $workertypes = Workertype::where('name', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workertypes = Workertype::paginate($perPage);
        }

        return view('manager.workertypes.index', compact('workertypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.workertypes.create');
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
			'note' => 'string'
		]);
        $requestData = $request->all();
        
        Workertype::create($requestData);

        Session::flash('flash_message', 'Workertype added!');

        return redirect('manager/workertypes');
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
        $workertype = Workertype::findOrFail($id);

        return view('manager.workertypes.show', compact('workertype'));
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
        $workertype = Workertype::findOrFail($id);

        return view('manager.workertypes.edit', compact('workertype'));
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
			'note' => 'string'
		]);
        $requestData = $request->all();
        
        $workertype = Workertype::findOrFail($id);
        $workertype->update($requestData);

        Session::flash('flash_message', 'Workertype updated!');

        return redirect('manager/workertypes');
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
        Workertype::destroy($id);

        Session::flash('flash_message', 'Workertype deleted!');

        return redirect('manager/workertypes');
    }
}
