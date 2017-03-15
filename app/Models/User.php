<?php

namespace App\Models;

use App\Models\Author;
use App\Models\Comment;
use App\Models\Publisher;
use App\Models\Subscriber;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the author for the user.
     * @return Illuminate\Database\Eloquent\Concerns\hasOne
     */
    public function author()
    {
        return $this->hasOne(Author::class);
    }

    /**
     * Get the publisher for the user.
     * @return Illuminate\Database\Eloquent\Concerns\hasOne
     */
    public function publisher()
    {
        return $this->hasOne(Publisher::class);
    }

    /**
     * Get the subscriber for the user.
     * @return Illuminate\Database\Eloquent\Concerns\hasOne
     */
    public function subscriber()
    {
        return $this->hasOne(Subscriber::class);
    }

    /**
     * Get the comments for the user.
     * @return Illuminate\Database\Eloquent\Concerns\hasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
