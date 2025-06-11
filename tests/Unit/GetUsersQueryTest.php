<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Application\Query\GetUsers\GetUsersQuery;

class GetUsersQueryTest extends TestCase
{
    public function test_it_sets_all_fields_properly()
    {
        $currentUser = new \App\Models\User(['id' => 1, 'name' => 'Test User']);
        $query = new GetUsersQuery(
            page: 3,
            search: '',
            sortBy: 'name',
            currentUser: $currentUser
        );

        $this->assertEquals(3, $query->page);
        $this->assertEquals('', $query->search);
        $this->assertEquals('name', $query->sortBy);
        $this->assertInstanceOf(\App\Models\User::class, $query->currentUser);
    }
}
