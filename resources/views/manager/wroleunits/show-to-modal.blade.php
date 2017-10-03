             <div class="panel panel-default">
                    <div class="panel-heading">Show Wroleunit #{{ $wroleunit->id }}</div>
                    <div class="panel-body">
             
@include('manager.wroletimes.list')
                        {!! Form::model($wroleunit, [
                            'method' => 'PATCH',
                            'url' => ['/manager/wroleunits', $wroleunit->id],
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
