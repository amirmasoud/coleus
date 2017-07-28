@extends('layouts.blog')
@section('content')
@foreach ($books as $book)
<div class="col-xs-6 col-sm-4 col-md-2 pull-right">
    <a href="{{ route('books.list', ['author' => $author->id, 'book' => $book->id]) }}">
        <div class="thumbnail">
            <img src="{{ asset('storage/covers/' . $book->extra['cover']) }}" class="img-responsive" alt="hafez">
            <div class="caption">
                <h5 class="text-center">{{ $book->title }}</h5>
            </div>
        </div>
    </a>
</div>
@endforeach
@endsection
