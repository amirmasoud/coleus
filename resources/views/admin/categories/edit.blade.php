@extends('admin.includes.layout')
@section('header')
Category
@endsection
@section('desc')
@include('admin.categories.includes.delete', compact('category'))
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">category</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ $category->title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {{ Html::image($category->cover(), 'slider',['class' => 'img-responsive center-block', 'width' => '800']) }}
                <hr>
                {!! Form::model($category, ['method' => 'PATCH',
                                'action' => ['Admin\CategoryController@update', $category],
                                'class' => 'form-horizontal',
                                'files' => true]) !!}
                @include('admin.categories.includes.form')
                {!!  Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection