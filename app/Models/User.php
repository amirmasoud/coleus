<?php

namespace App\Models;

use App\Models\Author;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}
