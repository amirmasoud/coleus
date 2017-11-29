@extends('layouts.blog')
@section('content')
<div class="col-xs-12" v-bind:style="{ fontSize: fontSize + 'px', lineHeight: lineHeight }">
    <div class="panel panel-default">
        <div class="panel-body center-block" v-bind:style="{ maxWidth: width + 'px' }">
            {!! $html !!}
            @if (Auth::check() && Auth::user()->role == 'admin')
            <a href="{{ route('tables.edit', ['table'=>$content->table_id]) }}">ویرایش</a>
            @endif
        </div>
        @include('reads.includes.pagination', compact('next', 'prev', 'book', 'author', 'parent'))
    </div>
</div>
<div class="col-xs-12">
    @include('components.comment', ['content_id' => $content])
</div>
@endsection
