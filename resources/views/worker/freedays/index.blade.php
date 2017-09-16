@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Days</div>
                    <div class="panel-body">
                        <a href="{{ url('/workadmin/days/create') }}" class="btn btn-success btn-sm" title="Add New Day">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/workadmin/days', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}
<!-- list------------------------------------------------------------------------>-
                         @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/workadmin/days', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('workadmin.days.form')

                        {!! Form::close() !!}


<!-- /list------------------------------------------------------------------------>-


                     
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>date</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($days as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                       <td>{{ $item->date }}</td>
                                        <td>
                                @if({{ $item->pub==0 }})        
                                    {!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => ['/workadmin/days', $item->id],
                                        'style' => 'display:inline'
                                    ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-xs',
                                                'title' => 'Delete Day',
                                                'onclick'=>'return confirm("Confirm delete?")'
                                        )) !!}
                                    {!! Form::close() !!}
                                @elseif({{ $item->pub==1 }})
                                   
                                    <span class="btn btn-success btn-sm" 
                                    <i class="fa fa-check" aria-hidden="true"></i> Engedélyezve
                                     </span>
                              
                               @else
                                   
                                    <span class="btn btn-info btn-sm" 
                                    <i class="fa fa-plus" aria-hidden="true"></i> Elutasítva
                                     </span>
                              
                                @endif            
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $days->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
