<?php

namespace App\Application\Command\CreateUser;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepository;
use App\Application\Service\NotificationService;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Password;

class CreateUserUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private NotificationService $notificationService
    ) {}

    public function execute(CreateUserCommand $command): User
    {
        if (!auth('api')->user()->active) {
            abort(403, 'Inactive users cannot perform this action.');
        }

        $user = new User(
            id: null,
            email: new Email($command->email),
            name: new Name($command->name),
            password: new Password($command->password)
        );

        $this->userRepository->save($user);
        $this->notificationService->notifyUserCreated($user);

        return $user;
    }
}
