<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workroleunit;
use Illuminate\Http\Request;
use Session;

class WorkroleunitsController extends Controller
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
            $workroleunits = Workroleunit::where('workrole_id', 'LIKE', "%$keyword%")
				->orWhere('timeunit_id', 'LIKE', "%$keyword%")
				->orWhere('worktime_id', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workroleunits = Workroleunit::paginate($perPage);
        }

        return view('manager.workroleunits.index', compact('workroleunits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.workroleunits.create');
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
			'workrole_id' => 'required|integer',
			'timeunit_id' => 'required|integer',
			'worktime_id' => 'required|integer'
		]);
        $requestData = $request->all();
        
        Workroleunit::create($requestData);

        Session::flash('flash_message', 'Workroleunit added!');

        return redirect('manager/workroleunits');
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
        $workroleunit = Workroleunit::findOrFail($id);

        return view('manager.workroleunits.show', compact('workroleunit'));
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
        $workroleunit = Workroleunit::findOrFail($id);

        return view('manager.workroleunits.edit', compact('workroleunit'));
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
			'workrole_id' => 'required|integer',
			'timeunit_id' => 'required|integer',
			'worktime_id' => 'required|integer'
		]);
        $requestData = $request->all();
        
        $workroleunit = Workroleunit::findOrFail($id);
        $workroleunit->update($requestData);

        Session::flash('flash_message', 'Workroleunit updated!');

        return redirect('manager/workroleunits');
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
        Workroleunit::destroy($id);

        Session::flash('flash_message', 'Workroleunit deleted!');

        return redirect('manager/workroleunits');
    }
}
