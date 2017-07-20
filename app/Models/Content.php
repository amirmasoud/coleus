<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * Insert poems.
     * @param  json $content
     * @param  integer $book_id
     * @return void
     */
    public static function batchInsert($content, $book_id)
    {
        $content = json_decode($content);
        if (isset($content->type) && $content->type == 'collection') {
            $content = $content->collection;
            $i = 1;
            foreach($content as $name => $c) {
                $content_id = Content::insertGetId([
                                'key' => $i++, 
                                'value' => $name, 
                                'type' => 'section', 
                                'book_id' => $book_id
                            ]);
                $j = 1;
                foreach ($c as $sh) {
                    Content::insertGetId([
                        'key' => $j++, 
                        'value' => json_encode($sh), 
                        'type' => 'poem', 
                        'book_id' => $book_id, 
                        'content_id' => $content_id,
                    ]);
                }
            }
        } else {
            $j = 1;
            foreach ($content as $sh) {
                Content::insert([
                    'key' => $j++, 
                    'value' => json_encode($sh), 
                    'type' => 'poem', 
                    'book_id' => $book_id, 
                ]);
            }
        }
    }

    public static function cachedCount($content_id)
    {
        $cache_key = config('app.name') . '_poem_count_' . $content_id;
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            $count = Content::where('content_id', $content_id)->count();
            Cache::forever($cache_key, $count);
            return $count;
        }
    }

    public static function cachedExists($book_id)
    {
        $cache_key = config('app.name') . '_section_exists_' . $book_id;
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            $exists = Content::where('type', 'section')->where('book_id', $book_id)->exists();
            Cache::forever($cache_key, $exists);
            return $exists;
        }
    }

    public static function cachedList($book_id)
    {
        $cache_key = config('app.name') . '_book_index_' . $book_id;
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            $list = Content::where('type', 'section')->where('book_id', $book_id)->orderBy('key')->get();
            Cache::forever($cache_key, $list);
            return $list;
        }
    }

    public static function cachedPoemWithSection($book_id, $section)
    {
        $cache_key = config('app.name') . '_book_' . $book_id . '_section_' . $section;
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            $book_content = Content::where('type', 'poem')
                        ->where('book_id', $book_id)
                        ->where('content_id', $section)
                        ->orderBy('key')->get();
            Cache::forever($cache_key, $book_content);
            return $book_content;
        }
    }

    public static function cachedPoemWithoutSection($book_id)
    {
        $cache_key = config('app.name') . '_book_' . $book_id . '_poem_without_section';
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            $book_content = Content::where('type', 'poem')
                                ->where('book_id', $book_id)
                                ->orderBy('key')->get();
            Cache::forever($cache_key, $book_content);
            return $book_content;
        }
    }

    public static function cachedPoem($key, $book_id, $section)
    {
        if (is_null($section)) {
            $cache_key = config('app.name') . '_poem_' . $key;
        } else {
            $cache_key = config('app.name') . '_poem_' . $key . '_' . $section;
        }
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            if (is_null($section)) {
                $poem = Content::where('book_id', $book_id)
                            ->where('type', 'poem')
                            ->where('key', $key)->first();
            } else {
                $poem = Content::where('book_id', $book_id)
                            ->where('type', 'poem')
                            ->where('content_id', $section)
                            ->where('key', $key)->first();
            }
            Cache::forever($cache_key, $poem);
            return $poem;
        }
    }
}
