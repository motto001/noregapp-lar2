<?php

namespace App\Http\Controllers\Workadmin\Daytimes--fields_from_file=app\Http\Controllers\CrudGen;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json;
use Illuminate\Http\Request;
use Session;

class daytimes.jsonController extends Controller
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
            $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json = Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json::paginate($perPage);
        } else {
            $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json = Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json::paginate($perPage);
        }

        return view('workadmin.daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json.index', compact('daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('workadmin.daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json.create');
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
        
        Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json::create($requestData);

        Session::flash('flash_message', 'Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json added!');

        return redirect('workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json');
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
        $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json = Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json::findOrFail($id);

        return view('workadmin.daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json.show', compact('daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json'));
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
        $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json = Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json::findOrFail($id);

        return view('workadmin.daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json.edit', compact('daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json'));
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
        
        $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json = Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json::findOrFail($id);
        $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json->update($requestData);

        Session::flash('flash_message', 'Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json updated!');

        return redirect('workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json');
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
        Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json::destroy($id);

        Session::flash('flash_message', 'Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json deleted!');

        return redirect('workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json');
    }
}
