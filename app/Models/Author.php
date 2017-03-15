<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Movement;
use App\Models\Occupation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'born', 'extra'
    ];

    /**
     * Get the occupations for the author.
     */
    public function occupations()
    {
        return $this->belongsToMany(Occupation::class);
    }

    /**
     * Get the movements for the author.
     */
    public function movements()
    {
        return $this->belongsToMany(Movement::class);
    }

    /**
     * Get the user for the author.
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the books for the author.
     * @return Illuminate\Database\Eloquent\Concerns\hasMany
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
