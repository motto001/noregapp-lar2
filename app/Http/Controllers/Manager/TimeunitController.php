<?php

namespace App\Http\Controllers\manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Timeunit;
use Illuminate\Http\Request;
use Session;

class TimeunitController extends Controller
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
            $timeunit = Timeunit::where('name', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $timeunit = Timeunit::paginate($perPage);
        }

        return view('manager.timeunit.index', compact('timeunit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.timeunit.create');
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
        
        $requestData = $request->all();
        
        Timeunit::create($requestData);

        Session::flash('flash_message', 'Timeunit added!');

        return redirect('manager/timeunit');
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

        return view('manager.timeunit.show', compact('timeunit'));
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

        return view('manager.timeunit.edit', compact('timeunit'));
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
        
        $requestData = $request->all();
        
        $timeunit = Timeunit::findOrFail($id);
        $timeunit->update($requestData);

        Session::flash('flash_message', 'Timeunit updated!');

        return redirect('manager/timeunit');
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

        return redirect('manager/timeunit');
    }
}
