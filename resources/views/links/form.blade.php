<div class="form-group {{ $errors->has('link') ? 'has-error' : ''}}">
    {!! Form::label('link', 'Link', ['class' => 'control-label']) !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
    {!! $errors->first('link', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('available_to') ? 'has-error' : ''}}">
    {!! Form::label('available_to', 'Available to', ['class' => 'control-label']) !!}
    {!! Form::date('available_to', null, ['min' => \Carbon\Carbon::now()->format('Y-m-d'),'class' => 'form-control']) !!}
    {!! $errors->first('available_to', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
