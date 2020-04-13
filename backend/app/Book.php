<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'description', 'original', 'medium', 'small', 'xsmall', 'thumbnail', 'placeholder'
    ];

    /**
     * Get the sections for the user.
     */
    public function sections()
    {
        return $this->hasMany('App\Section');
    }

    /**
     * The users that belong to the book.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
