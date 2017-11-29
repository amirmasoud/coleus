@extends('admin.includes.layout')
@section('header')
Comment
@endsection
@section('desc')
@include('admin.comments.includes.delete', compact('comment'))
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">comment</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ $comment->title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::model($comment, ['method' => 'PATCH',
                                'action' => ['Admin\CommentController@update', $comment],
                                'class' => 'form-horizontal',
                                'files' => true]) !!}
                @include('admin.comments.includes.form')
                {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
