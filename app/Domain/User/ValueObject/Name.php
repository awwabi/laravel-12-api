<?php

namespace App\Domain\User\ValueObject;

use InvalidArgumentException;

class Name
{
    public function __construct(public string $value)
    {
        $this->validate($value);
    }

    private function validate(string $value): void
    {
        // Check if empty
        if (trim($value) === '') {
            throw new InvalidArgumentException('Name is required.');
        }

        // Check length
        if (mb_strlen($value) > 100) {
            throw new InvalidArgumentException('Name must not exceed 100 characters.');
        }

        // Check for invalid characters
        if (!preg_match("/^[a-zA-Z\s'`]+$/u", $value)) {
            throw new InvalidArgumentException("Name can only contain letters, spaces, apostrophes ('), and backticks (`).");
        }
    }
}
