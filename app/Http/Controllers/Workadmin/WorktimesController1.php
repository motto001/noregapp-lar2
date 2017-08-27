<?php

namespace App\Http\Controllers\Workadmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Worktime;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
class WorktimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $now = Carbon::now();
        $user_id =  $request->input('user_id', '0');
        $year = $request->input('year',$now->year);  
        $mounth = $request->input('mounth',$now->month );
        $date=$year.':'.$mounth ;
        $perPage = 100;

        
        $worktimes = Worktime::where(
        ['user_id','=', $user_id ],
        ['date', 'like', "$date%"]
        )->paginate($perPage);

/*
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $workers = Worker::where('user_id', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('statusz', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $workers = Worker::paginate($perPage);
        }
*/
        return view('workadmin.worktimes.index', compact('worktimes'));
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
			'year' => 'required|min:2000|max:2100',
			'mounth' => 'required|max:12',
			'day' => 'required|max:31',
			'hour' => 'max:24'
		]);
        $requestData = $request->all();
        
        Worktime::create($requestData);

        Session::flash('flash_message', 'Worktime added!');

        return redirect('workadmin/worktimes');
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
        $worktime = Worktime::findOrFail($id);

        return view('workadmin.worktimes.show', compact('worktime'));
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
        $worktime = Worktime::findOrFail($id);

        return view('workadmin.worktimes.edit', compact('worktime'));
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
			'year' => 'required|min:2000|max:2100',
			'mounth' => 'required|max:12',
			'day' => 'required|max:31',
			'hour' => 'max:24'
		]);
        $requestData = $request->all();
        
        $worktime = Worktime::findOrFail($id);
        $worktime->update($requestData);

        Session::flash('flash_message', 'Worktime updated!');

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
