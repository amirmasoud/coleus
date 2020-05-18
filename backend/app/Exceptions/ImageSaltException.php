<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ImageSaltException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error('Salt expected to be hex-encoded string');
    }
}
