 @extends('workadmin.workerdays.index')
 @section('subcontent')
    <div class="container">
        <div class="row">

            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Munkaidő felvitele: 
                   <span style="color:blue;"> {{$data['username']}} </span>
                    {{$data['year']}}-{{$data['month']}}-{{$data['day']}}</h3>
                    
               
                    
                    </div>
                    <div class="panel-body">
                        <a href="{{ url('workadmin/workerdays/'.$data['year'].'/'.$data['month'].'/0/'.$data['userid']) }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @include ('workadmin.workerdays.list')
<!--/'.$data['year'].'/'.$data['month'].'/'.$data['day'].'/'.$data['userid'], 'class' => '', 'files' => true]-->
                        {!! Form::open(['url' => 'workadmin/workerdays/store']) !!}

                        @include ('workadmin.workerdays.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
