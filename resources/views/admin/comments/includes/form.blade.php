<div class="form-group">
    {!! Form::label('name', 'Name: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('email', 'Email: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::email('email', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('text', 'Text: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::textarea('text', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('is_moderated', 'Moderate: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <div class="radio">
            <label>
                {{ Form::radio('is_moderated', 1) }}
                Published
            </label>
        </div>
        <div class="radio">
            <label>
                {{ Form::radio('is_moderated', 0) }}
                Pending
            </label>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
