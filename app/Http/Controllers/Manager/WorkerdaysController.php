<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workerday;
use Illuminate\Http\Request;
use Session;

class WorkerdaysController extends Controller
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
            $workerdays = Workerday::where('worker_id', 'LIKE', "%$keyword%")
				->orWhere('daytype_id', 'LIKE', "%$keyword%")
				->orWhere('datum', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('usernote', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workerdays = Workerday::paginate($perPage);
        }

        return view('manager.workerdays.index', compact('workerdays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.workerdays.create');
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
			'worker_id' => 'integer',
			'daytype_id' => 'integer',
			'datum' => 'required|date',
			'managernote' => 'string|max:150',
			'usernote' => 'string|max:150'
		]);
        $requestData = $request->all();
        
        Workerday::create($requestData);

        Session::flash('flash_message', 'Workerday added!');

        return redirect('manager/workerdays');
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
        $workerday = Workerday::findOrFail($id);

        return view('manager.workerdays.show', compact('workerday'));
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
        $workerday = Workerday::findOrFail($id);

        return view('manager.workerdays.edit', compact('workerday'));
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
			'worker_id' => 'integer',
			'daytype_id' => 'integer',
			'datum' => 'required|date',
			'managernote' => 'string|max:150',
			'usernote' => 'string|max:150'
		]);
        $requestData = $request->all();
        
        $workerday = Workerday::findOrFail($id);
        $workerday->update($requestData);

        Session::flash('flash_message', 'Workerday updated!');

        return redirect('manager/workerdays');
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
        Workerday::destroy($id);

        Session::flash('flash_message', 'Workerday deleted!');

        return redirect('manager/workerdays');
    }
}
