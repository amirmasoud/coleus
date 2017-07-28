@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($book_content as $b)
            <p>
                <a href="{{ route('reads.show', ['author' => $author->id, 
                                                 'book' => $book->id, 
                                                 'index'=>$b->key, 
                                                 'section'=>@$b->content_id ?? '']) }}">
                    {{ $b->unit }} شماره {{ convert($b->key) }}{{ $b->title }}
                </a>
            </p>
            @endforeach
        </div>
    </div>
</div>
@endsection