<?php

namespace App\Application\Command\CreateUser;

class CreateUserCommand
{
    public function __construct(
        public string $email,
        public string $password,
        public string $name
    ) {}
}
