@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Wroletimes</div>
                    <div class="panel-body">
                        <a href="{{ url('/manager/wroletimes-to-unit/create2/'.$wroletimes['wroleunit_id']) }}" class="btn btn-success btn-sm" title="Add New Wroletime">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/manager/wroletimes-to-unit/index2/'.$wroletimes['wroleunit_id'], 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                     <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Időtipus</th><th>Start</th><th>End</th><th>Óra</th><th>Szorzó</th><th>Fixplusz</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($wroletimes['wroletimes'] as $item)
                                    <tr>
                                        <td>{{ $item->timetype->name }}</td>
                                        <td>{{ $item->start }}</td><td>{{ $item->end }}</td><td>{{ $item->hour }}</td><td>{{ $item->timetype->szorzo }}</td><td>{{ $item->timetype->fixplusz }}</td>
                                        <td>
                                        
                                            <a href="{{ url('/manager/wroletimes-to-unit/'. $item->id . '/edit') }}" 
                                            title="Edit Wroletime"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/manager/wroletimes-to-unit', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Wroletime',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                  
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
