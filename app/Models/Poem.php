<?php

namespace App\Models;

use Cache;
use App\Models\Book;

class Poem
{
    public static function cached($book_id, $index)
    {
        $index -= 1;
        $cache_key = config('app.name') . '_book_' . $book_id . '_poem_' . $index;
        if (Cache::has($cache_key)) {
            return json_decode(Cache::get($cache_key)->content);
        } else {
            $poem = Book::cached($book_id);
            $content = json_decode($poem->content)[$index];
            $poem->content = json_encode($content);
            Cache::forever($cache_key . '_title_', $content->{'0'}->m1);
            Cache::forever($cache_key, $poem);
            return json_decode($poem->content);
        }
    }

    public static function title($book_id, $index, $poem = '')
    {
        if ($poem == '') {
            $poem = Poem::cached($book_id, $index);
        }
        return isset($poem->title) ? $poem->title : Poem::cached($book_id, $index)->{'0'}->m1;
    }
}
