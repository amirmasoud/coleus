@extends('admin.includes.layout')
@section('header')
Authors
@endsection
@section('desc')
<a href="{{ route('authors.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> New</a>
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Author</li>
@endsection
@section('content')
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="author">
                {!! Form::open(['method' => 'POST', 
                                'action' => ['Admin\AuthorController@store'], 
                                'class' => 'form-horizontal']) !!}
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
<author-extra></author-extra>
<div class="form-group">
    {!! Form::label('approved', 'Approve: ', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        
        <div class="form-group">
            <div class="radio">
                <label>
                    {!! Form::radio('approved', '1') !!}
                    Yes
                </label>
            </div>
            <div class="radio">
                <label>
                    {!! Form::radio('approved', '0') !!}
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
                {!!  Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
@endsection

@push('js')
<script src="{{ mix('/admin/js/author.js') }}"></script>
@endpush