<?php

namespace App\Exceptions;

use Exception;

class CouldNotFetchDataException extends Exception
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = 'Could not fetch data from the source.';
        }

        parent::__construct($message);
    }
}
