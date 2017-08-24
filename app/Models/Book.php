<?php

namespace App\Models;

use Cache;
use App\Models\Table;
use App\Models\Author;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Publisher;
use App\Scopes\VisibilityScope;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Book extends Model
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'pages', 'ISBN', 'price', 'year', 'extra',
        'author_id', 'publisher_id', 'slug'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new VisibilityScope);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get the author for the book.
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the table for the book.
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function table()
    {
        return $this->belongsTo(Table::class, 'id', 'book_id');
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
                } else if ($value[$i] instanceof UploadedFile) {
                    $value[$i] = basename($value[$i]->store('public/covers'));
                    $newValue['cover'] = $value[$i];
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
        if (Cache::has($cache_key)) {
            return getCache($cache_key);
        } else {
            if ($ucid == '*') {
                $book = Book::get();
            } else {
                $book = Book::where('slug', $ucid)->first();
            }
            Cache::forever($cache_key, $book);
            return $book;
        }
    }

    public function v1Json()
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'slug'  => $this->slug,
            'cover' => $this->extra['cover']
        ];
    }
}
