<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Worker;
use App\User;
use Illuminate\Http\Request;
use App\facades\MoView;
//use App\facades\WorkerusersH;
use Illuminate\Support\Facades\View;
use Session;
class WorkerusersController extends Controller
{
use SoftDeletes;   
protected $valid=[
    //'user_id'=>'required|integer',
    'name' => 'required|max:200',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:6|max:100',
    'cim' => 'required|max:200',
    'tel' => 'max:50',
    'birth' => 'date',
    'ado' => 'string',
    'tb' => 'string',
    'start' => 'required|date',
    'end' => 'date',
    'statusz' => 'max:50'
];
protected $baseUrl='manager/workeruser/';

public function __construct(){
    $request=new Request();

    if ($request->is('json/*')) {
        $this->baseUrl='json/'. $this->baseUrl;
    }
  //  config('moapp.baseUrl', $this->baseUrl);
    \Config::set('moapp.baseUrl', $this->baseUrl );
    View::share('baseUrl', config('moapp.baseUrl'));

}

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
            $workerusers = Worker::with('user')->where('user_id', 'LIKE', "%$keyword%")
			//	->orWhere('name', 'LIKE', "%$keyword%")
				->orWhere('cim', 'LIKE', "%$keyword%")
				->orWhere('tel', 'LIKE', "%$keyword%")
				->orWhere('birth', 'LIKE', "%$keyword%")
				->orWhere('ado', 'LIKE', "%$keyword%")
				->orWhere('tb', 'LIKE', "%$keyword%")
				->orWhere('start', 'LIKE', "%$keyword%")
				->orWhere('end', 'LIKE', "%$keyword%")
				->orWhere('statusz', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $workerusers = Worker::with('user')->paginate($perPage);
        }

  
        return view('manager.workerusers.index', compact('workerusers'));
        //return  MoView::view( 'manager.workerusers.index',$workerusers,'workerusers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $workerusers['baseUrl']=$this->baseUrl;
        return view('manager.workerusers.create', compact('workerusers'));
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
        $this->validate($request, $this->valid);

        $userData = $request->only(['name', 'email']); 
        $user = new User($userData);
        $user->save();

        $workerData = $request->except(['name', 'password','email']);    
        $workerData['user_id']=$user->id;
        $user->Workeruser()->create($workerData);

        Session::flash('flash_message', 'Workeruser added!');
        return redirect('manager/workerusers');

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
        $workeruser = Worker::with('user')->findOrFail($id);
      //  $user=User::findOrFail($workeruser['user_id']);
      //  $workers['name']=$user['name'];
      //  $workers['email']=$user['email'];
       // return view('manager.workerusers.show', compact('workeruser'));
       return  MoView::view( 'manager.workerusers.show',$workeruser,'workeruser');
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
        $workeruser = Worker::with('user')->findOrFail($id);
        $workeruser['email']=$workeruser->user->email;
        $workeruser['name']=$workeruser->user->name;
        return  MoView::view( 'manager.workerusers.edit',$workeruser,'workeruser'); 
     // return view('manager.workerusers.edit', compact('workeruser'));


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
        $workeruser =Worker::findOrFail($id);
        $user = User::findOrFail($workeruser->user_id);
        $this->validate($request, [
        'name' => 'required|max:200|min:4',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'cim' => 'required|max:200',
        'tel' => 'max:50',
        'birth' => 'date',
        'ado' => 'string',
        'tb' => 'string',
        'start' => 'required|date',
        'end' => 'date',
        'statusz' => 'max:50']
       );
    
        $userData = $request->only(['name', 'email']); 
        $workerData = $request->except(['name','email']);   
       
        
        
        $workeruser->update($workerData); 
        $user->update( $userData); 

        Session::flash('flash_message', 'Workeruser updated!');
       // return response()->json($error,200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
       return redirect('manager/workerusers');
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
        Worker::destroy($id);

        Session::flash('flash_message', 'Workeruser deleted!');

        return redirect('manager/workerusers');
    }
}
