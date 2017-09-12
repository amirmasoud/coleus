<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Repositories\BookRepo;
use App\Repositories\AuthorRepo;
use App\Repositories\ContentRepo;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Table;
use App\Models\Author;
use App\Models\Book;

class SearchController extends Controller
{
    private function highlight($text, $words)
    {
        $highlighted = preg_filter('/' . preg_quote($words) . '/i', '<b><span class="search-highlight">$0</span></b>', $text);
        if (!empty($highlighted)) {
            $text = $highlighted;
        }
        return $text;
    }

    /**
     * Search
     *
     * @param  string $q
     * @return Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $results = $this->content($request);
        return $results;
    }

    private function content($request)
    {
        $result = [];
        $content = Content::where('html', 'like', '%' . $request->input('q') . '%')->limit(7)->get();
        if(in_array($request->input('q'), ['m1', 'm2', 't1', 't2', 'p', 'span', 'div', 'b', '"', '<', '>', '/'])) {
            return [];
        }
        foreach ($content as $c) {
            $record = [];
            $html = $c->html;
            $pos = strpos($html, $request->input('q'));
            $start = 0;
            $end = 0;
            for ($i = (int)$pos; $i < strlen($html); $i++) {
                if ($html[$i] == '<') {
                    $end = $i;
                    break;
                }
            }
            for ($i = (int)$pos; $i >= 0; $i--) {
                if ($html[$i] == '>') {
                    $start = $i + 1;
                    break;
                }
            }
            $length = abs($end - $start);
            if ($length > 100) {
                if ($pos + 100 < strlen($html)) {
                    $space = 0;
                    while ($html[$pos - $space] != ' ') {
                        $space++;
                    }
                    $after = 0;
                    while ($html[$pos + 100 + $after] != ' ') {
                        $after++;
                    }
                    $between = substr($html, $pos - $space, 100 + ($after ? $after + 1 : $after));
                    $record = [
                        'title' => $between
                    ];
                } else {
                    $space = 0;
                    while ($html[$pos - (100 - (strlen($html) - $pos) - $space)] != ' ') {
                        $space++;
                    }
                    $between = substr($html, $pos - (100 - (strlen($html) - $pos) - ($space ? $space + 1 : $space)), 100);
                    $record = [
                        'title' => $between
                    ];
                }
            } else {
                $between = substr($html, $start, $length);
                $record = [
                    'title' => $between
                ];
            }
            $record['link'] = route('reads.show', ['index' => $c->order, 'book' => $c->table->book->slug,
                'parent' => $c->table->parent->slug, 'author' => $c->table->book->author->slug]);
            $record['author'] = $c->table->book->author->name;
            $record['book'] = $c->table->book->title;
            $record['parent'] = $c->table->parent->title;
            $record['hash'] = $c->hash;
            $result[] = $record;
        }
        return $result;
    }
}
