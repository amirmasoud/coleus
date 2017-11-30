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
use Cache;

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
        return Cache::remember("search:content:" . $request->q . ":page:" . ($request->page ?? 1),
            5, function () use ($request) {
                return $this->content($request);
            });
    }

    private function content($request)
    {
        $result = [];
        // $content = Content::where('html', 'like', '%' . $request->q . '%')->paginate(10);
        if (preg_match('/[a-zA-Z0-9]/', $request->q) || $request->q == '' || $request->q == ' ') { //['class', 'm1', 'm2', 't1', 't2', 'p', 'span', 'div', 'b', '"', '<', '>', '/']
            return [];
        }
        $content = Content::search($request->q)->paginate(10);
        foreach ($content as $c) {
            $terms = explode(' ', $request->q);
            foreach ($terms as $term) {
                $r = $this->innerSearch($term, $c);
                if (!is_null($r)) {
                    $result[] = $this->innerSearch($term, $c);
                }
            }
        }
        return array_values(array_unique($result, SORT_REGULAR));
    }

    private function innerSearch($term, $c)
    {
        $pos = strpos($c->html, $term);
        if (!$pos) {
            return null;
        }
        $start = 0;
        $end = 0;
        for ($i = (int)$pos; $i < strlen($c->html); $i++) {
            if ($c->html[$i] == '<') {
                $end = $i;
                break;
            }
        }
        for ($i = (int)$pos; $i >= 0; $i--) {
            if ($c->html[$i] == '>') {
                $start = $i + 1;
                break;
            }
        }
        $length = abs($end - $start);
        if ($length > 100) {
            if ($pos + 100 < strlen($c->html)) {
                $space = 0;
                while ($c->html[$pos - $space] != ' ') {
                    $space++;
                }
                $after = 0;
                while ($c->html[$pos + 100 + $after] != ' ') {
                    $after++;
                }
                $between = substr($c->html, $pos - $space, 100 + ($after ? $after + 1 : $after));
                $record = [
                    'title' => $between
                ];
            } else {
                $space = 0;
                while ($c->html[$pos - (100 - (strlen($c->html) - $pos) - $space)] != ' ') {
                    $space++;
                }
                $between = substr($c->html, $pos - (100 - (strlen($c->html) - $pos) - ($space ? $space + 1 : $space)), 100);
                $record = [
                    'title' => $between
                ];
            }
        } else {
            $between = substr($c->html, $start, $length);
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
        return $record;
    }
}
