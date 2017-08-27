<?php

namespace App\Http\Controllers\Workadmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Day;
use Illuminate\Http\Request;
use Session;

class DaysController extends Controller
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
            $days = Day::where('worker_id', 'LIKE', "%$keyword%")
				->orWhere('year', 'LIKE', "%$keyword%")
				->orWhere('mounth', 'LIKE', "%$keyword%")
				->orWhere('day', 'LIKE', "%$keyword%")
				->orWhere('type', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $days = Day::paginate($perPage);
        }

        return view('workadmin.days.index', compact('days'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('workadmin.days.create');
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
			'year' => 'integer',
			'mounth' => 'required|integer',
			'day' => 'required|integer',
			'type' => 'required'
		]);
        $requestData = $request->all();
        
        Day::create($requestData);

        Session::flash('flash_message', 'Day added!');

        return redirect('workadmin/days');
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
        $day = Day::findOrFail($id);

        return view('workadmin.days.show', compact('day'));
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
        $day = Day::findOrFail($id);

        return view('workadmin.days.edit', compact('day'));
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
			'year' => 'integer',
			'mounth' => 'required|integer',
			'day' => 'required|integer',
			'type' => 'required'
		]);
        $requestData = $request->all();
        
        $day = Day::findOrFail($id);
        $day->update($requestData);

        Session::flash('flash_message', 'Day updated!');

        return redirect('workadmin/days');
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
        Day::destroy($id);

        Session::flash('flash_message', 'Day deleted!');

        return redirect('workadmin/days');
    }
}
