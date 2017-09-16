<?php

namespace App\Http\Controllers\manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Freeday;
use Illuminate\Http\Request;
use Session;

class FreedayController extends Controller
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
            $freeday = Freeday::where('worker_id', 'LIKE', "%$keyword%")
				->orWhere('datum', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $freeday = Freeday::paginate($perPage);
        }

        return view('manager.freeday.index', compact('freeday'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.freeday.create');
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
        
        Freeday::create($requestData);

        Session::flash('flash_message', 'Freeday added!');

        return redirect('manager/freeday');
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
        $freeday = Freeday::findOrFail($id);

        return view('manager.freeday.show', compact('freeday'));
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
        $freeday = Freeday::findOrFail($id);

        return view('manager.freeday.edit', compact('freeday'));
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
        
        $freeday = Freeday::findOrFail($id);
        $freeday->update($requestData);

        Session::flash('flash_message', 'Freeday updated!');

        return redirect('manager/freeday');
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
        Freeday::destroy($id);

        Session::flash('flash_message', 'Freeday deleted!');

        return redirect('manager/freeday');
    }
}
