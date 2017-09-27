<?php

namespace App\Http\Controllers\Workadmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Daytimechange;
use Illuminate\Http\Request;
use Session;

class DaytimechangeController extends Controller
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
            $daytimechange = Daytimechange::where('day_id', 'LIKE', "%$keyword%")
				->orWhere('worktimetype_id', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('worjernote', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $daytimechange = Daytimechange::paginate($perPage);
        }

        return view('workadmin.daytimechange.index', compact('daytimechange'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('workadmin.daytimechange.create');
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
			'day_id' => 'required|integer',
			'worktimetype_id' => 'required|integer',
			'start' => 'time',
			'end' => 'time',
			'hour' => 'integer|max:24',
			'managernote' => 'string|max:200',
			'workernote' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Daytimechange::create($requestData);

        Session::flash('flash_message', 'Daytimechange added!');

        return redirect('workadmin/daytimechange');
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
        $daytimechange = Daytimechange::findOrFail($id);

        return view('workadmin.daytimechange.show', compact('daytimechange'));
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
        $daytimechange = Daytimechange::findOrFail($id);

        return view('workadmin.daytimechange.edit', compact('daytimechange'));
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
			'day_id' => 'required|integer',
			'worktimetype_id' => 'required|integer',
			'start' => 'time',
			'end' => 'time',
			'hour' => 'integer|max:24',
			'managernote' => 'string|max:200',
			'workernote' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $daytimechange = Daytimechange::findOrFail($id);
        $daytimechange->update($requestData);

        Session::flash('flash_message', 'Daytimechange updated!');

        return redirect('workadmin/daytimechange');
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
        Daytimechange::destroy($id);

        Session::flash('flash_message', 'Daytimechange deleted!');

        return redirect('workadmin/daytimechange');
    }
}
