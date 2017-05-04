<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Movement;
use App\Models\Occupation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'born'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'born', 'extra'
    ];

    /**
     * Get the occupations for the author.
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function occupations()
    {
        return $this->belongsToMany(Occupation::class);
    }

    /**
     * Get the movements for the author.
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsToMany
     */
    public function movements()
    {
        return $this->belongsToMany(Movement::class);
    }

    /**
     * Get the user for the author.
     *
     * @return Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the books for the author.
     *
     * @return Illuminate\Database\Eloquent\Concerns\hasMany
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Get author age.
     *
     * @return integer
     */
    public function age()
    {
        return Carbon::now()->year - 
            Carbon::createFromFormat('Y-m-d', $this->born)->year;
    }

    /**
     * Set the extra value.
     *
     * @param  string  $value
     * @return void
     */
    public function setExtraAttribute($value)
    {
        $newValue = [];
        for ($i = 0; $i < count($value); $i += 2) {
            if ($value[$i] != '' && !is_null($value[$i]))
                $newValue[$value[$i]] = $value[$i + 1];
        }
        $this->attributes['extra'] = serialize($newValue);
    }

    /**
     * Get the extra value.
     *
     * @param  string  $value
     * @return string
     */
    public function getExtraAttribute($value)
    {
        return unserialize($value);
    }

    /**
     * Get the born value.
     *
     * @param  string  $value
     * @return string
     */
    public function getBornAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->toDateString();
    }
}
