<?php

namespace App\Models;

use App\Models\Movement;
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
     * The movements that belong to the author.
     */
    public function movements()
    {
        return $this->belongsToMany(Movement::class);
    }
}
