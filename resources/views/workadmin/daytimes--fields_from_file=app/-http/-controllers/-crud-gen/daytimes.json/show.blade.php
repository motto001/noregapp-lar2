@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json {{ $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json/' . $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json->id . '/edit') }}" title="Edit Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['workadmin/daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json', $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json->id }}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
