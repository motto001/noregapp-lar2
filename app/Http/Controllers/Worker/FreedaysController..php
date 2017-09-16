<?php

namespace App\Http\Controllers\Workadmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Worktime;
use Illuminate\Http\Request;
use Session;

class FreedayaController extends Controller
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
            $worktimes = Worktime::where('worker_id', 'LIKE', "%$keyword%")
				->orWhere('date', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('type', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $worktimes = Worktime::paginate($perPage);
        }

        return view('worker.freedays.index', compact('worktimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('workadmin.worktimes.create');
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
			'worker_id' => 'required|integer',
			'date' => 'required|date',
			'start' => 'date_format:H:i',
			'end' => 'date_format:H:i',
			'hour' => 'required|date_format:H',
			'type' => 'required'
		]);
        $requestData = $request->all();
        
        Worktime::create($requestData);

        Session::flash('flash_message', 'Worktime added!');

        return redirect('workadmin/worktimes');
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
        Worktime::destroy($id);

        Session::flash('flash_message', 'Worktime deleted!');

        return redirect('workadmin/worktimes');
    }
}
