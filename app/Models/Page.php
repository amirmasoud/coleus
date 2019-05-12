<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content'
    ];

    protected $appends = [
        'is_header', 'next', 'prev', 'next_title', 'prev_title'
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

    public function paragraphs()
    {
        return $this->hasMany(Paragraph::class);
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

    public function sort()
    {
        return $this->sorts()->ofType($this)->first();
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

    public function getNextAttribute()
    {
        if (is_null($this->sort())) {
            return null;
        }

        $next = $this->sort()->getNextSibling();
        return $next ? $next->sortable_id : null;
    }

    public function getPrevAttribute()
    {
        if (is_null($this->sort())) {
            return null;
        }

        $prev = $this->sort()->getPrevSibling();
        return $prev ? $prev->sortable_id : null;
    }

    public function getNextTitleAttribute()
    {
        if (is_null($this->sort())) {
            return null;
        }

        $next = $this->sort()->getNextSibling();
        return $next ? $next->sortable()->first()->title : null;
    }

    public function getPrevTitleAttribute()
    {
        if (is_null($this->sort())) {
            return null;
        }

        $prev = $this->sort()->getPrevSibling();
        return $prev ? $prev->sortable()->first()->title : null;
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
