@extends('layouts.backend') 
@section('content')
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
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Workerusersdays</div>
                <div class="panel-body">


                    {!! Form::open(['method' => 'GET', 'url' => '/manager/workerusers/'.$data['year'].'/'.$data['month'].'/'.$data['day'].'/'.$data['userid'], 'class' => 'navbar-form navbar-right', 'role' => 'search']) !!}
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search...">
                        <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                        </span>
                    </div>
                    {!! Form::close() !!}

            
                    <ul class="flex-container nowrap"  style="justify-content:flex-start"> 

                        @foreach($data['workerusers'] as $item)
                           
   
                                <li class="flex-item " style="width:20%;border: 1px solid 
                             @if($data['userid']==$item->user_id )
                                red
                                @else
                                silver
                                @endif
                                 " >

                                    <span>{{ $item->user_id }} </span>
                                    <div> {{ $item->user->name}}</div>
                                    <div style="display: flex;width:100%;justify-content:flex-end; ">            
                                        <a href="{{ url('/manager/workerusers/' . $item->id) }}" 
                                        title="View Workeruser"><button class="btn btn-info btn-xs">
                                        <i class="fa fa-eye" aria-hidden="true"></i> </button>
                                        </a>
                                        <a href="{{ url('/workadmin/workerdays/'.$data['year'].'/'.$data['month'].'/'.$data['day'].'/'.$item->user_id) }}"
                                        title="Edit Workeruser"><button class="btn btn-primary btn-xs">
                                        <i class="fa fa-checked" aria-hidden="true">Kijelöl</i></button>
                                        </a>
                                    </div>            
                                </li>       
 
                        @endforeach
                     </ul>

                        <div style="clear: both;"></div>
                        <div class="pagination-wrapper"> {!! $data['workerusers']->appends(['search' => Request::get('search')])->render() !!}</div>
                        @foreach($data['months'] as $mt)
                        <a href="{{ url('/workadmin/workerdays/'.$data['year'].'/'.$mt['id'].'/'.$data['day'].'/'.$data['userid']) }}">
                            <button class="{{ $mt['class'] }}">
                                        
                                            <div>{{ $mt['name'] }}</div>
                        
                            </button>
                        </a>
                        @endforeach
<hr>                        
                        <div style="clear:both"></div>
                       @yield('subcontent')
                     
                     

                </div>
            </div>
        </div>
    </div>
</div>
@endsection