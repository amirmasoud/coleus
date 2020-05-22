<?php

namespace App;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    use searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'order', 'status', 'type'
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
        return array_filter([$this->id, $this->content]);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo('App\Page');
    }
}
