@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading"><b>{{ $author->name }}</b> - {{ $book->title }}</div>
        <div class="panel-body">
            @foreach($book_content as $b)
                <p>
                    <a href="{{ route('author.books.show', ['author' => $author->id, 'book' => $book->id, 'index'=>$b->key]) }}">غزل شماره {{ $b->key }}</a>
                </p>
            @endforeach
        </div>
    </div>
</div>
@endsection