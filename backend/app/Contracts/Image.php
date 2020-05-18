<?php

namespace App\Contracts;

interface Image
{
    /**
     * Get public url of a image given path and size.
     *
     * @param string $path
     * @param integer $width
     * @param integer $height
     * @return void
     */
    public function publicUrl($path, $width = 32, $height = 32);
}
