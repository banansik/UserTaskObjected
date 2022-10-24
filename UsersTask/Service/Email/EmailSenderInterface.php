<?php
declare(strict_types=1);

namespace UsersTask\Service\Email;

use UsersTask\Entity\Mail;
use UsersTask\Entity\User;

interface EmailSenderInterface
{
    public function send(Mail $mail, User $user): void;
}