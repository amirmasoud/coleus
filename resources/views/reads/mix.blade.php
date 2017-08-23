@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body">
            {!! $html !!}
            @if (Auth::check() && Auth::user()->role == 'admin')
            <a href="{{ route('tables.edit', ['table'=>$content->table_id]) }}">ویرایش</a>
            @endif
        </div>
        @include('reads.includes.pagination', compact('next', 'prev', 'book', 'author', 'parent'))
    </div>
</div>
@endsection
