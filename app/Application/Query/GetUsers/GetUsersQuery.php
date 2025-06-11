<?php

namespace App\Application\Query\GetUsers;

use App\Models\User as CurrentUser;

class GetUsersQuery
{
    public function __construct(
        public ?string $search,
        public int $page,
        public ?string $sortBy,
        public CurrentUser $currentUser
    ) {}
}
