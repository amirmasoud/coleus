<?php

namespace App\GraphQL\Errors;

use GraphQL\Error;
use Folklore\GraphQL\Error\ValidationError;
use Illuminate\Validation\ValidationException;

class Format
{
    public static function formatError(Error $e)
    {
        $error = [
            'message' => $e->getMessage()
        ];

        $locations = $e->getLocations();
        if (!empty($locations)) {
            $error['locations'] = array_map(function ($loc) {
                return $loc->toArray();
            }, $locations);
        }

        $previous = $e->getPrevious();

        if ($previous && $previous instanceof ValidationError) {
            $error['errors'] = $previous->getValidatorMessages();
        }

        if ($previous && $previous instanceof ValidationException) {
            $error['errors'] = $previous->errors();
        }

        return $error;
    }
}
