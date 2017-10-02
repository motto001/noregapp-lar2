
                    <div class="panel-body">
                        <a href="{{ url('/manager/wroletimes/create') }}" class="btn btn-success btn-sm" title="Add New Wroletime">
                            <i class="fa fa-plus" aria-hidden="true"></i> uj időegység
                        </a>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Időtipus</th><th>Start</th><th>End</th><th>Óra</th><th>Szorzó</th><th>Fixplusz</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($wroleunit->wroletime as $item)
                                    <tr>
                                        <td>{{ $item->timetype->name }}</td>
                                        <td>{{ $item->start }}</td><td>{{ $item->end }}</td><td>{{ $item->hour }}</td><td>{{ $item->timetype->szorzo }}</td><td>{{ $item->timetype->fixplusz }}</td>
                                        <td>
                                        
                                            <a href="{{ url('/manager/wroletimes/' . $item->id . '/edit') }}" title="Edit Wroletime"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/manager/wroletimes', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Wroletime',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
       
                        </div>
                     </div>   