<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AccountDeletedException extends AccountStatusException
{
    public function __construct($message = 'exception_user_is_deleted', $code = 400, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}