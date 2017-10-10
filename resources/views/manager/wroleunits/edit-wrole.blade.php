
 @extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Wroletime #{{ $data->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/manager/wroleunits') }}" title="Back"><button class="btn btn-warning btn-sm">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Visza</button></a>
                        <a href="{{ '/manager/wroletimes-to-unit/?routeparam='.$data->id }}" class="btn btn-success btn-sm" title="Add New Wroletime">
                            <i class="fa fa-plus" aria-hidden="true"></i> Új munkaidő hozzáadása
                        </a>
                        
                        <br />
                        <br />  
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
@include('manager.wroletimes.table')
                        {!! Form::model($data, [
                            'method' => 'PATCH',
                            'url' => ['/manager/wrole/', $data->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('manager.wroleunits.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                     </div>
                </div>
            </div>
        </div>
    </div>
@endsection

       
