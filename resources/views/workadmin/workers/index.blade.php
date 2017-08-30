@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Dolgozók</div>
                    <div class="panel-body">

                      

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>User Id</th><th>email</th><<th>Name</th><th>Cim</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($workerusers as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->user_id }}</td>
                                        <td>{{ $item->user->email }}</td>
                                        <td>{{ $item->user->name}}</td>
                                        <td>{{ $item->cim }}</td>
                                        <td>
                                            <a href="{{ url('/workadmin/workers/' . $item->id) }}" title="View Workeruser"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                        
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $workerusers->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
