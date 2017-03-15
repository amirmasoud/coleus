<?php

namespace App\Models;

use App\Models\Author;
use App\Models\Category;
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
        'title', 'description', 'pages', 'ISBN', 'price', 'year', 'extra'
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
}
