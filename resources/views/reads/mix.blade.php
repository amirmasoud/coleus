@extends('layouts.blog')
@section('content')
<div class="col-md-12"
    v-bind:style="{ fontSize: fontSize + 'px', lineHeight: lineHeight }">
    <div class="card">
        <div class="card-body mx-auto"
            v-bind:style="{ maxWidth: width + 'px' }">
            {!! $html !!}
            @if (Auth::check() && Auth::user()->role == 'admin')
            <a href="{{ route('tables.edit', ['table'=>$content->table_id]) }}">ویرایش</a>
            @endif
        </div>
        @include('reads.includes.pagination', compact('next', 'prev', 'book', 'author', 'parent'))
    </div>
</div>
<div class="col-md-12" style="margin-top: 15px;">
    @include('components.comment', ['content_id' => $content])
</div>
@endsection
