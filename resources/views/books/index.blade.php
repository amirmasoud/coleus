@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($book_content as $c)
            <p>
                <a href="{{ route('reads.show', ['author' => $author->slug, 
                                                 'book' => $book->slug,
                                                 'index'=>$c->order]) }}">
                    {{ convert($c->title) }}
                </a>
            </p>
            @endforeach
        </div>
    </div>
</div>
@endsection