<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'order', 'status', 'book_id'
    ];

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
