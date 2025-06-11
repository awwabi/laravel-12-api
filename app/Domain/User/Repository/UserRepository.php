<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Entity\User;

interface UserRepository
{
    public function save(User $user): void;

    public function findById(int $id): ?User;

    public function searchPaginated(
        ?string $search,
        int $page,
        ?string $sortBy,
        \App\Models\User $currentUser
    );
}
