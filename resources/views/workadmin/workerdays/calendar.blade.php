<style>
.weekness{
color:red;
border: 1px solid red; 
}
.workday{
color:silver;
border: 1px solid silver; 
}
.flex-container {
    padding: 0;
    margin: 0;
    list-style: none;
    justify-content:flex-end;
    -ms-box-orient: horizontal;
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -moz-flex;
    display: -webkit-flex;
    display: flex;
  }
  .nowrap  { 
    -webkit-flex-wrap: nowrap;
    flex-wrap: nowrap;
  }

  .flex-item { 
    background: white;
    padding: 5px;
    width: 13.7%;
   /* height: 100px;*/
    margin: 0.3%;
    text-align: center;
    overflow:hidden;
  }
</style>
@php
$yearnow[]=\Carbon::now()->year-2;
$yearnow[]=\Carbon::now()->year-1;
$yearnow[]=\Carbon::now()->year;
$yearnow[]=\Carbon::now()->year+1;
$yearnow[]=\Carbon::now()->year+2;

$years=$data['years'] ?? $yearnow;

$months=['Január','Február','Március','Április','Jájus','Június','Július','Augusztus','Szeptember','Október','November','Decenber'];

@endphp
 <br><br>        
    @foreach($years  as $year)
    <a href=" {!! MoHandF::url($param['baseroute'].'/create',$param['getT'],['ev'=>$year]) !!}" 
      title="worker választás"
                          @if ($param['getT']['ev']==$year)    
                           class="btn btn-danger btn-xs">
                          @else
                           class="btn btn-warning btn-xs">
                          @endif         
                                    {!!    $year !!}
                               
                                </a>
             @endforeach  
<br><br>
             @foreach($months  as $key=>$month)
                                <a href=" {!! MoHandF::url($param['baseroute'].'/create',$param['getT'],['ho'=>$key+1]) !!}" 
                                title="worker választás"
                   @if ($param['getT']['ho']==$key+1)    
                           class="btn btn-danger btn-xs">
                          @else
                           class="btn btn-warning btn-xs">
                          @endif
                                    {!!    $month !!}
                                
                                </a>
             @endforeach 

<ul class="flex-container nowrap">
    <li class="flex-item "  style="height:40px;color:red;">Vasárnap</li>
    <li class="flex-item "  style="height:40px">Hétfő</li>
    <li class="flex-item "  style="height:40px">Kedd</li>
    <li class="flex-item "  style="height:40px">Szerda</li>
    <li class="flex-item "  style="height:40px">Csütörtök</li>
    <li class="flex-item "  style="height:40px">Péntek</li>
    <li class="flex-item "  style="height:40px; color:red;">Szombat</li>       
</ul>

    @foreach($data['calendar'] as $dt) 
     @if($dt['weeknum']==0) 
          <ul class="flex-container nowrap" style="justify-content:flex-start"> 
     @endif
        @if($dt['type']=='empty')
        <li class="flex-item" style="border: 1px solid silver;">
                   
        </li>
        @else          
        <li class="flex-item" style="border: 1px solid silver;">
        <div>{{ $dt['day'] }}.,  {{ $dt['type'] }}</div>
        <div style="display: flex;width:100%;justify-content:flex-end;border: 1px solid silver; ">            
            {!! Form::model($data, [
                            'method' => 'POST',
                            'url' =>  MoHandF::url($param['baseroute'], $param['getT'],['w_id'=>$param['getT']['w_id'],'date'=>$dt['date']]),
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}
            {!! Form::hidden('datum',$dt['date']) !!}            
           {!! Form::hidden('worker_id',$param['getT']['w_id']) !!}
            {!! Form::select('daytype_id',$data['daytype'],
           $dt['daytype_id'], ['class' => 'form-control', 'required' => 'required']) !!}
 </div>  <div> 
           <button type="submit" class="btn btn-info btn-xs">
                <i class="fa fa-save" aria-hidden="true"></i>Mentés </button>
           
           {!! Form::close() !!}      
            </div> 
                    
        </li>
             
       
        @endif 
    @if($dt['weeknum']==6) 
    </ul > 
    @endif 
    @endforeach
    