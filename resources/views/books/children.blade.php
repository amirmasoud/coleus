@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($children as $child)
            <p>
                <a href="{{ route('books.list', ['author' => $author->slug, 
                                                 'book' => $book->slug,
                                                 'table' => $child->title]) }}">
                    {{ convert($child->title) }}
                </a>
            </p>
            @endforeach
        </div>
    </div>
</div>
@endsection