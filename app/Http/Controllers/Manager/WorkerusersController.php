<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workeruser;
use App\Worker;
use App\User;
use Illuminate\Http\Request;
use App\facades\MoView;
use App\facades\WorkerusersH;
use Session;

class WorkerusersController extends Controller
{
protected $valid=[
    'name' => 'required|max:200',
    'email' => 'required|email',
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
       $workerusers=WorkerusersH::getList($request,2);
        return view('manager.workerusers.index', compact('workerusers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.workerusers.create');
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
       $userData['password'] = bcrypt($request->password);
      
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
        $workeruser = Workeruser::findOrFail($id);
        $user=User::findOrFail($workeruser['user_id']);
        $workeruser['name']=$user['name'];
        $workeruser['email']=$user['email'];

        return view('manager.workerusers.show', compact('workeruser'));
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
        $workeruser = Workeruser::findOrFail($id);
        $user=User::findOrFail($workeruser['user_id']);
        $workeruser['name']=$user['name'];
        $workeruser['email']=$user['email'];
      return view('manager.workerusers.edit', compact('workeruser'));


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
        $this->validate($request, $this->valid);
        $userData = $request->only(['name', 'email']); 
        $workerData = $request->except(['name','email']);     
        $workeruser =Workeruser::findOrFail($id);
        $user = User::findOrFail($workeruser->user_id);
        $workeruser->update($workerData); 
        $user->update( $userData); 

        Session::flash('flash_message', 'Workeruser updated!');

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
        Workeruser::destroy($id);

        Session::flash('flash_message', 'Workeruser deleted!');

        return redirect('manager/workerusers');
    }
}
