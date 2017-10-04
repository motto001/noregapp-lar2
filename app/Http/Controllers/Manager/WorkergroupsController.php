<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workergroup;
use Illuminate\Http\Request;
use Session;

class WorkergroupsController extends Controller
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
            $workergroups = Workergroup::where('name', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workergroups = Workergroup::paginate($perPage);
        }

        return view('manager.workergroups.index', compact('workergroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.workergroups.create');
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
			'name' => 'required|max:200',
			'note' => 'max:200|nullable',
			'pub' => 'max:4'
		]);
        $requestData = $request->all();
        
        Workergroup::create($requestData);

        Session::flash('flash_message', 'Workergroup added!');

        return redirect('manager/workergroups');
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
        $workergroup = Workergroup::findOrFail($id);

        return view('manager.workergroups.show', compact('workergroup'));
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
        $workergroup = Workergroup::findOrFail($id);

        return view('manager.workergroups.edit', compact('workergroup'));
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
			'name' => 'required|max:200',
			'note' => 'max:200|nullable',
			'pub' => 'max:4'
		]);
        $requestData = $request->all();
        
        $workergroup = Workergroup::findOrFail($id);
        $workergroup->update($requestData);

        Session::flash('flash_message', 'Workergroup updated!');

        return redirect('manager/workergroups');
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
        Workergroup::destroy($id);

        Session::flash('flash_message', 'Workergroup deleted!');

        return redirect('manager/workergroups');
    }
}
