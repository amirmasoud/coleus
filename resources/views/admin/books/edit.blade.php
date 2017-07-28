@extends('admin.includes.layout')
@section('header')
book
@endsection
@section('desc')
@include('admin.books.includes.delete', compact('book'))
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">book</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ $book->title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="book">
                {!! Form::model($book, ['method' => 'PATCH',
                                'action' => ['Admin\BookController@update', $book],
                                'class' => 'form-horizontal',
                                'files' => true]) !!}
                @include('admin.books.includes.form')
                {!!  Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
@push('js')
<script src="{{ mix('/admin/js/book.js') }}"></script>
@endpush