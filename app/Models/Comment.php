<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\belongsTo;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'name', 'email', 'content_id'
    ];

    /**
     * Get the book that belongs to the comment.
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the user that belongs to the comment.
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
