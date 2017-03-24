<?php

namespace App\Models;

use Image;
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
        'name', 'cover', 'description', 'category_id'
    ];

    /**
     * The parent category if there is any.
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * The children of the category if there is any.
     * @return Illuminate\Database\Eloquent\Concerns\hasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    /**
     * The books that belong to the category.
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    /**
     * Save cover image.
     *
     * @param  string $cover
     * @return void
     */
    public function setCoverAttribute($cover)
    {
        $name = $this->attributes['cover'] = basename($cover->store('public/categories/originals/'));
        $img = Image::make('storage/categories/originals/' . $name);
        $img->fit(800, 300);
        $img->save('storage/categories/' . $name);
        $thumb = Image::make('storage/categories/originals/' . $name);
        $thumb->fit(200, 75);
        $thumb->save('storage/categories/thumbnails/' . $name);
    }

    /**
     * Get full path to cover url.
     *
     * @return string
     */
    public function cover()
    {
        return asset('storage/categories/' . $this->cover);
    }

    /**
     * Get full path to cover thumbnail url.
     *
     * @return string
     */
    public function thumbnail()
    {
        return asset('storage/categories/thumbnails/' . $this->cover);
    }

    /**
     * Get full path to cover thumbnail url.
     *
     * @return string
     */
    public function original()
    {
        return asset('storage/categories/original/' . $this->cover);
    }
}
