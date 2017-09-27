<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Timeunit;
use Illuminate\Http\Request;
use Session;

class TimeunitsController extends Controller
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
            $timeunits = Timeunit::where('name', 'LIKE', "%$keyword%")
				->orWhere('unit', 'LIKE', "%$keyword%")
				->orWhere('unitlong', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $timeunits = Timeunit::paginate($perPage);
        }

        return view('manager.timeunits.index', compact('timeunits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.timeunits.create');
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
			'name' => 'required|max:200',
			'unit' => 'max:200',
			'unitlong' => 'max:200',
			'note' => 'max:200',
			'pub' => 'max:4'
		]);
        $requestData = $request->all();
        
        Timeunit::create($requestData);

        Session::flash('flash_message', 'Timeunit added!');

        return redirect('manager/timeunits');
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
        $timeunit = Timeunit::findOrFail($id);

        return view('manager.timeunits.show', compact('timeunit'));
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
        $timeunit = Timeunit::findOrFail($id);

        return view('manager.timeunits.edit', compact('timeunit'));
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
			'name' => 'required|max:200',
			'unit' => 'max:200',
			'unitlong' => 'max:200',
			'note' => 'max:200',
			'pub' => 'max:4'
		]);
        $requestData = $request->all();
        
        $timeunit = Timeunit::findOrFail($id);
        $timeunit->update($requestData);

        Session::flash('flash_message', 'Timeunit updated!');

        return redirect('manager/timeunits');
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
        Timeunit::destroy($id);

        Session::flash('flash_message', 'Timeunit deleted!');

        return redirect('manager/timeunits');
    }
}
