@extends('admin.includes.layout')
@section('header')
author
@endsection
@section('desc')
@include('admin.authors.includes.delete', compact('author'))
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">author</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ $author->title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="author">
                {!! Form::model($author, ['method' => 'PATCH',
                                'action' => ['Admin\AuthorController@update', $author],
                                'class' => 'form-horizontal']) !!}
                @include('admin.authors.includes.form')
                {!!  Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
@push('js')
<script src="{{ mix('/admin/js/author.js') }}"></script>
@endpush