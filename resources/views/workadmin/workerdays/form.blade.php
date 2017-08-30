

    
        {!! Form::hidden('worker_id', $data['userid'], ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('worker_id', '<p class="help-block">:message</p>') !!}

  
        {!! Form::hidden('date', $data['year'].':'.$data['month'].':'.$data['day'], ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('date', '<p class="help-block">:message</p>') !!}

<span class="form-group {{ $errors->has('start') ? 'has-error' : ''}}">
    {!! Form::label('start', 'Start', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::input('time', 'start', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
    </div>
</span><span class="form-group {{ $errors->has('end') ? 'has-error' : ''}}">
    {!! Form::label('end', 'End', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::input('time', 'end', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
    </div>
</span><div class="form-group {{ $errors->has('hour') ? 'has-error' : ''}}">
    {!! Form::label('hour', 'Hour', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-2">
        {!! Form::number('hour', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('hour', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
   
    <div class="col-md-3">
    <select class="form-control" required="required" name="type">
        <option value="normal">normal</option>
        <option value="plusz">plusz</option>
        <option value="ledolg">ledolg</option>
    </select>   
    </div>





</div>
</br></br>
<div class="form-group">
    <div class="col-md-offset-8 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
