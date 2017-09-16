<?php

namespace App\Http\Controllers\manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workertype;
use Illuminate\Http\Request;
use Session;

class WorkertypeController extends Controller
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
            $workertype = Workertype::where('name', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workertype = Workertype::paginate($perPage);
        }

        return view('manager.workertype.index', compact('workertype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.workertype.create');
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
        
        Workertype::create($requestData);

        Session::flash('flash_message', 'Workertype added!');

        return redirect('manager/workertype');
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

        return view('manager.workertype.show', compact('workertype'));
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

        return view('manager.workertype.edit', compact('workertype'));
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
        
        $workertype = Workertype::findOrFail($id);
        $workertype->update($requestData);

        Session::flash('flash_message', 'Workertype updated!');

        return redirect('manager/workertype');
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

        return redirect('manager/workertype');
    }
}
