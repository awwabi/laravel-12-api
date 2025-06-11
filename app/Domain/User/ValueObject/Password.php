<?php

namespace App\Domain\User\ValueObject;

use InvalidArgumentException;

class Password
{
    public function __construct(public string $value)
    {
        $this->validate($value);
    }

    private function validate(string $value): void
    {
        $length = mb_strlen($value);

        if ($length < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters long.');
        }

        if ($length > 50) {
            throw new InvalidArgumentException('Password must not exceed 50 characters.');
        }
    }
}
