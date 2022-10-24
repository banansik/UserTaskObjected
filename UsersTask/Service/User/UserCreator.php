<?php
declare(strict_types=1);

namespace UsersTask\Service\User;

use UsersTask\Entity\Mail;
use UsersTask\Entity\User;
use UsersTask\Service\Email\EmailSenderInterface;
use UserTask\Repository\UserRepositoryInterface;

class UserCreator implements UserCreatorInterface
{
    private UserValidatorInterface $userValidator;

    private UserRepositoryInterface $userRepository;

    private EmailSenderInterface $mailService;

    /**
     * UserCreator constructor.
     * @param UserValidatorInterface $userValidator
     * @param UserRepositoryInterface $userRepository
     * @param EmailSenderInterface $mailService
     */
    public function __construct(
        UserValidatorInterface $userValidator,
        UserRepositoryInterface $userRepository,
        EmailSenderInterface $mailService
    ) {
        $this->userValidator = $userValidator;
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
    }

    public function create(array $users): void
    {
        $users = $this->createStructuredUsers($users);

        foreach ($users as $user) {
            $this->userValidator->validateNewUser($user);
        }

        if (count($users) > 1) {
            $this->userRepository->saveUsers($users);
            $this->notifyUsers($users);

            return;
        }

        $this->userRepository->saveUser($users[0]);
        $mail = $this->buildMail($user);
        $this->mailService->send($mail, $user);

    }

    /**
     * @param array $users
     * @return array
     */
    public function createStructuredUsers(array $users): array
    {
        $structuredUsers = [];

        foreach ($users as $user) {
            $structuredUser = new User();
            $structuredUser->setName($user['name']);
            $structuredUser->setEmail($user['email']);
            $structuredUser->setLogin($user['login']);
            $structuredUser->setPassword($user['password']);

            $structuredUsers[] = $structuredUser;
        }

        return $structuredUsers;
    }

    /**
     * @param array $users
     */
    protected function notifyUsers(array $users): void
    {
        foreach ($users as $user) {
            $mail = $this->buildMail($user);
            $this->mailService->send($mail, $user);
        }
    }

    /**
     * @param $user
     * @return Mail
     */
    protected function buildMail($user): Mail
    {
        $mail = new Mail();
        $mail->setRecipient($user->getEmail());
        $mail->setCc('support@company.com');
        $mail->setSubject('New account created');

        return $mail;
    }
}