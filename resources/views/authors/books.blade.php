@extends('layouts.blog')
@section('content')
@foreach ($author->books as $book)
<div class="col-md-2 col-sm-4 col-xs-6 pull-right" style="margin-top: 15px;">
    <a href="{{ route('books.list', ['author' => $author->slug,
                                     'book' => $book->slug]) }}">
        <div class="card">
            <img src="{{ asset('storage/covers/' . $book->extra['cover']) }}"
                class="card-img-top"
                alt="{{ $author->name }}">
            <div class="card-body" style="padding: 0;">
                <h6 class="card-title text-center">{{ $book->title }}</h6>
            </div>
        </div>
    </a>
</div>
@endforeach
@endsection
