<?php
namespace App\Handler;
use App\Http\Requests;
use App\Workeruser;
use App\Facades\MoView;
use Session;
use Carbon\Carbon;

class WorkerusersH 
{
    public $days=['vasárnap','hétfő','kedd','szerda','csütörtök','péntek','szombat'];

    public function getMonths($aktiv='')
    {
        $class='btn btn-info btn-xs';
        $aktivclass='btn btn-primary btn-xs';
        $months=[       
            1=>['name'=>'január','class'=>$class,'id'=>'1'],
            2=>['name'=>'február','class'=>$class,'id'=>'2'],
            3=>['name'=>'Március','class'=>$class,'id'=>'3'],
            4=>['name'=>'Április','class'=>$class,'id'=>'4'],
            5=>['name'=>'Május','class'=>$class,'id'=>'5'],
            6=>['name'=>'Június','class'=>$class,'id'=>'6'],
            7=>['name'=>'Július','class'=>$class,'id'=>'7'],
            8=>['name'=>'Augusztus','class'=>$class,'id'=>'8'],
            9=>['name'=>'Szeptember','class'=>$class,'id'=>'9'],
            10=>['name'=>'Október','class'=>$class,'id'=>'10'],
            11=>['name'=>'November','class'=>$class,'id'=>'11'],
            12=>['name'=>'December','class'=>$class,'id'=>'12']       
        ];
        if($aktiv!=''){ $months[$aktiv]['class']=$aktivclass;}
       
        return $months;
    }

    public function getDate($year='0',$month='0')
    {
        $current = new Carbon();
        if($year=='0' && $month=='0'){$dt = Carbon::create($current->year,$current->month, 1, 0);}
        elseif($year=='0'){           $dt = Carbon::create($current->year, $month , 1, 0); }
        elseif($month=='0') {        $dt = Carbon::create($year, $current->month , 1, 0);}    
        else{                         $dt = Carbon::create($year, $month , 1, 0);}
        return $dt;
    }
    /*
    public function pluszEmptyDay($dayT,$first=0)
    {
        if($first>0){
            for ($i = 0; $i <= $first; $i++) {
                $dayT[]=['class'=>'emptyday','weeknum'=>$i,'date'=>$i,'name'=>$i];
            }
        }                 
        return $dayT;
    }**/

    public function getDays($dayT=[],$hourT=[],$year='0',$month='0')
    {
        $date=$this->getDate($year,$month);
        $days=[    
        ];
      //  $days=$this->pluszEmptyDay( $days,$date->dayOfWeek);
   
        $aktMonth=$date->month;
        while ($aktMonth == $date->month) { 
            $days[$date->day]=[
                'name'=>$this->days[$date->dayOfWeek],
                'date'=>$date->day,
                'weeknum'=>$date->dayOfWeek,
                'class'=>'workday',


            ];
            if($date->dayOfWeek==6 || $date->dayOfWeek==0){$days[$date->day]['class']='weekness';}
            $date->addDay();
        }  


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