<?php

namespace App;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    use searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'order', 'status', 'book_id'
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
        return array_filter([$this->id, $this->title]);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo('App\Book');
    }

    /**
     * The section has many blocks.
     */
    public function blocks()
    {
        return $this->hasMany('App\Block');
    }

    public function children()
    {
        return $this->hasMany('App\Page', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Page', 'parent_id', 'id');
    }
}
