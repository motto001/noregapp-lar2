
              
                 @foreach($data['workers']  as $worker)
                                  <a href="" title="Cancel"><button class="btn btn-warning btn-xs">
                                {!!    $worker['name'] !!}
                                    </a>
                   @endforeach  
                 
                 
                 
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Worker Id</th><th>Daytype Id</th><th>Datum</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['list']  as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->worker_id }}</td><td>{{ $item->daytype_id }}</td><td>{{ $item->datum }}</td>
                                        <td>
                                    {!! 
                                        MoHandF::linkButton([
                                        'link'=> MoHandF::url($param['baseroute'].'/'.$item->id.'/edit',$param['getT']),
                                        'fa'=>'pencil-square-o']) 
                                    !!}
                                    {!!
                                         MoHandF::delButton([
                                        'tip'=>'del',
                                        'link'=>MoHandF::url($param['baseroute'].'/'.$item->id,$param['getT']),
                                        'fa'=>'trash-o']) 
                                    !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                         </div>

 @include('workadmin.workerdays.calendar')
