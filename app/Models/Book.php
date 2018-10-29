<?php

namespace App\Models;

use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Book extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'cover'
    ];

    /**
     * get cover attribute.
     *
     * @param  string $avatar
     * @return string
     */
    public function getCoverAttribute($cover): string
    {
        return $this->getFirstMediaUrl('books/cover', 'medium');
    }

    /**
     * Media conversion versions.
     *
     * @param  \Spatie\MediaLibrary\Models\Media|null $media
     * @return void
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('medium')
            ->width(120)
            ->crop('crop-center', 120, 200)
            ->performOnCollections('books/cover');
    }

    /**
     * Get all of the collaborators for the book.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function collaborators(): morphToMany
    {
        $bookId = $this->id;

        $relation = $this->morphToMany(User::class, 'collaboratable',
            'collaboratables', 'collaboratable_id', 'collaborate_id')

            ->using(Collaborate::class)
//            ->as('collaboratable_id')
//            ->withPivot('collaboratable_id')// 'collaboration_role_id', 'collaborationRoles'
            ->withTimestamps();

//        $relation->getQuery()
//            ->where('collaboratables.collaboratable_type', get_class($this))
//            ->where('collaboratables.collaboratable_id', $bookId)
//            ->join('collaboration_roles AS cr', 'cr.id', '=', 'collaboratables.collaboration_role_id')
//            ->join('collaboratables AS c', 'c.collaborate_id', '=','users.id')
//            ->select('*', 'users.id AS id')->distinct()
//            ->groupBy('users.id', 'collaboratables.id', 'cr.id', 'c.id');

        return $relation;
    }
}
