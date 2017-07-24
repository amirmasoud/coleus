<?php

namespace App\Models;

use Cache;
use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'pages', 'ISBN', 'price', 'year', 'extra', 
        'author_id', 'publisher_id', 'unit'
    ];

    /**
     * Get the author for the book.
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the publisher for the book.
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    /**
     * The categories that belong to the book.
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * The comments for the book.
     * @return Illuminate\Database\Eloquent\Concerns\hasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Set the extra value.
     *
     * @param  string  $value
     * @return void
     */
    public function setExtraAttribute($value)
    {
        set_time_limit(0);
        $newValue = [];
        for ($i = 0; $i < count($value); $i += 2) {
            if ($value[$i] != '' && !is_null($value[$i])) {
                if ($value[$i] == 'content') {
                    Content::batchInsert($value[$i + 1], $this->id);
                } else {
                    $newValue[$value[$i]] = $value[$i + 1];
                }
            }
        }
        $this->attributes['extra'] = serialize($newValue);
    }

    /**
     * Get the extra value.
     *
     * @param  string  $value
     * @return string
     */
    public function getExtraAttribute($value)
    {
        $extra = unserialize($value);
        if (!is_null($this->content)) {
            $extra['content'] = $this->content;
        }
        return $extra;
    }

    /**
     * Get the book(s) by cache server.
     * 
     * @param  integer $ucid Unique Cache ID
     * @return \App\Models\Book
     */
    public static function cache($ucid)
    {
        $cache_key = config('app.name') . '_book_' . $ucid;
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        } else {
            if ($ucid == '*') {
                $author = Book::get();
            } else {
                $author = Book::find($ucid);
            }
            Cache::forever($cache_key, $author);
            return $author;
        }
    }

    public static function next($index, $count)
    {
        return ($index < $count) ? $index+1 : '#';
    }


    public static function prev($index, $count)
    {
        return ($index > 1) ? $index-1 : '#';
    }
}
