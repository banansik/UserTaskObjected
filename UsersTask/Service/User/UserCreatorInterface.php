<?php
declare(strict_types=1);

namespace UsersTask\Service\User;

use UsersTask\Entity\User;

interface UserCreatorInterface
{
    public function create(array $users): void;

    /**
     * @param array $users
     * @return array
     *
     * returns array of @param User
     */
    public function createStructuredUsers(array $users): array;
}