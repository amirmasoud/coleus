@extends('admin.includes.layout')
@section('header')
Book
@endsection
@section('desc')
<a href="{{ route('books.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> New</a>
@endsection
@section('breadcrumb')
<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">Book</li>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                @if (!$books->isEmpty())
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <th>title</th>
                            <th>ISBN</th>
                            <th>pages</th>
                            <th>price</th>
                            <th>year</th>
                            <th>description</th>
                            <th>author</th>
                            <th>publisher</th>
                        </tr>
                        @foreach($books as $book)
                        <tr onclick="window.document.location='{{ route('books.edit', ['book' => $book]) }}';" class="tr-hover">
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->ISBN }}</td>
                            <td>{{ $book->pages }}</td>
                            <td>{{ $book->price }}</td>
                            <td>{{ $book->year }}</td>
                            <td>{{ $book->description }}</td>
                            <td>{{ $book->author->name }}</td>
                            <td>{{ $book->publisher->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                @include('admin.components.empty')
                @endif
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                @include('admin.includes.pagination', ['resource' => $books])
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection