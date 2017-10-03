  <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Name</th><th>Unit</th><th>Long</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($wrole->wroleunit as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->unit }}</td><td>{{ $item->long }}</td>
                                        <td>
<button data-toggle="modal" data-remote="http://localhost:8000/manager/wroleunit-show-to-modal/{{$item->id }}" data-target="#myModel"
 class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Megnéz</button>
<a href="{{ url('/manager/wroleunits/' . $item->id . '/edit') }}" title="Edit Wroleunit"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Szerkeszt</button></a>
<a href="{{ url('/manager/wroleunit-to-del/' . $item->id . '/'.$wrole->id) }}" title="delete Wroleunit"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o" aria-hidden="true"></i>Töröl </button></a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
</div>
