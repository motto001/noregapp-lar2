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
                <div class="panel-heading">Munkaidő</div>
                <div class="panel-body">


                

                        @foreach($data['months'] as $mt)
                        <a href="{{ url('/worker/worktimes/'.$data['year'].'/'.$mt['id'].'/'.$data['day'].'/'.$data['userid']) }}">
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