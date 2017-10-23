
 {!! Form::hidden('worker_id', null, [ 'required' => 'required']) !!}

 <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    {!! Form::label('daytype_id', 'Naptipus', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
      
          {!! Form::select('daytype_id',$data['daytype'],
           null, ['class' => 'form-control', 'required' => 'required']) !!}

        {!! $errors->first('daytype_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
 
</div><div class="form-group {{ $errors->has('daytype_id') ? 'has-error' : ''}}">
    {!! Form::label('daytype_id', 'Daytype Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('daytype_id', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('daytype_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('datum') ? 'has-error' : ''}}">
    {!! Form::label('datum', 'Datum', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('datum', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('datum', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('managernote') ? 'has-error' : ''}}">
    {!! Form::label('managernote', 'Managernote', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('managernote', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('managernote', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('usernote') ? 'has-error' : ''}}">
    {!! Form::label('usernote', 'Usernote', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('usernote', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('usernote', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
