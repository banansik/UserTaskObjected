<?php
declare(strict_types=1);

namespace UserTask\Repository;

use UsersTask\Entity\User;

interface UserRepositoryInterface
{
    public function saveUser(User $user): void;

    public function saveUsers(array $users): void;

    public function updateUser(User $user): void;

    public function updateUsers(array $users): void;

    public function countUserLogin(string $login): int;
}