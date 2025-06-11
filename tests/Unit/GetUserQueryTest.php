<?php

namespace Tests\Unit;

use Tests\TestCase;

class GetUserQueryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        dd(config('database.connections.sqlite.database'));
    }
}
