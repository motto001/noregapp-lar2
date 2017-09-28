<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Wroleunit;
use Illuminate\Http\Request;
use Session;

class WroleunitsController extends Controller
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
            $wroleunits = Wroleunit::where('wrole_id', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $wroleunits = Wroleunit::paginate($perPage);
        }

        return view('manager.wroleunits.index', compact('wroleunits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.wroleunits.create');
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
			'timetype_id' => 'required|integer',
			'start' => 'required|time',
			'end' => 'time',
			'hour' => 'required|number|max:24',
			'note' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Wroleunit::create($requestData);

        Session::flash('flash_message', 'Wroleunit added!');

        return redirect('manager/wroleunits');
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
        $wroleunit = Wroleunit::findOrFail($id);

        return view('manager.wroleunits.show', compact('wroleunit'));
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
        $wroleunit = Wroleunit::findOrFail($id);

        return view('manager.wroleunits.edit', compact('wroleunit'));
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
			'timetype_id' => 'required|integer',
			'start' => 'required|time',
			'end' => 'time',
			'hour' => 'required|number|max:24',
			'note' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $wroleunit = Wroleunit::findOrFail($id);
        $wroleunit->update($requestData);

        Session::flash('flash_message', 'Wroleunit updated!');

        return redirect('manager/wroleunits');
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
        Wroleunit::destroy($id);

        Session::flash('flash_message', 'Wroleunit deleted!');

        return redirect('manager/wroleunits');
    }
}
