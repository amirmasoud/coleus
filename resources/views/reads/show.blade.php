@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($text as $poem)
                <div class="b">
                    <span class="m1">{{ $poem->m1 }}</span>
                    <span class="m2">{{ $poem->m2 }}</span>
                </div>
            @endforeach
        </div>
        @include('reads.includes.pagination', compact('next', 'prev', 'book', 'author', 'parent'))
    </div>
</div>
<div class="col-xs-12">
    @include('components.comment', ['content_id' => $content])
</div>
@endsection
