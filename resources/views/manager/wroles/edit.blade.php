@extends($param['crudview'].'.edit')
@section('form')

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-7">
        {!! Form::text('name', $data->name, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group ">    
        {!! Form::label('muszak', 'Műszak hozzáadása:', ['class' => 'col-md-3 control-label']) !!}   
<div class="col-md-7">    

@foreach($data['wroleunits_all'] as $unit)
    <a href=" {!! MoHandF::url($param['routes']['base'],$param['getT'],['wroleunit_id'=>$unit['id'],'task'=>'add_wroleunit']) !!}" 
    title="">

<button class="btn btn-warning btn-xs">

        {!!    $unit['name'] !!}
    </button>
    </a>
@endforeach


</div>
</div>

    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                   <th>Múszaknév</th><th>időegység</th><th>hossz</th><th>Munkaidők</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['wroleunits'] as $item)
                <tr>
                    <td>{{ $item->name }}</td><td>{{ $item->unit }}</td><td>{{ $item->long }}</td>
                    <td>
                    @foreach($item->wroletime as $time) 
                    {{ '['.str_limit($time->start, 5, '').'-'.str_limit($time->end, 5, '').']'  }}
                    @endforeach
                    </td>
                    <td>
         
                {!!
                     MoHandF::delButton([
                    'tip'=>'del',
                    'link'=>MoHandF::url($param['routes']['base'],$param['getT'],['wroleunit_id'=>$item->id,'task'=>'del_wroleunit']),
                    'fa'=>'trash-o']) 
                !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
</div>


<div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Note', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-7">
        {!! Form::text('note',  $data->note, ['class' => 'form-control']) !!}
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('start') ? 'has-error' : ''}}">
    {!! Form::label('start', 'Start', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-7">
        {!! Form::text('start', $data->start, ['class' => 'form-control datepicker']) !!}
        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
    </div>
</div>
        {!! Form::hidden('pub', 0) !!}

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Mentés', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

@endsection
