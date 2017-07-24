@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($list as $section)
            <p>
                <a href="{{ route('books.list', ['author'=>$author->id, 
                                                 'book'=>$book->id, 
                                                 'section'=>$section->id]) }}">
                    {{ $section->value }}
                </a>
            </p>
            @endforeach
        </div>
    </div>
</div>
@endsection