@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Daytimechange #{{ $daytimechange->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/workadmin/daytimechange') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($daytimechange, [
                            'method' => 'PATCH',
                            'url' => ['/workadmin/daytimechange', $daytimechange->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('workadmin.daytimechange.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection