<div class="form-group">
    {!! Form::label('email', 'Email: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::email('email', null, ['class' => 'form-control', 'dir' => 'auto', 'v-model' => "email"]) !!}
        <p class="help-block">@{{ suggestEmail }} <button type="button" class="btn bg-purple btn-xs" @click="use">use</button></p>
    </div>
</div>
<div class="form-group">
    {!! Form::label('password', 'Password: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::password('password', ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('name', 'Name: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', null, ['class' => 'form-control', 'dir' => 'auto', 'v-model' => "name"]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('slug', 'Slug: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('slug', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('born', 'Born: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::date('born', null, ['class' => 'form-control', 'dir' => 'auto']) !!}
    </div>
</div>
<author-extra range="{{ count(@$author->extra) }}" data="{{ json_encode(@$author->extra) }}"></author-extra>
<div class="form-group">
    {!! Form::label('approved', 'Approve: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        
        <div class="form-group">
            <div class="radio">
                <label>
                    {!! Form::radio('approved', '1', $author->approved) !!}
                    Yes
                </label>
            </div>
            <div class="radio">
                <label>
                    {!! Form::radio('approved', '0', !$author->approved) !!}
                    No
                </label>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>