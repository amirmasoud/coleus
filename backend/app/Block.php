<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'order', 'status', 'type'
    ];
}
