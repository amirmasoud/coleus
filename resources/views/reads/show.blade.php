@extends('layouts.blog')
@section('content')
<div class="col-md-12"
    v-bind:style="{ fontSize: fontSize + 'px', lineHeight: lineHeight }">
    <div class="card">
        <div class="card-body mx-auto"
            v-bind:style="{ maxWidth: width + 'px' }">
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
<div class="col-md-12" style="margin-top: 15px;">
    @include('components.comment', ['content_id' => $content])
</div>
@endsection
