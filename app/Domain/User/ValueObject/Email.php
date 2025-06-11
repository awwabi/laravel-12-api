<?php

namespace App\Domain\User\ValueObject;

use InvalidArgumentException;

class Email
{
    public function __construct(public string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format.");
        }
    }
}
