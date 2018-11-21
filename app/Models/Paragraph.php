<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    use Searchable;

    protected $fillable = [
        'content', 'type'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
