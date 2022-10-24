<?php
declare(strict_types=1);

namespace UsersTask\Service\User;

use UsersTask\Entity\User;
use UserTask\Repository\UserRepositoryInterface;

class UserUpdater implements UserUpdaterInterface
{
    private UserRepositoryInterface $userRepository;

    private UserValidatorInterface $userValidator;

    private UserCreatorInterface $userCreator;

    private UserUpdaterInterface $userUpdater;

    /**
     * UserUpdater constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserValidatorInterface $userValidator
     * @param UserCreatorInterface $userCreator
     */
    public function __construct(UserRepositoryInterface $userRepository, UserValidatorInterface $userValidator, UserCreatorInterface $userCreator)
    {
        $this->userRepository = $userRepository;
        $this->userValidator = $userValidator;
        $this->userCreator = $userCreator;
    }

    public function update(array $users): void
    {
        $users = $this->userCreator->createStructuredUsers($users);

        foreach ($users as $user) {
            $this->userValidator->validateUserUpdate($user);
        }

        if (count($users) > 1) {
            $this->userRepository->saveUsers($users);

            return;
        }

        $this->userRepository->saveUser($users[0]);
    }
}