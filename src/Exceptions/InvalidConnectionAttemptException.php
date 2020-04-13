<?php


namespace SSH\Exceptions;

use Exception;
use Throwable;

class InvalidConnectionAttemptException extends Exception
{
    public function __construct($host, $username)
    {
        parent::__construct("Can't connect to the server '{$host}' as '{$username}' user.");
    }
}