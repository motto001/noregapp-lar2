<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\DB;
use App\Wroleunit;
use App\Daytype;
use App\Wroletime;
use Illuminate\Http\Request;
use Session;

class WroleunitsController extends Controller
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
            $wroleunits = Wroleunit::where('name', 'LIKE', "%$keyword%")
				->orWhere('unit', 'LIKE', "%$keyword%")
				->orWhere('long', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $wroleunits = Wroleunit::paginate($perPage);
        }

        return view('manager.wroleunits.index', compact('wroleunits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $wroleunit['basedaytype']=Daytype::get();
        $wroleunit['checked_daytype']=[5];
        return view('manager.wroleunits.create', compact('wroleunit'));
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
			'name' => 'required|string',
			'unit' => 'required|string',
			'long' => 'required|integer',
			'note' => 'string|max:200|nullable',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $wroleunit= Wroleunit::create($requestData);
        $wroleunit->daytype()->sync($request->daytype_id);
        Session::flash('flash_message', 'Wroleunit added!');

        return redirect('manager/wroleunits/'.$wroleunit->id.'/edit');

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
        $wroleunit = Wroleunit::findOrFail($id);

        return view('manager.wroleunits.show', compact('wroleunit'));
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
              
        $wroleunit = Wroleunit::with(['daytype','wroletime','wroletime.timetype'])->findOrFail($id);
        $wroleunit['basedaytype']=Daytype::get();
    
        foreach($wroleunit->daytype as $role){
            
            $checked_daytype[] =  $role->id;
        }
        $wroleunit['checked_daytype']=$checked_daytype;
       
        return view('manager.wroleunits.edit', compact('wroleunit'));
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
			'name' => 'required|string',
			'unit' => 'required|string',
			'long' => 'required|integer',
			'note' => 'string|max:200|nullable',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $wroleunit = Wroleunit::findOrFail($id);
        
        $wroleunit->update($requestData);

        $wroleunit->daytype()->sync($request->daytype_id);

        Session::flash('flash_message', 'Wroleunit updated!');

        return redirect('manager/wroleunits');
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
        Wroleunit::destroy($id);
        //->timetype()->detach('timetype_id');
        DB::table('wroleunit_daytype')->where('wroleunit_id', '=', $id)->delete();
        Session::flash('flash_message', 'Wroleunit deleted!');

        return redirect('manager/wroleunits');
    }
     public function wroleunitToModal($wroleid)
    {
        $wroleunits2 = Wroleunit::get();
       // print_r($wroleunits);
       $wroleunits['wroleunits']=$wroleunits2;
        $wroleunits['wrole_id']=$wroleid;
        return view('manager.wroleunits.wroleunit-to-selectmodal', compact('wroleunits'));
    }
    public function showToModal($id)
    {
        $wroleunit = Wroleunit::with(['daytype','wroletime','wroletime.timetype'])->findOrFail($id);
        $wroleunit['basedaytype']=Daytype::get();
    
        foreach($wroleunit->daytype as $role){
            
            $checked_daytype[] =  $role->id;
        }
        $wroleunit['checked_daytype']=$checked_daytype;
        return view('manager.wroleunits.show-to-modal', compact('wroleunit'));
    }
    public function timedel($id)
    {
        Wroletime::destroy($id);
        return redirect('manager/wroleunits');
    }

}
