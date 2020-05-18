<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ImageKeyException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error('Key expected to be hex-encoded string');
    }
}
