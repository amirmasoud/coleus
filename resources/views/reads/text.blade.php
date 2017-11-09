@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($text as $paragraph)
              <p class="p">{{ $paragraph->p }}</p>
            @endforeach
        </div>
        @include('reads.includes.pagination', compact('next', 'prev', 'book', 'author', 'parent'))
    </div>
</div>
<div class="col-xs-12">
    @include('components.comment', ['content_id' => $content])
</div>
@endsection
