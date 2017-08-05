@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($leaves as $leaf)
            <p>
                <a href="{{ route('reads.show', ['author' => $author->slug, 
                                                 'book' => $book->slug,
                                                 'index'=>$leaf->order]) }}">
                    {{ convert($leaf->title) }}
                </a>
            </p>
            @endforeach
        </div>
    </div>
</div>
@endsection