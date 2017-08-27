<div class="form-group {{ $errors->has('worker_id') ? 'has-error' : ''}}">
    {!! Form::label('worker_id', 'Worker Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('worker_id', 0, ['class' => 'form-control']) !!}
        {!! $errors->first('worker_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('year') ? 'has-error' : ''}}">
    {!! Form::label('year', 'Year', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('year', 0000, ['class' => 'form-control']) !!}
        {!! $errors->first('year', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('mounth') ? 'has-error' : ''}}">
    {!! Form::label('mounth', 'Mounth', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('mounth', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('mounth', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('day') ? 'has-error' : ''}}">
    {!! Form::label('day', 'Day', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('day', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('day', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    {!! Form::label('type', 'Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('type', ['normal', 'ünnep', 'szabadság', 'igazolt', 'beteg'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
