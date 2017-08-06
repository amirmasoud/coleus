<div class="form-group">
    {!! Form::label('title', 'Title: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('title', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('slug', 'Slug: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('slug', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('pages', 'Pages: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('pages', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('ISBN', 'ISBN: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('ISBN', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('price', 'price: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('price', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('year', 'year: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('year', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('author_id', 'Author: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        @foreach($authors as $key => $value)
        <div class="radio">
            <label>{!! Form::radio('author_id', $value) !!} {{ $key }}</label>
        </div>
        @endforeach
    </div>
</div>
<div class="form-group">
    {!! Form::label('publisher_id', 'Publisher: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        @foreach($publishers as $key => $value)
        <div class="radio">
            <label>{!! Form::radio('publisher_id', $value) !!} {{ $key }}</label>
        </div>
        @endforeach
    </div>
</div>
<div class="form-group">
    {!! Form::label('description', 'description: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<book-extra range="{{ count(@$book->extra) }}" data="{{ json_encode(@$book->extra) }}"></book-extra>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Publish</button>
    </div>
</div>