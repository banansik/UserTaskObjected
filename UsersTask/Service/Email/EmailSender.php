<?php
declare(strict_types=1);

namespace UsersTask\Service\Email;

use UsersTask\Entity\Mail;
use UsersTask\Entity\User;
use UsersTask\Exception\EmailException;

class EmailSender implements EmailSenderInterface
{
    public function send(Mail $mail, User $user): void
    {
        if (!$user['email']) {
            throw new EmailException('Unable to send message, no email parameter.');
        }

        $message = $this->prepareMessage($user);
        Mail::to($mail->getRecipient())
            ->cc($mail->getCc())
            ->subject($mail->getSubject())
            ->queue($message);

    }

    /**
     * @param User $user
     * @return string
     */
    protected function prepareMessage(User $user): string
    {
        return  'Account has beed created. You can log in as <b>' . $user->getEmail() . '</b>';
    }
}