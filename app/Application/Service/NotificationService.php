<?php

namespace App\Application\Service;

use App\Domain\User\Entity\User;

interface NotificationService
{
    public function notifyUserCreated(User $user): void;
}
