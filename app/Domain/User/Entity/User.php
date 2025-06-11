<?php

namespace App\Domain\User\Entity;

use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Password;

class User
{
    const DEFAULT_ROLE = 'user';

    public function __construct(
        public ?int $id,
        public Email $email,
        public Name $name,
        public Password $password,
        public string $role = self::DEFAULT_ROLE,
        public $active = true
    ) {}

    public function isActive(): bool
    {
        return $this->active;
    }

    public function canEdit(User $targetUser): bool
    {
        $isUserAdmin = $this->role === 'admin';

        $isUserManagerAndTargetUserIsUser = $this->role === 'manager' && $targetUser->role === 'user';

        $isTargetUserSelf = $this->id === $targetUser->id;

        return $isUserAdmin || $isUserManagerAndTargetUserIsUser || $isTargetUserSelf;
    }
}
