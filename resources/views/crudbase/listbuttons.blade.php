<a href="{{ url('/'.$param['baseroute'].'/' . $item->id ) }}" 
title="View "><button class="btn btn-info btn-xs">
<i class="fa fa-eye" aria-hidden="true"></i> </button></a>

<a href="{{ url('/'.$param['baseroute'].'/' . $item->id . '/edit') }}"
 title="Edit "><button class="btn btn-primary btn-xs">
 <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button></a>

{!! Form::open([
    'method'=>'DELETE',
    'url' => ['/'.$param['baseroute'], $item->id],
    'style' => 'display:inline'
]) !!}
    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> ', array(
            'type' => 'submit',
            'class' => 'btn btn-danger btn-xs',
            'title' => 'Törlés',
            'onclick'=>'return confirm("Confirm delete?")'
    )) !!}
    {!! Form::close() !!}

                                           