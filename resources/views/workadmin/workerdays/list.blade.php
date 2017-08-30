
            
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Start</th><th>End</th><th>Óra</th><th>tipus</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['worktimes'] as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->start}}</td><td>{{ $item->end }}</td><td>{{ $item->hour }}</td><td>{{ $item->type }}</td>
                                        <td>
                                            
                                        <!--    <a href="{{ url('/workadmin/worktimes/' . $item->id . '/edit') }}" title="Edit Worktime"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>-->
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/workadmin/workerdays', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Worktime',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                           
                        </div>

 

