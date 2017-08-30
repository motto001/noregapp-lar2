<?php

namespace App\Http\Controllers\Worker;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Workeruser;
use App\User;
use Illuminate\Http\Request;
use Session;
use Auth;
//use Illuminate\Foundation\Auth\User;
class WorkersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user=User::findOrFail(Auth::id());
        $workeruser = Workeruser::where('user_id', 4)->firstOrFail();
       // $workeruser = Workeruser::findOrFail(1);
        $workeruser['name']=$user['name'];
        $workeruser['email']=$user['email'];
        //print_r($user);
             return view('worker.personal.show', compact('workeruser'));
   
    }

}
