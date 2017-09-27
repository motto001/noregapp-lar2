<?php

namespace App\Http\Controllers\Workadmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Daytypechange;
use Illuminate\Http\Request;
use Session;

class DaytypechangeController extends Controller
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
            $daytypechange = Daytypechange::where('day_id', 'LIKE', "%$keyword%")
				->orWhere('daytype_id', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->orWhere('workernote', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $daytypechange = Daytypechange::paginate($perPage);
        }

        return view('workadmin.daytypechange.index', compact('daytypechange'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('workadmin.daytypechange.create');
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
			'day_id' => 'integer',
			'pub' => 'integer',
			'daytype_id' => 'required|integer',
			'workernote' => 'string',
			'managernote' => 'string'
		]);
        $requestData = $request->all();
        
        Daytypechange::create($requestData);

        Session::flash('flash_message', 'Daytypechange added!');

        return redirect('workadmin/daytypechange');
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
        $daytypechange = Daytypechange::findOrFail($id);

        return view('workadmin.daytypechange.show', compact('daytypechange'));
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
        $daytypechange = Daytypechange::findOrFail($id);

        return view('workadmin.daytypechange.edit', compact('daytypechange'));
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
			'day_id' => 'integer',
			'pub' => 'integer',
			'daytype_id' => 'required|integer',
			'workernote' => 'string',
			'managernote' => 'string'
		]);
        $requestData = $request->all();
        
        $daytypechange = Daytypechange::findOrFail($id);
        $daytypechange->update($requestData);

        Session::flash('flash_message', 'Daytypechange updated!');

        return redirect('workadmin/daytypechange');
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
        Daytypechange::destroy($id);

        Session::flash('flash_message', 'Daytypechange deleted!');

        return redirect('workadmin/daytypechange');
    }
}
