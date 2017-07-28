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
            <div class="box-body" id="book">
                {!! Form::open(['method' => 'POST', 
                                'action' => ['Admin\BookController@store'], 
                                'class' => 'form-horizontal',
                                'files' => true]) !!}
                @include('admin.books.includes.form')
                {!!  Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
@endsection
@push('js')
<script src="{{ mix('/admin/js/book.js') }}"></script>
@endpush