<div class="form-group {{ $errors->has('worker_id') ? 'has-error' : ''}}">
    {!! Form::label('worker_id', 'Worker Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('worker_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('worker_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('datum') ? 'has-error' : ''}}">
    {!! Form::label('datum', 'Datum', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('datum', null, ['class' => 'form-control']) !!}
        {!! $errors->first('datum', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('pub') ? 'has-error' : ''}}">
    {!! Form::label('pub', 'Pub', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('pub', null, ['class' => 'form-control']) !!}
        {!! $errors->first('pub', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
