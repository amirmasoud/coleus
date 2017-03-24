@extends('admin.includes.layout')
@section('header')
Categories
@endsection
@section('desc')
<a href="{{ route('categories.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> New</a>
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Category</li>
@endsection
@section('content')
<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">List</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['method' => 'POST',
        'action' => ['Admin\CategoryController@store'],
        'class' => 'form-horizontal',
        'files' => true]) !!}
        @include('admin.categories.includes.form')
        {!!  Form::close() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection