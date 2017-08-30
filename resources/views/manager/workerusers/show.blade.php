@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Workeruser {{ $workeruser->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/manager/workerusers') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/manager/workerusers/' . $workeruser->id . '/edit') }}" title="Edit Workeruser"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['manager/workerusers', $workeruser->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Workeruser',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><th>ID</th><td>{{ $workeruser->id }}</td></tr>
                                    <tr><th> User Id </th><td> {{ $workeruser->user_id }} </td></tr>
                                    <tr><th> Name </th><td> {{ $workeruser['name'] }} </td></tr>
                                    <tr><th> Email </th><td> {{ $workeruser['email'] }} </td></tr>
                                    <tr><th> Cim </th><td> {{ $workeruser->cim }} </td></tr>
                                    <tr><th>Tel </th><td> {{ $workeruser->tel }} </td></tr>
                                    <tr><th> Birth</th><td> {{ $workeruser->birth }} </td></tr>
                                    <tr><th> Ado </th><td> {{ $workeruser->ado }} </td></tr>
                                    <tr><th> Cim </th><td> {{ $workeruser->cim }} </td></tr>
                                    <tr><th> Tb</th><td> {{ $workeruser->tb }} </td></tr>
                                    <tr><th> Kezdés </th><td> {{ $workeruser->start }} </td></tr>
                                    <tr><th> Befejezés</th><td> {{ $workeruser->end }} </td></tr>
                                    <tr><th> Statusz </th><td> {{ $workeruser->statusz }} </td></tr>


                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
