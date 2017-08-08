@unless ($next == '#' && $prev == '#')
<div class="panel-footer row margin-0">
    @if ($next != '#')
    <div class="@if($next != '#') col-sm-6 col-xs-12 @else col-xs-12 @endif text-left">
      <a v-shortkey.once="['j']"
        @shortkey="go('{{ route('reads.show', [
                              'author' => $author->slug,
                              'book' => $book->slug,
                              'index' => $next->content->order,
                              'parent' => $parent]) }}')"
        href="{{ route('reads.show', [
          'author' => $author->slug,
          'book' => $book->slug,
          'index' => $next->content->order,
          'parent' => $parent]) }}">
        {{ convert($next->title) }} <i class='fa fa-angle-double-left'></i>
      </a>
    </div>
    @endif
    @if ($prev != '#')
    <div class="@if($next != '#') col-sm-6 col-xs-12 @else col-xs-12 @endif text-right">
      <a v-shortkey.once="['k']"
        @shortkey="go('{{ route('reads.show', [
                            'author' => $author->slug,
                            'book' => $book->slug,
                            'index' => $prev->content->order,
                            'parent' => $parent]) }}')"
        href="{{ route('reads.show', [
          'author' => $author->slug,
          'book' => $book->slug,
          'index' => $prev->content->order,
          'parent' => $parent]) }}">
        <i class='fa fa-angle-double-right'></i> {{ convert($prev->title) }}
      </a>
    </div>
    @endif
    <br>
</div>
@endunless