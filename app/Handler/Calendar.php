<?php
namespace App\Handler;
//use App\Http\Requests;
//use App\Workeruser;
//use App\Facades\MoView;
use Session;
use Carbon\Carbon;

class Calendar 
{
    public $days=['vasárnap','hétfő','kedd','szerda','csütörtök','péntek','szombat'];

    public function getMonths()
    { 
      return  [       
            1=>['name'=>'január','id'=>'1'],
            2=>['name'=>'február','id'=>'2'],
            3=>['name'=>'Március','id'=>'3'],
            4=>['name'=>'Április','id'=>'4'],
            5=>['name'=>'Május','id'=>'5'],
            6=>['name'=>'Június','id'=>'6'],
            7=>['name'=>'Július','id'=>'7'],
            8=>['name'=>'Augusztus','id'=>'8'],
            9=>['name'=>'Szeptember','id'=>'9'],
            10=>['name'=>'Október','id'=>'10'],
            11=>['name'=>'November','id'=>'11'],
            12=>['name'=>'December','id'=>'12']       
        ];    
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
    public function getFirstEmptyDays($daysnumber,$days=[])
    {
        for ($i=0; $i <= $daysnumber; $i++) { 
            $days[]=  [
                'weeknum'=>$i,
                'name'=>'Empty',
                'type'=>'empty',
                'color'=>'gray'
            ];
        }
        return $days;
    }
    public function getLastEmptyDays($daysnumber=0,$days=[])
    {
        for ($i=$daysnumber; $i <= 6; $i++) { 
            $days[]=  [
                'weeknum'=>$i,
                'name'=>'Empty',
                'type'=>'empty',
                'color'=>'gray'
            ];
        }
        return $days;
    }
    public function getDays($year='0',$month='0',$dayT=[],$timeT=[])
    {
        $date=$this->getDate($year,$month);
        if($date->dayOfWeek>0){
           $days=$this->getFirstEmptyDays($date->dayOfWeek-1); 
        }
        else{$days=[];}
        $aktMonth=$date->month;

        while ($aktMonth == $date->month) { 
            $datum=$year.'-'.$month.'-'.$date->day;
            $ujdays= [
                'name'=>$this->days[$date->dayOfWeek],
                'day'=>$date->day,
                'weeknum'=>$date->dayOfWeek,
                'date'=>$datum,
                'type'=>'workday',
            ];
            if( $date->dayOfWeek==0){$ujdays['color']='red';$ujdays['type']='weekend';}
            if($date->dayOfWeek==6 ){$ujdays['color']='red';$ujdays['type']='restday';}
            if(in_array($datum,$dayT)){
                $ujdays['type']=$dayT[$datum]['type'] ?? '';
                $ujdays['color']=$dayT[$datum]['color'] ?? '';
                $ujdays['bgcolor']=$dayT[$datum]['bgcolor'] ?? '';
                $ujdays['bordercolor']=$dayT[$datum]['bordercolor'] ?? '';
            }
            if(in_array($datum,$timeT)){$ujdays['times']=$timeT[$datum];}
            $days[]= $ujdays;
            $date->addDay();
        }  
        if($date->dayOfWeek<6){
            $days=$this->getLastEmptyDays($date->dayOfWeek,$days);
         }
        
        return $days;
    }
 
}