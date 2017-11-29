@extends('layouts.blog')
@section('content')
<div class="col">
    <div class="card">
        <div class="card-body text-right">
            @foreach($leaves as $leaf)
            <p>
                <a href="{{ route('reads.show', ['author' => $author->slug,
                                                 'book' => $book->slug,
                                                 'index'=>$leaf->order,
                                                 'parent'=>$parent]) }}">
                    {{ convert($leaf->title) }}
                </a>
            </p>
            @endforeach
        </div>
    </div>
</div>
@endsection
