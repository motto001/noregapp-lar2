<div class="form-group {{ $errors->has('workrole_id') ? 'has-error' : ''}}">
    {!! Form::label('workrole_id', 'Workrole Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('workrole_id', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('workrole_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('timeunit_id') ? 'has-error' : ''}}">
    {!! Form::label('timeunit_id', 'Timeunit Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('timeunit_id', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('timeunit_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('worktime_id') ? 'has-error' : ''}}">
    {!! Form::label('worktime_id', 'Worktime Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('worktime_id', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('worktime_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
