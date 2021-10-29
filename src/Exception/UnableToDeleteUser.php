<?php

namespace App\Exception;

/**
 * Class UnableToDeleteUser
 * @package App\Exception
 */
class UnableToDeleteUser extends \Exception
{
    /**
     * UnableToDeleteUser constructor.
     * @param string $message
     * @param int $code
     * @param null $previous
     */
    public function __construct($message = 'exception_user_unable_to_delete', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
