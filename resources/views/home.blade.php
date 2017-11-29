@extends('layouts.blog')
@section('content')
@foreach ($authors as $author)
<div class="col-md-2 col-sm-4 col-xs-6 pull-right" style="margin-top: 15px;">
    <a href="{{ route('authors.books', ['author'=>$author->slug]) }}">
        <div class="card">
            <img class="card-img-top" src="{{ asset('storage/covers/' . $author->extra['cover']) }}" alt="{{ $author->name }}">
            <div class="card-body" style="padding: 0;">
                <h6 class="card-title text-center">{{ $author->name }}</h6>
            </div>
        </div>
    </a>
</div>
@endforeach
@endsection
