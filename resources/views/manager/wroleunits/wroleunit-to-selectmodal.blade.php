  <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Name</th><th>Unit</th><th>Long</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
 @php 
//print_r($wroleunits );  
 @endphp             
                                @foreach($wroleunits['wroleunits'] as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->unit }}</td><td>{{ $item->long }}</td>
                                        <td>
  
<a href="{{ url('/manager/wroleunit-select-to-save/'. $item->id . '/'.$wroleunits['wrole_id']) }}"
title="Edit Wroleunit"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> választ</button></a>
                                   
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
</div>
