@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Daytimes--fields_from_file=app/Http/Controllers/CrudGen/daytimes.json #{{ $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json, [
                            'method' => 'PATCH',
                            'url' => ['/workadmin/daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json', $daytimes--fields_from_file=app/http/controllers/crudgen/daytimes.json->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('workadmin.daytimes--fields_from_file=app/-http/-controllers/-crud-gen/daytimes.json.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
