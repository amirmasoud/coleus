<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'born', 'extra'
    ];

    /**
     * Get the occupations for the author.
     */
    public function occupations()
    {
        return $this->hasMany('App\Occupation');
    }

    /**
     * Get the movements for the author.
     */
    public function movements()
    {
        return $this->hasMany('App\Movement');
    }
}
