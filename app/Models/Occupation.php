<?php

namespace App\Models;

use App\Models\Occupation;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
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
     * The occupations that belong to the author.
     */
    public function occupations()
    {
        return $this->belongsToMany(Occupation::class);
    }
}
