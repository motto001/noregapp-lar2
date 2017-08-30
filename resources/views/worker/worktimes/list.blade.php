
            
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Start</th><th>End</th><th>Óra</th><th>tipus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['worktimes'] as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->start}}</td><td>{{ $item->end }}</td><td>{{ $item->hour }}</td><td>{{ $item->type }}</td>
                                     
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                           
                        </div>

 

