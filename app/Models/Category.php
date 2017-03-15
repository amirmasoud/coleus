<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cover', 'description'
    ];

    /**
     * The parent category if there is any.
     */
    public function parent()
    {
        return $this->hasOne(Category::class);
    }

    /**
     * The books that belong to the category.
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
