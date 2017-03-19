<?php

namespace App\Models;

use Image;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /**
     * Save slider image.
     *
     * @param  string $image
     * @return void
     */
    public function setImageAttribute($image)
    {
        $name = $this->attributes['image'] = basename($image->store('public/sliders/'));
        $img = Image::make('storage/sliders/' . $name);
        $img->fit(800, 500);
        Storage::delete('storage/sliders/' . $name);
        $img->save('storage/sliders/' . $name);
    }

    /**
     * Get full path to image url.
     *
     * @param  string $image
     * @return string
     */
    public function getImageAttribute($image)
    {
        return asset('storage/sliders/' . $image);
    }
}
