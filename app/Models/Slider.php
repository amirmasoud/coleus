<?php

namespace App\Models;

use Image;
use Storage;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'sub', 'link', 'image',
    ];

    /**
     * Save slider image.
     *
     * @param  string $image
     * @return void
     */
    public function setImageAttribute($image)
    {
        $name = $this->attributes['image'] = basename($image->store('public/sliders/originals/'));
        $img = Image::make('storage/sliders/originals/' . $name);
        $img->fit(800, 300);
        $img->save('storage/sliders/' . $name);
        $thumb = Image::make('storage/sliders/originals/' . $name);
        $thumb->fit(300, 300);
        $thumb->save('storage/sliders/thumbnails/' . $name);
    }

    /**
     * Get full path to image url.
     *
     * @return string
     */
    public function image()
    {
        return asset('storage/sliders/' . $this->image);
    }

    /**
     * Get full path to image thumbnail url.
     *
     * @return string
     */
    public function thumbnail()
    {
        return asset('storage/sliders/thumbnails/' . $this->image);
    }

    /**
     * Get full path to image thumbnail url.
     *
     * @return string
     */
    public function original()
    {
        return asset('storage/sliders/original/' . $this->image);
    }
}
