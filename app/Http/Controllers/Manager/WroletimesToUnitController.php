<?php

namespace App\Http\Controllers\Manager;

//use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Timetype;
use App\Wroletime;
use Illuminate\Http\Request;
use Session;

class WroletimesToUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return redirect('manager/wroletimes');
    }
    public function index2($unit_id,Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $wroletimes2 = Wroletime::where('wroleunit_id', '=', $unit_id)
				->orWhere('timetype_id', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('hour', 'LIKE', "%$keyword%")
				->orWhere('managernote', 'LIKE', "%$keyword%")
				->orWhere('workernote', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $wroletimes2 = Wroletime::where('wroleunit_id', '=', $unit_id)
            ->with('timetype')->paginate($perPage);
        }
       
        $wroletimes['wroletimes']=$wroletimes2;
        $wroletimes['wroleunit_id']=$unit_id;
      
        return view('manager.wroletimes.index2', compact('wroletimes'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
     public function create()
     {
        return redirect('manager/wroletimes');
     }

    public function create2($unit_id)
    {
        $wroletimes = Wroletime::get();
        $wroletimes['timetype']= Timetype::pluck('name','id');
        $wroletimes['wroleunit_id']= $unit_id;
        return view('manager.wroletimes.create2',compact('wroletimes'));
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
			'wroleunit_id' => 'required|integer',
			'timetype_id' => 'required|integer',
			'start' => 'required|date_format:H:i',
			'end' => 'date_format:H:i',
			'hour' => 'required|integer|max:24',
			'managernote' => 'string|max:200|nullable',
			'workernote' => 'string|max:200|nullable',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        Wroletime::create($requestData);

        Session::flash('flash_message', 'Wroletime added!');

        return redirect('manager/wroletimes-to-unit/index2/'.$request->wroleunit_id);
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
        $wroletimes = Wroletime::findOrFail($id);
        $wroletimes['timetype']= Timetype::pluck('name','id');
        $wroletimes['wroleunit_id']= $wroletimes->wroleunit_id;

        $wroletimes->start=substr( $wroletimes->start, 0, -3);
        $wroletimes->end=substr( $wroletimes->end, 0, -3);
        return view('manager.wroletimes.edit2', compact('wroletimes'));
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
            'wroleunit_id' => 'required|integer',
			'timetype_id' => 'required|integer',
			'start' => 'required|date_format:H:i',
			'end' => 'date_format:H:i',
			'hour' => 'required|integer|max:24',
			'managernote' => 'string|max:200|nullable',
			'workernote' => 'string|max:200|nullable',
			'pub' => 'integer'
		]);
        $requestData = $request->all();
        
        $wroletime = Wroletime::findOrFail($id);
        $wroletime->update($requestData);

        Session::flash('flash_message', 'Wroletime updated!');

        return redirect('manager/wroletimes-to-unit/index2/'.$request->wroleunit_id);
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
        $wroletime = Wroletime::findOrFail($id);
        Wroletime::destroy($id);

        Session::flash('flash_message', 'Wroletime deleted!');

        return redirect('manager/wroletimes-to-unit/index2/'. $wroletime->wroleunit_id);
    }
}
