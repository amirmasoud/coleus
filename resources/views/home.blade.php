@extends('layouts.blog')
@section('content')
@foreach ($authors as $author)
<div class="col-xs-6 col-sm-4 col-md-2 pull-right">
    <a href="{{ route('authors.books', ['id'=>$author->id]) }}">
        <div class="thumbnail">
            <img src="{{ asset('storage/covers/' . $author->extra['cover']) }}" class="img-responsive" alt="hafez">
            <div class="caption">
                <h5 class="text-center">{{ $author->name }}</h5>
            </div>
        </div>
    </a>
</div>
@endforeach
@endsection
