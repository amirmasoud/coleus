@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($text as $line)
                @if (isset($line->m1))
                <div class="b">
                    <span class="m1">{{ $line->m1 }}</span>
                    <span class="m2">{{ $line->m2 }}</span>
                </div>
                @else
                <div class="p"><p>{{ $line->p }}</p></div>
                @endif
            @endforeach
        </div>
        @include('reads.includes.pagination', compact('next', 'prev', 'book', 'author', 'parent'))
    </div>
</div>
@endsection
