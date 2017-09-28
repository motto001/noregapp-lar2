<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    {!! Form::label('user_id', 'User Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('wrole_id') ? 'has-error' : ''}}">
    {!! Form::label('wrole_id', 'Wrole Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('wrole_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('wrole_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status_id') ? 'has-error' : ''}}">
    {!! Form::label('status_id', 'Status Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('status_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('status_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('workertype_id') ? 'has-error' : ''}}">
    {!! Form::label('workertype_id', 'Workertype Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('workertype_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('workertype_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('workergroup_id') ? 'has-error' : ''}}">
    {!! Form::label('workergroup_id', 'Workergroup Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('workergroup_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('workergroup_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('salary') ? 'has-error' : ''}}">
    {!! Form::label('salary', 'Salary', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('salary', null, ['class' => 'form-control']) !!}
        {!! $errors->first('salary', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('salary_type') ? 'has-error' : ''}}">
    {!! Form::label('salary_type', 'Salary Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('salary_type', ['órabér', 'hetibér', 'havibér'], null, ['class' => 'form-control']) !!}
        {!! $errors->first('salary_type', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('position') ? 'has-error' : ''}}">
    {!! Form::label('position', 'Position', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('position', null, ['class' => 'form-control']) !!}
        {!! $errors->first('position', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('foto') ? 'has-error' : ''}}">
    {!! Form::label('foto', 'Foto', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('foto', null, ['class' => 'form-control']) !!}
        {!! $errors->first('foto', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('fullname') ? 'has-error' : ''}}">
    {!! Form::label('fullname', 'Fullname', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('fullname', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('fullname', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('cim') ? 'has-error' : ''}}">
    {!! Form::label('cim', 'Cim', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('cim', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('cim', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tel') ? 'has-error' : ''}}">
    {!! Form::label('tel', 'Tel', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('tel', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('birth') ? 'has-error' : ''}}">
    {!! Form::label('birth', 'Birth', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('birth', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('birth', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('ado') ? 'has-error' : ''}}">
    {!! Form::label('ado', 'Ado', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('ado', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('ado', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tb') ? 'has-error' : ''}}">
    {!! Form::label('tb', 'Tb', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('tb', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('tb', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('start') ? 'has-error' : ''}}">
    {!! Form::label('start', 'Start', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('start', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('end') ? 'has-error' : ''}}">
    {!! Form::label('end', 'End', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('end', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Note', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('note', null, ['class' => 'form-control']) !!}
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('pub') ? 'has-error' : ''}}">
    {!! Form::label('pub', 'Pub', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('pub', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('pub', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
