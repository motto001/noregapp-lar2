@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Wrole #{{ $wrole->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/manager/wroles') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
<button type="button" class="btn btn-primary btn-xs" 
data-toggle="modal" data-remote="http://localhost:8000/manager/wroleunit-add-to-wrole-modal/{{ $wrole->id }}" data-target="#myModel">Munkarend ciklus hozzáadása</button>
  @include ('manager.wroleunits.wroleunit-list-to-wrole')

                        {!! Form::model($wrole, [
                            'method' => 'PATCH',
                            'url' => ['/manager/wroles', $wrole->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('manager.wroles.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
