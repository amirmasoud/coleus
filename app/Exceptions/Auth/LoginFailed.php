<?php

namespace App\Exceptions\Auth;

use Exception;
use GraphQL\Error\ClientAware;

class LoginFailed extends Exception  implements ClientAware
{
    public function isClientSafe()
    {
        return true;
    }

    public function getCategory()
    {
        return 'AuthError';
    }
}
