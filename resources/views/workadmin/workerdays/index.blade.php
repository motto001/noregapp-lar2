@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Workerusersdays</div>
                    <div class="panel-body">
                        <a href="{{ url('/manager/workerusers/create') }}" class="btn btn-success btn-sm" title="Add New Workeruser">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/manager/workerusers', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            
                                @foreach($data['workerusers'] as $item)
                                    <div style="float:left; border: 2px solid grey;padding:10px;margin:5px;">
        
                                        <span>{{ $item->user_id }}</pan>
                                        <div>{{ $item->user->name}}</div>
                                        <div>{{ $item->user->email }}</div>
                                        
                                      
                                            <a href="{{ url('/manager/workerusers/' . $item->id) }}" title="View Workeruser"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/manager/workerdays/' . $item->id . '/edit') }}" title="Edit Workeruser"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> kiválaszt</button></a>
                                       
                                    </div>
                                @endforeach
                                <div style="clear: both;">   </div>
                            <div class="pagination-wrapper"> {!! $data['workerusers']->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>
                        @foreach($data['mounths'] as $mt)
                        <a href="{{ url('/manager/workerusers/'.$data['user'].'-'.$data['year'].'-'.$mt['id']) }}" >
                                    <div class="{{ $mt['class'] }}" style="float:left; border: 2px solid grey;padding:10px;margin:5px;">
        
                                     
                                        <div>{{ $mt['name'] }}</div>
                                       
                                        
                                      
                                          title="View Workeruser"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/manager/workerdays/' . $item->id . '/edit') }}" title="Edit Workeruser"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> kiválaszt</button></a>
                                       
                                    </div>
                         </a>           
                         @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
