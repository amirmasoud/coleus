@extends('layouts.blog')
@section('content')
<div class="row">
    <div class="col-md-9">
        @include('flash::message')
        @include('components.carousel')
    </div>
    <div class="col-md-3">
    </div>
</div>
@endsection