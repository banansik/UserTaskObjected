<?php
declare(strict_types=1);

namespace UsersTask\Service\User;

use UsersTask\Entity\User;

interface UserValidatorInterface
{
    public function validateNewUser(User $user): void;

    public function validateUserUpdate(User $user): void;

}