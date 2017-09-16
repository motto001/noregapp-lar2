@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Workeruser #{{ $workeruser->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/manager/workerusers') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />
                        @if($errors->any())
                            <ul style="list-style: none;" class="alert alert-warning">
                            @foreach($errors->getMessages() as $error)
                                @if(isset($error['message']))
                               
                                <li>{{$error['message']}}</li>
                                 @endif
                              
                            @endforeach
                            </ul>
                        @endif

                        {!! Form::model($workeruser, [
                            'method' => 'PATCH',
                            'url' => ['/manager/workerusers', $workeruser->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('manager.workerusers.formupdate', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
