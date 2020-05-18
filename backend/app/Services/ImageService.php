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

    public function __construct()
    {
        if (empty($this->keyBin = pack("H*", env('IMGPROXY_KEY')))) {
            throw new ImageKeyException();
        }

        if (empty($this->saltBin = pack("H*", env('IMGPROXY_SALT')))) {
            throw new ImageSaltException();
        }
    }

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
        $resize = 'fill';
        $gravity = 'no';
        $enlarge = 1;
        $extension = 'jpg';
        $filename = uniqid('', true);

        $url = 's3://' . $path;
        $encodedUrl = rtrim(strtr(base64_encode($url), '+/', '-_'), '=');

        $path = "/filename:{$filename}/resize:{$resize}/width:{$width}/height:{$height}/gravity:{$gravity}/enlarge:{$enlarge}/{$encodedUrl}.{$extension}";

        $signature = rtrim(strtr(base64_encode(hash_hmac('sha256', $this->saltBin . $path, $this->keyBin, true)), '+/', '-_'), '=');

        return env('IMGPROXY_PUBLIC_URL') . sprintf("/%s%s", $signature, $path);
    }
}