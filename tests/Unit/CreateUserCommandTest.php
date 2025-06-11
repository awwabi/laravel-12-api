<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Application\Command\CreateUser\CreateUserCommand;

class CreateUserCommandTest extends TestCase
{
    public function test_command_properties_are_set_correctly()
    {
        $command = new CreateUserCommand('test@example.com', 'secret', 'Test User');

        $this->assertEquals('test@example.com', $command->email);
        $this->assertEquals('secret', $command->password);
        $this->assertEquals('Test User', $command->name);
    }
}
