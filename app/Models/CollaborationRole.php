<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollaborationRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    /**
     * A collaborator role has many users (collaborators).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): hasMany
    {
        return $this->hasMany(User::class);
    }

    // public function roles()
    // {
    //     return $this->morphTo(CollaborationRole::class);
    // }
}
