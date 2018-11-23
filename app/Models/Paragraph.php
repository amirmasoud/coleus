<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    protected $fillable = [
        'content', 'type'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
