<?php

namespace App\Exceptions;

class InvalidEdgeException extends \Exception
{
    public function __construct(string $message = null)
    {
        parent::__construct($message ?? 'Invalid edge');
    }
}