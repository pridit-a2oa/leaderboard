<?php

namespace App\Exceptions;

use Exception;

class InvalidWebhookException extends Exception
{
    public static function invalidJson(): self
    {
        return new static("Supplied JSON payload is malformed");
    }
}
