<?php

namespace App\Models;

use Cache;
use App\Models\Content;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{

    /**
     *
     * @param  integer $ucid Unique Cache ID
     * @return \App\Models\Author
     */
    public static function cache($ucid)
    {
        $cache_key = config('app.name') . '_content_' . $ucid;
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            if ($ucid == '*') {
                $cache_value = Content::get();
            } elseif (strpos($ucid, 'exists')) {
                $cache_value = Content::where('type', 'section')
                                      ->where('book_id', explode('_', $ucid)[0])
                                      ->exists();
            } elseif (strpos($ucid, 'next')) {
                // _content_{$poem->id}_poem_{$poem->book_id}_book_{$section}_section_next
                $pieces = explode('_', $ucid);
                if ($pieces[4] == '') {
                    $cache_value = Content::where('id', '>', $pieces[0])
                                          ->where('book_id', $pieces[2])
                                          ->where('type', 'poem')
                                          ->orderBy('id')
                                          ->first() ?? '#';
                } else {
                    $cache_value = Content::where('id', '>', $pieces[0])
                                          ->where('book_id', $pieces[2])
                                          ->where('type', 'poem')
                                          ->where('content_id', $pieces[4])
                                          ->orderBy('id')
                                          ->first() ?? '#';
                }
                if ($cache_value != '#') {
                    $cache_value = $cache_value->key;
                }
            } elseif (strpos($ucid, 'prev')) {
                // _content_{$poem->id}_poem_{$poem->book_id}_book_{$section}_section_prev
                $pieces = explode('_', $ucid);
                if ($pieces[4] == '') {
                    $cache_value = Content::where('id', '<', $pieces[0])
                                          ->where('book_id', $pieces[2])
                                          ->where('type', 'poem')
                                          ->orderBy('id', 'desc')
                                          ->first() ?? '#';
                } else {
                    $cache_value = Content::where('id', '<', $pieces[0])
                                          ->where('book_id', $pieces[2])
                                          ->where('type', 'poem')
                                          ->where('content_id', $pieces[4])
                                          ->orderBy('id', 'desc')
                                          ->first() ?? '#';
                }
                if ($cache_value != '#') {
                    $cache_value = $cache_value->key;
                }
            } elseif (strpos($ucid, 'poem')) {
                $pieces = explode('_', $ucid);
                if ($pieces[4] == '') {
                    $cache_value = Content::where('book_id', $pieces[2])
                                          ->where('type', 'poem')
                                          ->where('key', $pieces[0])->first();
                } else {
                    $cache_value = Content::where('book_id', $pieces[2])
                                          ->where('type', 'poem')
                                          ->where('content_id', $pieces[4])
                                          ->where('key', $pieces[0])->first();
                }
            } elseif (strpos($ucid, 'list')) {
                $cache_value = Content::where('type', 'section')
                                      ->where('book_id', explode('_', $ucid)[0])
                                      ->orderBy('key')
                                      ->get();
            } elseif (strpos($ucid, 'section')) {
                // _content_{$book->id}_book_{$content->value}_section
                $cache_value = Content::where('type', 'poem')
                                      ->where('book_id', explode('_', $ucid)[0])
                                      ->where('content_id', explode('_', $ucid)[2])
                                      ->orderBy('key')
                                      ->get();
            } elseif (strpos($ucid, 'book')) {
                $cache_value = Content::where('type', 'poem')
                                      ->where('book_id', explode('_', $ucid)[0])
                                      ->orderBy('key')
                                      ->get();
            } else {
                $cache_value = Content::find($ucid);
            }
            Cache::forever($cache_key, $cache_value);
            return $cache_value;
        }
    }

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
            foreach ($content as $name => $c) {
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

    /**
     * Get the title value.
     *
     * @param  string  $value
     * @return string
     */
    public function getTitleAttribute($value)
    {
        return property_exists($value = json_decode($this->value), 'title')
            ? ' - ' . $value->title
            : '';
    }

    /**
     * Get the unit value.
     *
     * @param  string  $value
     * @return string
     */
    public function getUnitAttribute($value)
    {
        return property_exists($value = json_decode($this->value), 'unit')
            ? $value->unit
            : 'شعر';
    }
}
