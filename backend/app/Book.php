<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'description', 'original', 'medium', 'small', 'xsmall', 'thumbnail', 'placeholder', 'order'
    ];

    public function getScoutKey()
    {
        return $this->id;
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return array_filter([$this->id, $this->title, $this->slug, $this->description]);
    }

    /**
     * Get the pages for the book.
     */
    public function pages()
    {
        return $this->hasMany('App\Page');
    }

    /**
     * The users that belong to the book.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
