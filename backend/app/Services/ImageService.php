<?php

namespace App\Services;

use App\Contracts\Image;
use App\Exceptions\ImageKeyException;
use App\Exceptions\ImageSaltException;

class ImageService implements Image
{
    /**
     * @var string
     */
    private $keyBin;

    /**
     * @var string
     */
    private $saltBin;

    /**
     * Public URL of a given image from storage.
     *
     * @param  string $path
     * @param  integer $width
     * @param  integer $height
     * @return string
     */
    public function publicUrl($path, $width = 32, $height = 32)
    {
        if (empty($this->keyBin = pack("H*", config('imgproxy.key')))) {
            throw new ImageKeyException();
        }

        if (empty($this->saltBin = pack("H*", config('imgproxy.salt')))) {
            throw new ImageSaltException();
        }

        $resize = 'fill';
        $gravity = 'no';
        $enlarge = 1;
        $extension = 'jpg';
        $filename = uniqid('', true);

        $url = 's3://' . $path;
        $encodedUrl = rtrim(strtr(base64_encode($url), '+/', '-_'), '=');

        $path = "/filename:{$filename}/resize:{$resize}/width:{$width}/height:{$height}/gravity:{$gravity}/enlarge:{$enlarge}/{$encodedUrl}.{$extension}";

        $signature = rtrim(strtr(base64_encode(hash_hmac('sha256', $this->saltBin . $path, $this->keyBin, true)), '+/', '-_'), '=');

        return config('imgproxy.url') . sprintf("/%s%s", $signature, $path);
    }
}
