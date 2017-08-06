@extends('layouts.blog')
@section('content')
@foreach ($author->books as $book)
<div class="col-xs-6 col-sm-4 col-md-2 pull-right">
    <a href="{{ route('books.list', ['author' => $author->slug, 
                                     'book' => $book->slug]) }}">
        <div class="thumbnail">
            <img src="{{ asset('storage/covers/' . $book->extra['cover']) }}" 
                class="img-responsive" 
                alt="{{ $author->name }}">
            <div class="caption">
                <h5 class="text-center">{{ $book->title }}</h5>
            </div>
        </div>
    </a>
</div>
@endforeach
@endsection
