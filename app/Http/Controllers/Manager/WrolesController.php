<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Wrole;
use Illuminate\Http\Request;
use Session;

class WrolesController extends Controller
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
            $wroles = Wrole::where('name', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $wroles = Wrole::paginate($perPage);
        }

        return view('manager.wroles.index', compact('wroles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.wroles.create');
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
        
        Wrole::create($requestData);

        Session::flash('flash_message', 'Wrole added!');

        return redirect('manager/wroles');
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
        $wrole = Wrole::findOrFail($id);

        return view('manager.wroles.show', compact('wrole'));
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
        $wrole = Wrole::findOrFail($id);

        return view('manager.wroles.edit', compact('wrole'));
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
        
        $wrole = Wrole::findOrFail($id);
        $wrole->update($requestData);

        Session::flash('flash_message', 'Wrole updated!');

        return redirect('manager/wroles');
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
        Wrole::destroy($id);

        Session::flash('flash_message', 'Wrole deleted!');

        return redirect('manager/wroles');
    }
}
