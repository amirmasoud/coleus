@extends('layouts.blog')
@section('content')
<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @foreach($content as $c)
                <div class="b">
                    <span class="m1">{{ $c->m1 }}</span>
                    <span class="m2">{{ $c->m2 }}</span>
                </div>
            @endforeach
        </div>
        @unless ($next == '#' && $prev == '#')
        <div class="panel-footer">
            @if ($next != '#')
            <p class="pull-left">
              <a v-shortkey.once="['j']"
                @shortkey="go('{{ route('reads.show', [
                                      'author' => $author->slug,
                                      'book' => $book->slug,
                                      'index' => $next->content->order]) }}')"
                href="{{ route('reads.show', [
                  'author' => $author->slug,
                  'book' => $book->slug,
                  'index' => $next->content->order]) }}">
                {{ convert($next->title) }} <i class='fa fa-angle-double-left'></i>
              </a>
            </p>
            @endif
            @if ($prev != '#')
            <p class="pull-right">
              <a v-shortkey.once="['k']"
                @shortkey="go('{{ route('reads.show', [
                                    'author' => $author->slug,
                                    'book' => $book->slug,
                                    'index' => $prev->content->order]) }}')"
                href="{{ route('reads.show', [
                  'author' => $author->slug,
                  'book' => $book->slug,
                  'index' => $prev->content->order]) }}">
                <i class='fa fa-angle-double-right'></i> {{ convert($prev->title) }}
              </a>
            </p>
            @endif
            <br>
        </div>
        @endunless
    </div>
</div>
@endsection
