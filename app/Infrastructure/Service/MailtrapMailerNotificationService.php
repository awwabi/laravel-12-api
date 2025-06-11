<?php

namespace App\Infrastructure\Service;

use App\Application\Service\NotificationService;
use App\Domain\User\Entity\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;
use App\Mail\AdminNewUserNotificationMail;

class MailtrapMailerNotificationService implements NotificationService
{
    public function notifyUserCreated(User $user): void
    {
        // Send email to the user
        Mail::to($user->email->value)->send(new UserCreatedMail($user));

        // Send email to admin (from config)
        Mail::to(config('app.admin_email'))->send(new AdminNewUserNotificationMail($user));
    }
}
