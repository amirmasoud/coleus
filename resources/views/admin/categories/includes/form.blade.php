<div class="form-group">
    {!! Form::label('name', 'Name: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('description', 'Description: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('cover', 'Cover: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::file('cover', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('category_id', 'Category: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('category_id', $categories, null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>