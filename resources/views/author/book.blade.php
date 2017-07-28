@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading"><b>{{ $author->name }}</b> - {{ $book->title }}</div>
        <div class="panel-body">
            @for($i = 1; $i <= $count; $i++)
                <p><a href="{{ route('author.books.show', ['author' => $author->id, 'book' => $book->id, 'index'=>$i]) }}">غزل شماره {{ $i }} {{ \App\Models\Poem::title($book->id, $i) }}</a></p>
            @endfor
        </div>
    </div>
</div>
@endsection