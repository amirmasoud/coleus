<?php

namespace App\Models;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements JWTSubject, HasMedia
{
    use Notifiable, HasRoles, HasMediaTrait;

    /**
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'website', 'bio'
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo_url', 'thumbnail', 'xsmall', 'small', 'medium'
    ];

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'.jpg?s=200&d=mm';
    }

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Set the user's password.
     *
     * @param  string|null $password
     * @return void
     */
    public function setPasswordAttribute($password): void
    {
        if (!is_null($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    /**
     * get thumbnail attribute.
     *
     * @param  string $avatar
     * @return string
     */
    public function getThumbnailAttribute($avatar): string
    {
        return $this->getFirstMediaUrl('users/avatar', 'thumbnail');
    }

    /**
     * get xsmall avatar attribute.
     *
     * @param  string $avatar
     * @return string
     */
    public function getXSmallAttribute($avatar): string
    {
        return $this->getFirstMediaUrl('users/avatar', 'xsmall');
    }

    /**
     * get small avatar attribute.
     *
     * @param  string $avatar
     * @return string
     */
    public function getSmallAttribute($avatar): string
    {
        return $this->getFirstMediaUrl('users/avatar', 'small');
    }

    /**
     * get medium avatar attribute.
     *
     * @param  string $avatar
     * @return string
     */
    public function getMediumAttribute($avatar): string
    {
        return $this->getFirstMediaUrl('users/avatar', 'medium');
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
            ->width(512)
            ->height(512)
            ->crop('crop-center', 512, 512)
            ->performOnCollections('users/avatar');

        $this->addMediaConversion('small')
            ->width(256)
            ->height(256)
            ->crop('crop-center', 256, 256)
            ->performOnCollections('users/avatar');

        $this->addMediaConversion('xsmall')
            ->width(64)
            ->height(64)
            ->crop('crop-center', 64, 64)
            ->performOnCollections('users/avatar');

        $this->addMediaConversion('thumbnail')
            ->width(32)
            ->height(32)
            ->crop('crop-center', 32, 32)
            ->performOnCollections('users/avatar');
    }

    /**
     * A user specified an optional gender.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
}
