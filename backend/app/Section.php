<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
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
    public function pages()
    {
        return $this->hasMany('App\Page');
    }
}
