<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workrole;
use Illuminate\Http\Request;
use Session;

class WorkrolesController extends Controller
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
            $workroles = Workrole::where('name', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workroles = Workrole::paginate($perPage);
        }

        return view('manager.workroles.index', compact('workroles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.workroles.create');
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
			'name' => 'required|string|max:200',
			'note' => 'string|max:200',
			'start' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Workrole::create($requestData);

        Session::flash('flash_message', 'Workrole added!');

        return redirect('manager/workroles');
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
        $workrole = Workrole::findOrFail($id);

        return view('manager.workroles.show', compact('workrole'));
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
        $workrole = Workrole::findOrFail($id);

        return view('manager.workroles.edit', compact('workrole'));
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
			'name' => 'required|string|max:200',
			'note' => 'string|max:200',
			'start' => 'string|max:200',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $workrole = Workrole::findOrFail($id);
        $workrole->update($requestData);

        Session::flash('flash_message', 'Workrole updated!');

        return redirect('manager/workroles');
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
        Workrole::destroy($id);

        Session::flash('flash_message', 'Workrole deleted!');

        return redirect('manager/workroles');
    }
}
