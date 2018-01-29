{!! Form::model($data, [
    'method' => 'PATCH',
    'url' => MoHandF::url($param['routes']['base'].'/'.$data['id'],$param['getT']),
    'class' => 'form-horizontal',
    'files' => true
]) !!}

</br></br></br>
<div class="form-group {{ $errors->has('start') ? 'has-error' : ''}} {{ $errors->has('end') ? 'has-error' : ''}} {{ $errors->has('hour') ? 'has-error' : ''}}">
    {!! Form::label('timetype_id', 'Időtipus', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::select('timetype_id',  $data['timetype'], null, ['class' => 'form-control', 'required' => 'required']) !!}    
         {!! $errors->first('timetype_id', '<p class="help-block">:message</p>') !!}
    </div>
   
    {!! Form::label('start', 'kezdés', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::input('time', 'start', null , ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
    
    </div> 
    {!! Form::label('end', 'Befejezés', ['class' => 'col-md-1 control-label']) !!}  
    <div class="col-md-2">
        {!! Form::input('time', 'end',null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
    </div>
    {!! Form::label('hour', 'Óraszám', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-1">
        {!! Form::number('hour', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('hour', '<p class="help-block">:message</p>') !!}
    </div>
  
</div>

<div class="form-group {{ $errors->has('start') ? 'has-error' : ''}} {{ $errors->has('end') ? 'has-error' : ''}} {{ $errors->has('hour') ? 'has-error' : ''}}">

    {!! Form::label('datestart', 'Kezdődátum', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::input('text', 'datestart', null , ['class' => 'form-control datepicker', 'required' => 'required']) !!}
        {!! $errors->first('datestart', '<p class="help-block">:message</p>') !!}
     
    </div>  
    {!! Form::label('dateend', 'Befejeződátum', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::input('text', 'dateend',null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
        {!! $errors->first('dateend', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" col-md-1">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Mentés', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
  
    
</div>

<div class="form-group">
    
</div>
{!! Form::close() !!}