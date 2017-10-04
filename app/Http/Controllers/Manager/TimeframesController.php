<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Daytype;
use App\Timeframe;
use Illuminate\Http\Request;
use Session;

class TimeframesController extends Controller
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
            $timeframes = Timeframe::where('name', 'LIKE', "%$keyword%")
				->orWhere('unit', 'LIKE', "%$keyword%")
				->orWhere('long', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('hourmax', 'LIKE', "%$keyword%")
				->orWhere('hourmin', 'LIKE', "%$keyword%")
				->orWhere('note', 'LIKE', "%$keyword%")
				->orWhere('pub', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $timeframes = Timeframe::paginate($perPage);
        }

        return view('manager.timeframes.index', compact('timeframes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $timeframe['basedaytype']=Daytype::get();
        $timeframe['checked_daytype']=[5];
        return view('manager.timeframes.create',compact('timeframe'));
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
			'start' => 'required|date',
			'unit' => 'required|max:50',
			'long' => 'required',
			'note' => 'max:200',
			'pub' => 'max:4'
		]);
        $requestData = $request->all();
        
       // Timeframe::create($requestData);
        Timeframe::create($requestData)->daytype()->sync($request->daytype_id);

        Session::flash('flash_message', 'Timeframe added!');

        return redirect('manager/timeframes');
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
        $timeframe = Timeframe::findOrFail($id);

        return view('manager.timeframes.show', compact('timeframe'));
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

        $timeframe = Timeframe::with(['daytype'])->findOrFail($id);
        $timeframe['basedaytype']=Daytype::get();
    
        foreach($timeframe->daytype as $role){
            
            $checked_daytype[] =  $role->id;
        }
        $timeframe['checked_daytype']=$checked_daytype;

       // $timeframe = Timeframe::findOrFail($id);

        return view('manager.timeframes.edit', compact('timeframe'));
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
			'start' => 'required|date',
			'unit' => 'required|max:50',
			'long' => 'required',
			'note' => 'max:200',
			'pub' => 'max:4'
		]);
        $requestData = $request->all();
      
        $timeframe = Timeframe::findOrFail($id);
        
        $timeframe->update($requestData);

        $timeframe->daytype()->sync($request->daytype_id);

        //$timeframe = Timeframe::findOrFail($id);
       // $timeframe->update($requestData);

        Session::flash('flash_message', 'Timeframe updated!');

        return redirect('manager/timeframes');
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
        Timeframe::destroy($id);
        DB::table('daytype_timeframe')->where('timeframe_id', '=', $id)->delete();
        Session::flash('flash_message', 'Timeframe deleted!');

        return redirect('manager/timeframes');
    }
}
