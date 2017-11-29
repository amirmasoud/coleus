@extends('layouts.blog')
@section('content')
<div class="col">
    <div class="card">
        <div class="card-body text-right">
            @foreach($children as $child)
            <p>
                <a href="{{ route('books.list', ['author' => $author->slug,
                                                 'book' => $book->slug,
                                                 'table' => $child->slug]) }}">
                    {{ convert($child->title) }}
                </a>
            </p>
            @endforeach
        </div>
    </div>
</div>
@endsection
