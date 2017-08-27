<?php

namespace App\Handler;

use App\Http\Requests;
//use App\Http\Controllers\Controller;

use App\Workeruser;
use App\Facades\MoView;

use Session;

//class WorkerusersH extends Controller
class WorkerusersH 
{

    public function getMounths($aktiv)
    {
        $mounths=[       
            1=>['name'=>'január','class'=>'','num'=>''],
            2=>['name'=>'február','class'=>'','num'=>''],
            3=>['name'=>'Március','class'=>'','num'=>''],
            4=>['name'=>'Április','class'=>'','num'=>''],
            5=>['name'=>'Május','class'=>'','num'=>''],
            6=>['name'=>'Június','class'=>'','num'=>''],
            7=>['name'=>'Július','class'=>'','num'=>''],
            8=>['name'=>'Augusztus','class'=>'','num'=>''],
            9=>['name'=>'Szeptember','class'=>'','num'=>''],
            10=>['name'=>'Október','class'=>'','num'=>''],
            11=>['name'=>'November','class'=>'','num'=>''],
            12=>['name'=>'December','class'=>'','num'=>'']       
        ];
        $mounths[$aktiv]['class']='aktivmounth';
        return $mounths;
    }
    public function getDays($dayT,$year='0',$mounth='0',$aktiv=0)
    {
        
        return $days;
    }
    /**
     * Display a listing of the resource.
     *
     * @return  finded workeruser ob
     */
    public function getList($request,$perPage=25)
    {
        $keyword = $request->get('search');
       // $perPage = 25;

        if (!empty($keyword)) {
            $workerusers = Workeruser::whereHas('user', function($query) use($keyword) {
                $query->where('name', 'LIKE', "%$keyword%")
                ->orwhere('email', 'LIKE', "%$keyword%")
                ;
            })
                ->orwhere('user_id', 'LIKE', "%$keyword%")
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
            $workerusers = Workeruser::with('user')->paginate($perPage);
        }
       // $projects = Project::with('customer')->get();
        return $workerusers;
    }
}