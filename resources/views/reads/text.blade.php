@extends('layouts.blog')
@section('content')
<div class="col-md-12"
    v-bind:style="{ fontSize: fontSize + 'px', lineHeight: lineHeight }">
    <div class="card">
        <div class="card-body mx-auto"
            v-bind:style="{ maxWidth: width + 'px' }">
            @foreach($text as $paragraph)
              <p class="p">{{ $paragraph->p }}</p>
            @endforeach
        </div>
        @include('reads.includes.pagination', compact('next', 'prev', 'book', 'author', 'parent'))
    </div>
</div>
<div class="col-md-12" style="margin-top: 15px;">
    @include('components.comment', ['content_id' => $content])
</div>
@endsection
