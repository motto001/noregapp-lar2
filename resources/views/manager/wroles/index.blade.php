 @extends($param['crudview'].'.index')
@section('table')
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Name</th><th>Note</th><th>Start</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['list'] as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->note }}</td><td>{{ $item->start }}</td>
                                        <td>
                                             {!! 
                                        MoHandF::linkButton([
                                        'link'=> MoHandF::url($param['route'].'/'.$item->id.'/edit',$param['getT']),
                                        'fa'=>'pencil-square-o']) 
                                    !!}
                                    {!!
                                         MoHandF::delButton([
                                        'tip'=>'del',
                                        'link'=>MoHandF::url($param['route'].'/'.$item->id,$param['getT']),
                                        'fa'=>'trash-o']) 
                                    !!} 
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
 @endsection
