<?php

namespace App\Mail;

use App\Domain\User\Entity\User;
use Illuminate\Mail\Mailable;

class UserCreatedMail extends Mailable
{
    public function __construct(public User $user) {}

    public function build(): self
    {
        return $this->subject('Welcome to Our App')
                    ->view('emails.user_created');
    }
}
