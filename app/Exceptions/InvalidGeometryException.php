<?php

namespace App\Exceptions;

use Exception;

class InvalidGeometryException extends Exception
{
    public function __construct($message = null)
    {
        if (!$message) {
            $message = 'The geometry field must be a valid GeoJSON object.';
        }

        parent::__construct($message);
    }
}
