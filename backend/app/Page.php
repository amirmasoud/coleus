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
        'title', 'order', 'status'
    ];

    /**
     * The section has many blocks.
     */
    public function blocks()
    {
        return $this->hasMany('App\Block');
    }
}
