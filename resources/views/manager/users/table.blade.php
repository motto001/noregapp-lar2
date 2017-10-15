
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Name</th><th>Email</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['list']  as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td><td>{{ $item->name }}</td><td>{{ $item->email }}</td>
                                        <td>
                             @include('crudbase.listbuttons')
                                       
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                     </div>

