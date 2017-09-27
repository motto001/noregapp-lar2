@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json</div>
                    <div class="panel-body">
                        <a href="{{ url('/workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json/create') }}" class="btn btn-success btn-sm" title="Add New Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                                        <th>ID</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        
                                        <td>
                                            <a href="{{ url('/workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json/' . $item->id) }}" title="View Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json/' . $item->id . '/edit') }}" title="Edit Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
