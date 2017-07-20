@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading"><b>{{ $author->name }}</b> - {{ $book->title }} - غزل شماره {{ $key }} - {{ $title }}</div>
        <div class="panel-body">
            @foreach($poem as $p)
                <div class="b">
                    <span class="m1">{{ $p->m1 }}</span>
                    <span class="m2">{{ $p->m2 }}</span>
                </div>
            @endforeach
        </div>
        @unless ($next == '#' && $prev == '#')
        <div class="panel-footer">
            @if ($next != '#')
            <p class="pull-left"><a href="{{ route('reads.show', ['author' => $author->id, 'book' => $book->id, 'index' => $next, 'section'=>$section]) }}">غزل شماره {{ $key + 1 }} &larr;</a></p>
            @endif
            @if ($prev != '#')
            <p class="pull-right"><a href="{{ route('reads.show', ['author' => $author->id, 'book' => $book->id, 'index' => $prev, 'section'=>$section]) }}">&rarr; غزل شماره {{ $key - 1 }} </a></p>
            @endif
            <br>
        </div>
        @endunless
    </div>
</div>
@endsection