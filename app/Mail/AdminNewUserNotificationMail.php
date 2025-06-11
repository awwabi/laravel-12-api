<?php

namespace App\Mail;

use App\Domain\User\Entity\User;
use Illuminate\Mail\Mailable;

class AdminNewUserNotificationMail extends Mailable
{
    public function __construct(public User $user) {}

    public function build(): self
    {
        return $this->subject('New User Registered')
                    ->view('emails.admin_new_user_notification');
    }
}
