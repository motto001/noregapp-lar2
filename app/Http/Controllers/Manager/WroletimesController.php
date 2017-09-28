<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Wroletime;
use Illuminate\Http\Request;
use Session;

class WroletimesController extends Controller
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
            $wroletimes = Wroletime::where('wroleunit_id', 'LIKE', "%$keyword%")
				->orWhere('timetype_id', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('workernote', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $wroletimes = Wroletime::paginate($perPage);
        }

        return view('manager.wroletimes.index', compact('wroletimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.wroletimes.create');
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
			'start' => 'required|time',
			'end' => 'time',
			'hour' => 'required|integer|max:24',
			'managernote' => 'string|max:200',
			'workernote' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Wroletime::create($requestData);

        Session::flash('flash_message', 'Wroletime added!');

        return redirect('manager/wroletimes');
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
        $wroletime = Wroletime::findOrFail($id);

        return view('manager.wroletimes.show', compact('wroletime'));
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
        $wroletime = Wroletime::findOrFail($id);

        return view('manager.wroletimes.edit', compact('wroletime'));
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
			'start' => 'required|time',
			'end' => 'time',
			'hour' => 'required|integer|max:24',
			'managernote' => 'string|max:200',
			'workernote' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $wroletime = Wroletime::findOrFail($id);
        $wroletime->update($requestData);

        Session::flash('flash_message', 'Wroletime updated!');

        return redirect('manager/wroletimes');
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
        Wroletime::destroy($id);

        Session::flash('flash_message', 'Wroletime deleted!');

        return redirect('manager/wroletimes');
    }
}
