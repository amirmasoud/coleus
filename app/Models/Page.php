<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Page extends Model
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content'
    ];

    protected $appends = [
        'is_header'
    ];

    protected $parent = null;

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($value)
    {
        $this->parent = $value;
    }

    /**
     * Get all of the page's sorts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function sorts(): MorphMany
    {
        return $this->morphMany(Sort::class, 'sortable');
    }

    /**
     * A page belongs to a book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function getIsHeaderAttribute()
    {
        return $this->content != ':empty'
            ? false
            : true;
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function fill(array $attributes)
    {
        if (isset($attributes['parent']))
        {
            $this->setParent($attributes['parent']);
        }

        return parent::fill($attributes);
    }
}
