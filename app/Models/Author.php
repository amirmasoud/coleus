<?php

namespace App\Models;

use App\Models\Book;
use App\Models\User;
use App\Models\Movement;
use App\Models\Occupation;
use App\Models\Author\Methods;
use App\Models\Author\Mutators;
use App\Models\Author\Accessors;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use Mutators, Accessors, Methods;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'born', 'approved'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'born', 'extra'];

    /**
     * Get the occupations for the author.
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function occupations()
    {
        return $this->belongsToMany(Occupation::class);
    }

    /**
     * Get the movements for the author.
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function movements()
    {
        return $this->belongsToMany(Movement::class);
    }

    /**
     * Get the user for the author.
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the books for the author.
     *
     * @return Illuminate\Database\Eloquent\Concerns\hasMany
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
