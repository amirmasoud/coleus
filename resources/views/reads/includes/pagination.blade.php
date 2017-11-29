@unless ($next == '#' && $prev == '#')
<div class="card-footer row margin-0">
    <div class="col-sm-6 col-xs-12 text-right">
    @if ($prev != '#')
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
    @endif
    </div>
    <div class="col-sm-6 col-xs-12 text-left">
    @if ($next != '#')
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
    @endif
    </div>
    <br>
</div>
@endunless
