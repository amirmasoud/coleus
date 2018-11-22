<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Book extends Model implements HasMedia
{
    use HasMediaTrait, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'cover', 'slug'
    ];

    /**
     * get cover attribute.
     *
     * @param  string $avatar
     * @return string
     */
    public function getCoverAttribute($cover): string
    {
        return $this->getFirstMediaUrl('books/cover', 'medium');
    }

    /**
     * get placeholder attribute.
     *
     * @param  string $avatar
     * @return string
     */
    public function getPlaceholderAttribute($placeholder): string
    {
        return $this->getFirstMediaUrl('books/cover', 'placeholder');
    }

    /**
     * Media conversion versions.
     *
     * @param  \Spatie\MediaLibrary\Models\Media|null $media
     * @return void
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('medium')
            ->width(240)
            ->crop('crop-center', 240, 400)
            ->performOnCollections('books/cover');

        $this->addMediaConversion('placeholder')
            ->width(6)
            ->crop('crop-center', 3, 5)
            ->blur(75)
            ->performOnCollections('books/cover');
    }

    /**
     * Get all of the collaborators for the book.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function collaborators(): morphToMany
    {
        $bookId = $this->id;

        $relation = $this->morphToMany(User::class, 'collaboratable',
            'collaboratables', 'collaboratable_id', 'collaborate_id')
            ->using(Collaborate::class)
            ->withTimestamps();

        return $relation;
    }

    /**
     * Get appended attribute, slug with concating title slug and id.
     *
     * @param  null $value
     * @return string
     */
    public function getSlugAttribute($value): string
    {
        return slug($this->title) . '-' . $this->id;
    }

    /**
     * Get all of the book's sorts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function sorts(): MorphMany
    {
        return $this->morphMany(Sort::class, 'sortable');
    }

    /**
     * A book has many books.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages(): HasMany
    {
        return $this->HasMany(Page::class);
    }

    /**
     * Get sorting index (parent)
     *
     * @return \App\Models\Sort|null
     */
    public function sort()
    {
        return Sort::ofType($this)->first();
    }
}
