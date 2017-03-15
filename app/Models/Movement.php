<?php

namespace App\Models;

use App\Models\Author;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The movements that belong to the authors.
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
