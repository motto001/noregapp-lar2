<?php

namespace App\Http\Controllers\Workadmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workeruser;
use App\Worker;
use App\User;
use Illuminate\Http\Request;
use App\Facades\MoView;
use App\Facades\WorkerusersH;
use Session;

class WorkersController extends Controller
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
        return view('workadmin.workers.index', compact('workerusers'));
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

        return view('workadmin.workers.show', compact('workeruser'));
    }

}
