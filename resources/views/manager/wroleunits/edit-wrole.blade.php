@
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Wroleunit #{{ $wrole->wroleunit->id }}</div>
                    <div class="panel-body">
                      
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
@include('manager.wroletimes.list')
                        {!! Form::model($wroleunit, [
                            'method' => 'PATCH',
                            'url' => ['/manager/wrole/', $wroleunit->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('manager.wroleunits.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
       
