<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return array_filter([$this->title]);
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
