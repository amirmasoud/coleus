@extends('layouts.blog')
@section('content')
@foreach ($books as $book)
<div class="col-xs-6 col-sm-4 col-md-2">
    <a href="{{ route('author.books.index', ['autohr' => $book->author->id, 'book' => $book->id]) }}">
        <div class="thumbnail">
            <img src="{{ asset('covers/' . $book->extra['cover']) }}" class="img-responsive" alt="hafez">
            <div class="caption">
                <h5 class="text-center">{{ $book->title }}</h5>
            </div>
        </div>
    </a>
</div>
@endforeach
@endsection