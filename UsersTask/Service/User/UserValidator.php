<?php
declare(strict_types=1);

namespace UsersTask\Service\User;

use UsersTask\Entity\User;
use UsersTask\Exception\DuplicateFieldValueException;
use UsersTask\Exception\UserNameException;
use UsersTask\Exception\UserNotFoundException;
use UserTask\Repository\UserRepositoryInterface;

class UserValidator implements UserValidatorInterface
{
    private UserRepositoryInterface $userRepository;

    /**
     * UserValidator constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validateNewUser(User $user): void
    {
        $this->checkUserNameLength($user);

        $this->checkLoginUniqueness($user);
    }

    public function validateUserUpdate(User $user): void
    {
        $this->checkUserNameLength($user);

        $this->checkIfUserExist($user);
    }

    /**
     * @param User $user
     * @throws DuplicateFieldValueException
     */
    private function checkLoginUniqueness(User $user): void
    {
        $userNameCounter = $this->userRepository->countUserLogin($user->getLogin());

        if ($userNameCounter > 0) {
            throw new DuplicateFieldValueException('Username taken');
        }
    }

    /**
     * @param User $user
     * @throws DuplicateFieldValueException
     */
    private function checkIfUserExist(User $user): void
    {
        $userNameCounter = $this->userRepository->countUserLogin($user->getLogin());

        if (!$userNameCounter) {
            throw new UserNotFoundException('Login not found.');
        }

    }

    /**
     * @param User $user
     * @throws UserNameException
     */
    private function checkUserNameLength(User $user): void
    {
        if ($user->getName() < 10) {
            throw new UserNameException('Username should be at least 10 characters long');
        }
    }
}